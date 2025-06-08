from langchain_google_genai import ChatGoogleGenerativeAI, GoogleGenerativeAIEmbeddings
from langchain_community.document_loaders import Docx2txtLoader
from langchain.chains import LLMChain
from langchain.memory import ConversationBufferMemory
from langchain.prompts import ChatPromptTemplate, MessagesPlaceholder, HumanMessagePromptTemplate, SystemMessagePromptTemplate
from langchain.vectorstores import FAISS
from langchain.text_splitter import RecursiveCharacterTextSplitter
from langchain_core.messages import SystemMessage
import os

# Step 1: Load Microsoft Word Document
loader = Docx2txtLoader("D:/Semester 4/API_AI_RPL/skincare_knowledge.docx")
documents = loader.load()

# Step 2: Split document into chunks
text_splitter = RecursiveCharacterTextSplitter(
    chunk_size=800,
    chunk_overlap=150,
    separators=["\n\n", "\n", "●", "•", "###", "##"]
)
chunks = text_splitter.split_documents(documents)

# Step 3: Perform embeddings and define vector database
os.environ["GOOGLE_API_KEY"] = "AIzaSyDfrsqAm8TVPLEa79LeweznvGnoQx5ldl0"
embeddings = GoogleGenerativeAIEmbeddings(model="models/embedding-001")
vector_db = FAISS.from_documents(chunks, embeddings)

# Step 4: Setup LLM with skincare consultant persona
llm = ChatGoogleGenerativeAI(
    model="gemini-2.0-flash", 
    temperature=0.3,
    max_output_tokens=1024
)

# Inisialisasi memori percakapan
memory = ConversationBufferMemory(
    memory_key="chat_history",
    return_messages=True,
    input_key="question",  # Menyesuaikan dengan input user
    output_key="output"    # Menyesuaikan dengan output AI
)

# Template sistem dengan placeholder untuk dokumen
system_template = """
Anda adalah AI Konsultan Skincare yang membantu pengguna berdasarkan dokumen pengetahuan skincare. 
Berikan jawaban yang ramah layaknya dengan teman, informatif, dan praktis dengan struktur berikut:

**Pertanyaan Pengguna**: {question}

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

# Buat prompt template dengan memori
prompt = ChatPromptTemplate(
    input_variables=["docs", "question"],
    messages=[
        SystemMessagePromptTemplate.from_template(system_template),
        MessagesPlaceholder(variable_name="chat_history"),
        HumanMessagePromptTemplate.from_template("{question}")
    ]
)

# Buat RAG chain dengan memori
rag_chain = LLMChain(
    llm=llm,
    prompt=prompt,
    memory=memory,
    verbose=False,  # Set True untuk debugging
    output_key="output"
)

# Continuous Loop for Chat-like Interaction
print("Selamat datang di Konsultan Skincare! (ketik 'exit' untuk keluar)")
print("=" * 60)

while True:
    try:
        # Step 5: Ambil input pengguna
        query = input("\nAnda: ")
        
        if query.lower() in ['exit', 'keluar', 'quit']:
            print("Terima kasih! Jaga selalu kesehatan kulit Anda :)")
            break

        # Step 6: Lakukan similarity search
        retrieved_docs = vector_db.similarity_search(query, k=3)
        
        # Step 7: Gabungkan konten dokumen
        docs_content = "\n\n---\n\n".join([doc.page_content for doc in retrieved_docs])
        
        # Step 8: Jalankan RAG chain dengan memori
        response = rag_chain.invoke({
            "docs": docs_content,
            "question": query
        })
        
        # Tampilkan respons
        print("\n" + "=" * 60)
        print(f"Konsultan: {response['output']}")
        print("=" * 60)

    except Exception as e:
        print(f"Terjadi error: {str(e)}")
        continue