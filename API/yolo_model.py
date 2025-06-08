from ultralytics import YOLO
model = YOLO('best.pt')
results = model('D:\Semester 4\API_AI_RPL\images (1).jpg')

# # Check if there are any detections
# has_detection = len(results[0].boxes) > 0
# print(has_detection)