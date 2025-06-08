import torch
import torch.nn as nn
import pickle
from PIL import Image
from torchvision import transforms
from torchvision.models import resnet50
import os

def predict_skin_type(model_path, label_maps_path, image_path):
    """
    Simple function to predict skin type and return only the classification
    
    Args:
        model_path: Path t`o the saved model (.pth file)
        label_maps_path: Path to the saved label mappings (.pkl file)
        image_path: Path to the image to classify
        
    Returns:
        String: 'dry', 'normal', or 'oily'
    """
    # Set device
    device = torch.device("cuda" if torch.cuda.is_available() else "cpu")
    
    # Load label mappings
    with open(label_maps_path, 'rb') as f:
        label_data = pickle.load(f)
        index_label = label_data.get('index_label', {0: "dry", 1: "normal", 2: "oily"})
    
    # Load model
    model = resnet50(weights=None)
    model.fc = nn.Linear(model.fc.in_features, 3)  # 3 classes
    
    checkpoint = torch.load(model_path, map_location=device)
    if 'model_state_dict' in checkpoint:
        model.load_state_dict(checkpoint['model_state_dict'])
    elif 'state_dict' in checkpoint:
        model.load_state_dict(checkpoint['state_dict'])
    else:
        model.load_state_dict(checkpoint)
    
    model = model.to(device)
    model.eval()
    
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
    image = Image.open(image_path).convert('RGB')
    tensor = transform(image).unsqueeze(0).to(device)
    
    # Make prediction
    with torch.no_grad():
        outputs = model(tensor)
        predicted_class = torch.argmax(outputs, dim=1).item()
    
    return index_label[predicted_class]


# Example usage
if __name__ == "__main__":
    MODEL_PATH = r"D:\Semester 4\API_AI_RPL\best_skin_model_threepred.pth"
    LABEL_MAPS_PATH = r"D:\Semester 4\API_AI_RPL\label_maps.pkl"
    
    # Single image prediction
    image_path = r"D:\Semester 4\API_AI_RPL\images.jpg"  # Replace with your image path
    
    if os.path.exists(image_path):
        prediction = predict_skin_type(MODEL_PATH, LABEL_MAPS_PATH, image_path)
        print(prediction)
    else:
        print("Image file not found")
    
    # For multiple images
    
    # for img_path in image_paths:
    #     if os.path.exists(img_path):
    #         prediction = predict_skin_type(MODEL_PATH, LABEL_MAPS_PATH, img_path)
    #         print(f"{os.path.basename(img_path)}: {prediction}")
    #     else:
    #         print(f"{os.path.basename(img_path)}: file not found")