import os

BASE_DIR = os.path.realpath(os.path.join(os.path.dirname(__file__), "..", ".."))

RAW_DATASET_PATH = BASE_DIR + "/datasets/raw_dataset/"
RAW_DATASET_NAME = "raw_data_"
PREDICTED_DATASET_PATH = BASE_DIR + "/datasets/predicted_dataset/"
PREDICTED_DATASET_NAME = "predicted_data_"

PNEUMONIA_PATH = BASE_DIR + "/COVID-19_Radiography_Dataset/Viral Pneumonia/images/"
COVID_19_PATH = BASE_DIR + "/COVID-19_Radiography_Dataset/COVID/images/"
LUNG_OPACITY_PATH = BASE_DIR + "/COVID-19_Radiography_Dataset/Lung_Opacity/images/"
NORMAL_PATH = BASE_DIR + "/COVID-19_Radiography_Dataset/Normal/images/"

MODEL_PATH = BASE_DIR + "/models/"
MODEL_NAME = "VGG16_8020_64_1536_EJEMPLO5EPOCHS"

ACCURACY_PATH = BASE_DIR + "/reports/accuracy/"
LOSS_PATH = BASE_DIR + "/reports/loss/"
ACCURACY_LOSS_PATH = BASE_DIR + "/reports/accuracy_loss/"
CONFUSION_MATRIX_PATH = BASE_DIR + "/reports/confusion_matrix/"

LABELS = [
    "Viral Pneumonia",
    "COVID-19",
    "NORMAL",
]
CLASSES = [
    "COVID-19",
    "NORMAL",
    "Viral Pneumonia",
    "No Coincide",
]

SAMPLES = 100

TEST_SIZE = 0.2
VALIDATION_SIZE = 0.15
VALIDATION_SPLIT = 0.15

IMG_RESOLUTION = (64, 64)
WIDTH = 64
HEIGHT = 64

ROTATION_RANGE = 15
BS = 32
EPOCHS = 5

SEED = 42
SEED_MODEL = 42
SEED_SPLIT = 42
SEED_VALIDATION = 82

INIT_LR = 1e-3
DECAY = 1e-6

