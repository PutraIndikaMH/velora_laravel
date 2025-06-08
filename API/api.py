import os
os.environ["KMP_DUPLICATE_LIB_OK"] = "TRUE"
from flask import Flask, request, jsonify
from flask_cors import CORS
import torch
from PIL import Image
import io
import base64

# Import skin_type.py functionality
import torch.nn as nn
import pickle
from torchvision import transforms
from torchvision.models import resnet50

# Import YOLO functionality
from ultralytics import YOLO

# Import chatbot functionality
from langchain_google_genai import ChatGoogleGenerativeAI, GoogleGenerativeAIEmbeddings
from langchain_community.document_loaders import Docx2txtLoader
from langchain.chains import LLMChain
from langchain.memory import ConversationBufferMemory
from langchain.prompts import ChatPromptTemplate, MessagesPlaceholder, HumanMessagePromptTemplate, SystemMessagePromptTemplate
from langchain_community.vectorstores import FAISS
from langchain.text_splitter import RecursiveCharacterTextSplitter

app = Flask(__name__)
CORS(app)

# Set up configurations for file uploads
UPLOAD_FOLDER = 'uploads'
if not os.path.exists(UPLOAD_FOLDER):
    os.makedirs(UPLOAD_FOLDER)

# Global variables for models
chatbot_initialized = False
chatbot_memory = None
chatbot_rag_chain = None
chatbot_vector_db = None
skin_model = None
yolo_model = None

# Configure paths
MODEL_PATH = r"D:\Semester 4\API_AI_RPL\best_skin_model_threepred.pth"
LABEL_MAPS_PATH = r"D:\Semester 4\API_AI_RPL\label_maps.pkl"
YOLO_MODEL_PATH = r"D:\Semester 4\API_AI_RPL\best.pt"
DOCUMENT_PATH = r"D:\Semester 4\API_AI_RPL\skincare_knowledge.docx"

# Function to initialize chatbot
def initialize_chatbot():
    global chatbot_initialized, chatbot_memory, chatbot_rag_chain, chatbot_vector_db
    
    if chatbot_initialized:
        return
    
    # Set Google API key
    os.environ["GOOGLE_API_KEY"] = "AIzaSyDfrsqAm8TVPLEa79LeweznvGnoQx5ldl0"
    
    # Step 1: Load Microsoft Word Document
    loader = Docx2txtLoader(DOCUMENT_PATH)
    documents = loader.load()
    
    # Step 2: Split document into chunks
    text_splitter = RecursiveCharacterTextSplitter(
        chunk_size=800,
        chunk_overlap=150,
        separators=["\n\n", "\n", "●", "•", "###", "##"]
    )
    chunks = text_splitter.split_documents(documents)
    
    # Step 3: Perform embeddings and define vector database
    embeddings = GoogleGenerativeAIEmbeddings(model="models/embedding-001")
    chatbot_vector_db = FAISS.from_documents(chunks, embeddings)
    
    # Step 4: Setup LLM with skincare consultant persona
    llm = ChatGoogleGenerativeAI(
        model="gemini-2.0-flash", 
        temperature=0.3,
        max_output_tokens=1024
    )
    
    # Initialize conversation memory
    chatbot_memory = ConversationBufferMemory(
        memory_key="chat_history",
        return_messages=True,
        input_key="question",
        output_key="output"
    )
    
    # Template system with placeholders for documents
    system_template = """
    Anda adalah AI Konsultan Skincare yang membantu pengguna berdasarkan dokumen pengetahuan skincare. 
    Pengguna saat ini memiliki tipe kulit {skin_type} dengan kondisi {skin_condition}. Berikut adalah pertanyaan pengguna:{question}
    Berikan jawaban yang ramah layaknya dengan teman, informatif, dan praktis dengan struktur berikut:

    

    **Jawaban**:
    - Analisis kebutuhan kulit pengguna
    - Rekomendasi produk/langkah berdasarkan dokumen
    - Jadwal penggunaan yang tepat
    - Peringatan keamanan (jika ada)

    Gunakan informasi dari dokumen berikut:
    {docs}

    Aturan penting:
    1. Jika pertanyaan di luar topik skincare, jawab "Maaf saya hanya bisa membantu soal skincare"
    2. Untuk kombinasi produk berisiko, BERI PERINGATAN TEKS KAPITAL
    3. Gunakan format Markdown untuk poin-poin
    4. Jelaskan istilah teknis dengan sederhana
    5. Selalu sarankan konsultasi dokter di akhir kalimat jika kondisi tidak membaik
    """
    
    # Create prompt template with memory
    prompt = ChatPromptTemplate(
        input_variables=["docs", "question", "skin_type", "skin_condition"],
        messages=[
            SystemMessagePromptTemplate.from_template(system_template),
            MessagesPlaceholder(variable_name="chat_history"),
            HumanMessagePromptTemplate.from_template("{question}")
        ]
    )
    
    # Create RAG chain with memory
    chatbot_rag_chain = LLMChain(
        llm=llm,
        prompt=prompt,
        memory=chatbot_memory,
        verbose=False,
        output_key="output"
    )
    
    chatbot_initialized = True

# Function to load skin type prediction model
def load_skin_model():
    global skin_model
    
    if skin_model is not None:
        return
    
    # Set device
    device = torch.device("cuda" if torch.cuda.is_available() else "cpu")
    
    # Load model
    model = resnet50(weights=None)
    model.fc = nn.Linear(model.fc.in_features, 3)  # 3 classes
    
    checkpoint = torch.load(MODEL_PATH, map_location=device)
    if 'model_state_dict' in checkpoint:
        model.load_state_dict(checkpoint['model_state_dict'])
    elif 'state_dict' in checkpoint:
        model.load_state_dict(checkpoint['state_dict'])
    else:
        model.load_state_dict(checkpoint)
    
    model = model.to(device)
    model.eval()
    
    skin_model = model

# Function to load YOLO model
def load_yolo_model():
    global yolo_model
    
    if yolo_model is not None:
        return
    
    yolo_model = YOLO(YOLO_MODEL_PATH)

# Function to predict skin type
def predict_skin_type(image_file):
    load_skin_model()
    
    # Set device
    device = torch.device("cuda" if torch.cuda.is_available() else "cpu")
    
    # Load label mappings
    with open(LABEL_MAPS_PATH, 'rb') as f:
        label_data = pickle.load(f)
        index_label = label_data.get('index_label', {0: "dry", 1: "normal", 2: "oily"})
    
    # Image preprocessing
    transform = transforms.Compose([
        transforms.Resize(256),
        transforms.CenterCrop(224),
        transforms.ToTensor(),
        transforms.Normalize(
            mean=[0.485, 0.456, 0.406],
            std=[0.229, 0.224, 0.225]
        )
    ])
    
    # Load and preprocess image
    image = Image.open(image_file).convert('RGB')
    tensor = transform(image).unsqueeze(0).to(device)
    
    # Make prediction
    with torch.no_grad():
        outputs = skin_model(tensor)
        predicted_class = torch.argmax(outputs, dim=1).item()
    
    return index_label[predicted_class]

# Routes
@app.route('/chatbot', methods=['POST'])
def chatbot_endpoint():
    try:
        initialize_chatbot()
        
        data = request.get_json()
        if not data or 'query' not in data:
            return jsonify({"error": "Missing 'query' field"}), 400
        
        query = data['query']
        skin_type = data['skin_type'];
        skin_condition = data["skin_condition"]
        # Get similar documents
        retrieved_docs = chatbot_vector_db.similarity_search(query, k=3)
        docs_content = "\n\n---\n\n".join([doc.page_content for doc in retrieved_docs])
        
        # Run RAG chain with memory
        response = chatbot_rag_chain.invoke({
            "docs": docs_content,
            "question": query,
            "skin_type": skin_type,
            "skin_condition": skin_condition
        })
        
        return jsonify({"response": response['output']})
    except Exception as e:
        return jsonify({"error": str(e)}), 500

@app.route('/predict-skin-type', methods=['POST'])
def predict_skin_type_endpoint():
    try:
        if 'image' not in request.files:
            return jsonify({"error": "No image provided"}), 400
        
        image_file = request.files['image']
        if image_file.filename == '':
            return jsonify({"error": "No selected image"}), 400
        
        # Save the uploaded file
        image_path = os.path.join(UPLOAD_FOLDER, image_file.filename)
        image_file.save(image_path)
        
        # Process with skin type prediction
        skin_type = predict_skin_type(image_path)
        
        return jsonify({
            "skin_type": skin_type
        })
    except Exception as e:
        return jsonify({"error": str(e)}), 500

@app.route('/detect-objects', methods=['POST'])
def detect_objects_endpoint():
    try:
        load_yolo_model()
        
        if 'image' not in request.files:
            return jsonify({"error": "No image provided"}), 400
        
        image_file = request.files['image']
        if image_file.filename == '':
            return jsonify({"error": "No selected image"}), 400
        
        # Save the uploaded file
        image_path = os.path.join(UPLOAD_FOLDER, image_file.filename)
        image_file.save(image_path)
        
        # Process with YOLO model
        results = yolo_model(image_path)
        
        # Process results
        detections = []
        for result in results:
            boxes = result.boxes
            for box in boxes:
                detection = {
                    "class": int(box.cls.item()),
                    "confidence": float(box.conf.item()),
                    "coordinates": box.xyxy.tolist()[0]
                }
                detections.append(detection)
        
        # Get the image with bounding boxes drawn
        annotated_frame = results[0].plot()  # This returns the image with bounding boxes
        
        # Convert to bytes
        from PIL import Image
        import cv2
        
        skin_condition = "Berjerawat" if len(detections) > 0 else "Tidak Berjerawat"


        # Convert BGR to RGB (OpenCV uses BGR, PIL uses RGB)
        annotated_frame_rgb = cv2.cvtColor(annotated_frame, cv2.COLOR_BGR2RGB)
        
        # Convert to PIL Image
        pil_image = Image.fromarray(annotated_frame_rgb)
        
        # Convert to bytes
        img_buffer = io.BytesIO()
        pil_image.save(img_buffer, format='JPEG')
        img_bytes = img_buffer.getvalue()
        
        return jsonify({
            "detections": detections,
            "detection_count": len(detections),
            "skin_condition": skin_condition,
            "image": base64.b64encode(img_bytes).decode('utf-8')
        })
    except Exception as e:
        return jsonify({"error": str(e)}), 500

@app.route('/reset-chatbot', methods=['POST'])
def reset_chatbot():
    global chatbot_memory
    
    if chatbot_memory:
        chatbot_memory.clear()
    
    return jsonify({"message": "Chatbot memory has been reset"})

@app.route('/health', methods=['GET'])
def health_check():
    return jsonify({"status": "API is running"})

if __name__ == '__main__':
    # Create upload directory if it doesn't exist
    if not os.path.exists(UPLOAD_FOLDER):
        os.makedirs(UPLOAD_FOLDER)
    
    app.run(debug=True, host='0.0.0.0', port=5000)