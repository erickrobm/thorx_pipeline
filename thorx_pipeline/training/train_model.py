import sys
import os

BASE_DIR = os.path.realpath(os.path.join(os.path.dirname(__file__), "..", ".."))
sys.path.append(BASE_DIR)

from thorx_pipeline import config
from thorx_pipeline.training.transformers import (
    DataPreprocessing,
    DataLabeling,
    Headmodel,
    ModelChart,
    ModelEvaluation,
)
from tensorflow.keras.preprocessing.image import ImageDataGenerator
from sklearn.pipeline import Pipeline
from tensorflow.keras import layers
from tensorflow.keras.applications import VGG16
from tensorflow.keras.callbacks import (
    EarlyStopping,
    ModelCheckpoint,
)
from sklearn.metrics import (
    classification_report,
    accuracy_score,
    confusion_matrix,
)
from sklearn.model_selection import train_test_split
from tensorflow.keras.optimizers import Adam
from tensorflow.keras.models import Model
import pandas as pd
import numpy as np
import tensorflow as tf
import logging

logger = logging.getLogger("train_model.py")
logger.setLevel(logging.INFO)

formatter = logging.Formatter("%(asctime)s:%(name)s:%(message)s")

file_handler = logging.FileHandler("thorx_training_model.log")
file_handler.setFormatter(formatter)
logger.addHandler(file_handler)

def train():
    logger.info(f"Compiling model pipelines . . .")
    print(f"Compiling model pipelines . . .")
    numerical_transformer = Pipeline(
        steps=[
            ("data_preprocessing", DataPreprocessing(config.IMG_RESOLUTION)),
        ]
    )
    categorical_transformer = Pipeline(
        steps=[
            ("data_labeling", DataLabeling()),
        ]
    )
    model_transformer = Pipeline(
        steps=[
            ("model_output", Headmodel()),
        ]
    )
    print(f". . . 20%")

    logger.info(f"Preprocessing image data and labels . . .")
    print(f"Preprocessing image data and labels . . .")
    df = pd.read_csv(
        config.RAW_DATASET_PATH + config.RAW_DATASET_NAME + config.MODEL_NAME + ".csv",
    )

    image_data = numerical_transformer.fit(df["images_path"])
    image_data = np.asarray(numerical_transformer.transform(image_data)) / 255.0

    image_label = categorical_transformer.fit(df["images_label"])
    image_label = image_label.transform(image_label)
    print(f". . . 40%")

    logger.info(f"Creating train, test and validation data . . .")
    print(f"Creating train, test and validation data . . .")
    datagen = ImageDataGenerator(
        fill_mode="nearest",
        rotation_range=config.ROTATION_RANGE,
        validation_split=config.VALIDATION_SPLIT,
    )

    X_train, X_test, y_train, y_test = train_test_split(
        image_data,
        image_label,
        test_size=config.TEST_SIZE,
        random_state=config.SEED_SPLIT,
    )

    train_generator = datagen.flow(
        X_train,
        y_train,
        batch_size=config.BS,
        shuffle=False,
        sample_weight=None,
        save_to_dir=None,
        subset=None,
    )

    X_train, X_val, y_train, y_val = train_test_split(
        X_train,
        y_train,
        test_size=config.VALIDATION_SIZE,
        random_state=config.SEED_VALIDATION,
    )

    valid_generator = datagen.flow(
        X_val,
        y_val,
        batch_size=config.BS,
        shuffle=False,
        sample_weight=None,
        save_to_dir=None,
        subset=None,
    )
    print(f". . . 60%")

    logger.info(f"Compiling model input and output . . .")
    print(f"Compiling model input and output . . .")
    basemodel = VGG16(
        weights="imagenet",
        include_top=False,
        input_tensor=layers.Input(shape=(config.WIDTH, config.HEIGHT, 3)),
    )

    
    for layer in basemodel.layers:
        layers.trainable = False

        

    headmodel = model_transformer.fit(basemodel)
    headmodel = headmodel.transform(headmodel)

    model = Model(inputs=basemodel.input, outputs=headmodel)

    earlystopping = EarlyStopping(
        monitor="val_loss", mode="min", verbose=1, patience=20
    )

    checkpointer = ModelCheckpoint(
        filepath=config.MODEL_PATH + config.MODEL_NAME + ".h5",
        verbose=1,
        save_best_only=True,
    )

    opt = Adam(lr=config.INIT_LR, decay=config.DECAY)

    model.compile(optimizer=opt, loss="binary_crossentropy", metrics=["accuracy"])

    with tf.device("/gpu:0"):
        print("Training the model with GPU . . .")
        history = model.fit(
            train_generator,
            steps_per_epoch=train_generator.n // config.BS,
            validation_data=valid_generator,
            validation_steps=valid_generator.n // config.BS,
            epochs=config.EPOCHS,
            callbacks=[checkpointer, earlystopping],
            shuffle=False,
        )

    model.save(config.MODEL_PATH + config.MODEL_NAME + ".h5")
    print(f". . . 80%")

    logger.info(f"Creating model reports . . .")
    print(f"Creating model reports . . .")
    model_plot = ModelChart(history, config.MODEL_NAME, config.EPOCHS)
    model_plot.loss_accuracy_chart(config.ACCURACY_LOSS_PATH)
    model_plot.accuracy_chart(config.ACCURACY_PATH)
    model_plot.loss_chart(config.LOSS_PATH)

    logger.info(f"Creating the classification report of test data . . .")
    print(f"Creating the classification report of test data . . .")
    test_datagen = ImageDataGenerator (
    )

    test_generator = test_datagen.flow (
        X_test,
        y_test,
        batch_size=config.BS,
        shuffle=False,   
        sample_weight=None,
        save_to_dir=None,
        subset=None,
    )

    test_prediction = model.predict(test_generator, verbose = 1)
    test_prediction = np.argmax(test_prediction, axis=1)

    logger.info(f"Creating the confusion matrix test data . . .")
    print(f"Creating the confusion matrix test data . . .")
    conf_matrix = confusion_matrix(y_test.argmax(axis=1), test_prediction)
    print(f". . . 90%")

    logger.info(f"Displaying model parameters . . .")
    print(f"Displaying model parameters . . .")
    logger.info(
        classification_report(
            y_test.argmax(axis=1), test_prediction, target_names=config.LABELS
        )
    )
    print(
        classification_report(
            y_test.argmax(axis=1), test_prediction, target_names=config.LABELS
        )
    )

    model = ModelEvaluation(conf_matrix, config.MODEL_NAME)
    model.confusion_matrix(config.CONFUSION_MATRIX_PATH, config.LABELS)

    TP_pneumonia = conf_matrix[0, 0]
    FN_pneumonia = conf_matrix[0, 1] + conf_matrix[0, 2]
    FP_pneumonia = conf_matrix[1, 0] + conf_matrix[2, 0]
    TN_pneumonia = (
        conf_matrix[1, 1]
        + conf_matrix[1, 2]
        + conf_matrix[2, 1]
        + conf_matrix[2, 2]
    )
    sensit_pneumonia = TP_pneumonia / (TP_pneumonia + FN_pneumonia)
    spec_pneumonia = TN_pneumonia / (FP_pneumonia + TN_pneumonia)
    prec_pneumonia = TP_pneumonia / (TP_pneumonia + FP_pneumonia)
    fscore_pneumonia = (
        2
        * (sensit_pneumonia * prec_pneumonia)
        / (sensit_pneumonia + prec_pneumonia)
    )
    TP_covid = conf_matrix[1, 1]
    FN_covid = conf_matrix[1, 0] + conf_matrix[1, 2]
    FP_covid = conf_matrix[0, 1] + conf_matrix[2, 1]
    TN_covid = (
        conf_matrix[0, 0]
        + conf_matrix[0, 2]
        + conf_matrix[2, 0]
        + conf_matrix[2, 2]
    )
    sensit_covid = TP_covid / (TP_covid + FN_covid)
    spec_covid = TN_covid / (FP_covid + TN_covid)
    prec_covid = TP_covid / (TP_covid + FP_covid)
    fscore_covid = 2 * (sensit_covid * prec_covid) / (sensit_covid + prec_covid)
    TP_normal = conf_matrix[2, 2]
    FN_normal = conf_matrix[2, 0] + conf_matrix[2, 1]
    FP_normal = conf_matrix[0, 2] + conf_matrix[1, 2]
    TN_normal = (
        conf_matrix[0, 0]
        + conf_matrix[0, 1]
        + conf_matrix[1, 0]
        + conf_matrix[1, 1]
    )
    sensit_normal = TP_normal / (TP_normal + FN_normal)
    spec_normal = TN_normal / (FP_normal + TN_normal)
    prec_normal = TP_normal / (TP_normal + FP_normal)
    fscore_normal = (
        2 * (sensit_normal * prec_normal) / (sensit_normal + prec_normal)
    )
    accuracy = (
        conf_matrix[0, 0] + conf_matrix[1, 1] + conf_matrix[2, 2]
    ) / sum(sum(conf_matrix))
    logger.info("Test Model Accuracy: {:.4f}".format(accuracy))
    logger.info(f". . .")
    logger.info("Viral Pneumonia Sensitivity: {:.4f}".format(sensit_pneumonia))
    logger.info("Viral Pneumonia Specificity: {:.4f}".format(spec_pneumonia))
    logger.info("Viral Pneumonia Precision: {:.4f}".format(prec_pneumonia))
    logger.info("Viral Pneumonia F1-Score: {:.4f}".format(fscore_pneumonia))
    logger.info(f". . .")
    logger.info("COVID-19 Sensitivity: {:.4f}".format(sensit_covid))
    logger.info("COVID-19 Specificity: {:.4f}".format(spec_covid))
    logger.info("COVID-19 Precision: {:.4f}".format(prec_covid))
    logger.info("COVID-19 F1-Score: {:.4f}".format(fscore_covid))
    logger.info(f". . .")
    logger.info("NORMAL Sensitivity: {:.4f}".format(sensit_normal))
    logger.info("NORMAL Specificity: {:.4f}".format(spec_normal))
    logger.info("NORMAL Precision: {:.4f}".format(prec_normal))
    logger.info("NORMAL F1-Score: {:.4f}".format(fscore_normal))
    
    model.parameters()
    print(f". . . 100%")


if __name__ == "__main__":
    train()
