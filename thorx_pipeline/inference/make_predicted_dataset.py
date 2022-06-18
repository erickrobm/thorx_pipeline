import sys
import os
import pandas as pd
import numpy as np

BASE_DIR = os.path.realpath(os.path.join(os.path.dirname(__file__), "..", ".."))
sys.path.append(BASE_DIR)
from thorx_pipeline import config
from thorx_pipeline.training.transformers import (
    DataPreprocessing,
    DataLabeling,
)
from tensorflow.keras.models import load_model
from tensorflow.keras.optimizers import Adam
from tensorflow.keras.utils import to_categorical

import logging

logger = logging.getLogger("make_predicted_dataset.py")
logger.setLevel(logging.INFO)

formatter = logging.Formatter("%(asctime)s:%(name)s:%(message)s")

file_handler = logging.FileHandler("thorx_predicted_dataset.log")
file_handler.setFormatter(formatter)
logger.addHandler(file_handler)

logger.info(f"Preprocessing image data and labels from raw dataset . . .")
print(f"Preprocessing image data and labels from raw dataset . . .")
df = pd.read_csv(
    config.RAW_DATASET_PATH + config.RAW_DATASET_NAME + config.MODEL_NAME + ".csv",
)

image_data = DataPreprocessing(config.IMG_RESOLUTION)
image_data = image_data.fit(df["images_path"])
image_data = np.asarray(image_data) / 255.0

image_label = DataLabeling()
image_label = image_label.fit(df["images_label"])
print(f". . . 20%")

logger.info(f"Loading model . . .")
print(f"Loading model . . .")
opt = Adam(lr=config.INIT_LR, decay=config.DECAY)
loaded_model = load_model(config.MODEL_PATH + config.MODEL_NAME + ".h5")
# loaded_model.compile(optimizer='adam', loss='sparse_categorical_crossentropy', metrics=['accuracy'])
loaded_model.compile(optimizer=opt, loss="binary_crossentropy", metrics=["accuracy"])
print(f". . . 40%")

logger.info(f"Making the model to predict data . . .")
print(f"Making the model to predict data . . .")
model_prediction = loaded_model.predict(image_data, batch_size=config.BS)
model_prediction = np.argmax(model_prediction, axis=1)
print(f". . . 60%")

logger.info(f"Switching predicted data to tags instead of numbers . . .")
print(f"Switching predicted data to tags instead of numbers . . .")
prediction = []
for i in range(len(model_prediction)):
    if model_prediction[i] == 0:
        prediction.append("covid")
    if model_prediction[i] == 1:
        prediction.append("normal")
    if model_prediction[i] == 2:
        prediction.append("pneumonia")
print(f". . . 80%")

logger.info(f"Creating predict column and attach into the raw dataset. . .")
print(f"Creating predict column and attach into the raw dataset. . .")
predicted_targets = pd.DataFrame(
    prediction,
    columns=(["predicted_label"]),
)
predicted_dataset = pd.concat(
    [df["images_path"], df["images_label"], predicted_targets], axis=1, join="inner"
)
predicted_dataset.to_csv(
    config.PREDICTED_DATASET_PATH
    + config.PREDICTED_DATASET_NAME
    + config.MODEL_NAME
    + ".csv",
    index=False,
)
logger.info(
    f"{config.PREDICTED_DATASET_NAME + config.MODEL_NAME}.csv created correctly, located at: {config.PREDICTED_DATASET_PATH}"
)
print(
    f"{config.PREDICTED_DATASET_NAME + config.MODEL_NAME}.csv created correctly, located at: {config.PREDICTED_DATASET_PATH}"
)
print(f". . . 100%")
