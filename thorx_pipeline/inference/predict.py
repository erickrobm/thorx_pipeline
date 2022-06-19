import sys
import os

BASE_DIR = os.path.realpath(os.path.join(os.path.dirname(__file__), "..", ".."))
sys.path.append(BASE_DIR)

from thorx_pipeline import config
from pydantic import BaseModel
from fastapi import FastAPI, Depends, BackgroundTasks
from fastapi import requests
from fastapi.encoders import jsonable_encoder

from tensorflow.keras.models import load_model
from tensorflow.keras.optimizers import Adam
from skimage.metrics import structural_similarity as ssim

import pandas as pd
import numpy as np
import logging
import json
import cv2

logger = logging.getLogger(__name__)
logger.setLevel(logging.INFO)

formatter = logging.Formatter("%(asctime)s:%(name)s:%(message)s")

file_handler = logging.FileHandler("thorx_predictions.log")
file_handler.setFormatter(formatter)
logger.addHandler(file_handler)

class PredictionInput(BaseModel):
    image_path: str

class PredictionOutput(BaseModel):
    prediction: str

class ThorXModel:
    def load_model(self):
        """Loads the model"""
        self.loaded_model = load_model(config.MODEL_PATH + config.MODEL_NAME + ".h5")

    def predict(self, input: PredictionInput) -> PredictionOutput:
        """Runs a prediction"""
        if not self.loaded_model:
            raise RuntimeError("Model is not loaded . . .")

        image = str(input)
        image = image.split("=")
        image[1] = image[1].replace("'", "")

        original = cv2.imread("original.jpeg")
        contrast = cv2.imread(image[1])

        original = cv2.cvtColor(original, cv2.COLOR_BGR2GRAY)
        contrast = cv2.cvtColor(contrast, cv2.COLOR_BGR2GRAY)
        original = cv2.resize(original, config.IMG_RESOLUTION)
        contrast = cv2.resize(contrast, config.IMG_RESOLUTION)
        s = ssim(original, contrast)

        if s >= 0.1:
            image = cv2.imread(image[1])
            image = cv2.cvtColor(image, cv2.COLOR_BGR2RGB)
            image = image / 255.0
            image = cv2.resize(image, config.IMG_RESOLUTION)
            image = image.reshape(-1, config.WIDTH, config.HEIGHT, 3)

            opt = Adam(lr=config.INIT_LR, decay=config.DECAY)
            self.loaded_model.compile(
                optimizer=opt, loss="binary_crossentropy", metrics=["accuracy"]
            )
            prediction = self.loaded_model.predict(image, batch_size=config.BS)
            percent_pred_list = prediction
            prediction = np.argmax(prediction, axis=1)
            model_prediction = config.CLASSES[prediction[0]]

            if prediction == 0:
                r = {
                    "label": model_prediction,
                    "score": "{0:.2f}".format(percent_pred_list[0, 0] * 100),
                }
            elif prediction == 1:
                r = {
                    "label": model_prediction,
                    "score": "{0:.2f}".format(percent_pred_list[0, 1] * 100),
                }
            elif prediction == 2:
                r = {
                    "label": model_prediction,
                    "score": "{0:.2f}".format(percent_pred_list[0, 2] * 100),
                }
            else:
                r = {"label": model_prediction}

        if s < 0.1:
            prediction = 3

            model_prediction = config.CLASSES[prediction]
            r = {"label": model_prediction}

        results = {"input_raw": input.dict(), "prediction": model_prediction}
        logger.info(f"Prediction:{json.dumps(results)}")
        return PredictionOutput(prediction=model_prediction)

app = FastAPI()
thorx_model = ThorXModel()

@app.post("/prediction")
async def prediction(
    output: PredictionOutput = Depends(thorx_model.predict),
) -> PredictionOutput:
    return output

@app.on_event("startup")
async def startup():
    # Possible Log: Try and Except
    thorx_model.load_model()


