from sklearn.preprocessing import LabelEncoder
from sklearn.base import BaseEstimator, TransformerMixin
from tensorflow.keras.utils import to_categorical
from tensorflow.keras import layers
from tensorflow.keras.regularizers import l2


import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import seaborn as sns
import glob
import cv2
import random


class Files:
    def __init__(self, samples: int, random_seed: int):
        self.samples = samples
        self.random_seed = random_seed
        self.pneumonia_path = str
        self.covid19_path = str
        self.normal_path = str
        self.array = []

    def file_paths(self, pneumonia_path=str, covid19_path=str, normal_path=str):
        pneumonia_paths = glob.glob(pneumonia_path + "/*")
        covid19_paths = glob.glob(covid19_path + "/*")
        normal_paths = glob.glob(normal_path + "/*")

        random.seed(self.random_seed)
        random.shuffle(pneumonia_paths)
        random.shuffle(covid19_paths)
        random.shuffle(normal_paths)

        images_paths = (
            pneumonia_paths[: self.samples]
            + covid19_paths[: self.samples]
            + normal_paths[: self.samples]
        )
        return images_paths

    def file_labels(self, images_paths: list):
        for i in range(len(images_paths)):
            if i < len(images_paths) / 3:
                self.array.append("pneumonia")
            if i >= len(images_paths) / 3 and i < (len(images_paths) * (2 / 3)):
                self.array.append("covid")
            if i >= (len(images_paths) * (2 / 3)):
                self.array.append("normal")
        return self.array


class DataPreprocessing(BaseEstimator, TransformerMixin):
    def __init__(self, img_resolution: list):
        self.img_resolution = img_resolution
        self.array = []

    def fit(self, filepath: list, y=0):
        for i in range(len(filepath)):
            image = cv2.imread(filepath[i])
            image = cv2.cvtColor(image, cv2.COLOR_BGR2RGB)
            image = cv2.resize(image, self.img_resolution)
            self.array.append(image)
        return self.array

    def transform(self, filepath: list, y=0):
        return self.array


class DataLabeling(BaseEstimator, TransformerMixin):
    def __init__(self):
        self.one_hot_encod = []

    def fit(self, labels: list, y=0):
        label_encoder = LabelEncoder()
        self.one_hot_encod = label_encoder.fit_transform(labels)
        self.one_hot_encod = to_categorical(self.one_hot_encod)
        return self.one_hot_encod

    def transform(self, labels: list, y=0):
        return self.one_hot_encod


class Headmodel(BaseEstimator, TransformerMixin):
    def __init__(self):
        self.headmodel_output = self

    def fit(self, basemodel, y=0):
        headmodel_input = basemodel.output

        flat = layers.Flatten(name="flatten")(headmodel_input)
        dense1 = layers.Dense(
            64, kernel_regularizer=l2(0.0025), bias_regularizer=l2(0.0025)
        )(flat)
        activation1 = layers.Activation("relu")(dense1)
        dropout1 = layers.Dropout(0.15)(activation1)
        conv1 = layers.BatchNormalization(momentum=0.1)(dropout1)
        dense2 = layers.Dense(64, activation="tanh")(conv1)
        dropout2 = layers.Dropout(0.25)(dense2)
        self.headmodel_output = layers.Dense(3, activation="softmax")(dropout2)
        return self.headmodel_output

    def transform(self, basemodel, y=0):
        return self.headmodel_output


class ModelChart:
    def __init__(self, history, model_name: str, epochs: int):
        self.history = history
        self.model_name = model_name
        self.epochs = epochs

    def loss_accuracy_chart(self, path: str):
        plt.style.use("ggplot")
        plt.figure(figsize=(10, 8))
        plt.plot(self.history.history["loss"], label="train_loss")
        plt.plot(self.history.history["val_loss"], label="val_loss")
        plt.plot(self.history.history["accuracy"], label="train_acc")
        plt.plot(self.history.history["val_accuracy"], label="val_acc")
        plt.title("Model Training Loss and Accuracy: " + self.model_name)
        plt.xlabel("Epochs #")
        plt.ylabel("Loss/Accuracy")
        plt.legend(loc="lower left")
        plt.savefig(path + "loss_accuracy_" + self.model_name + ".png")
        plt.show()

    def accuracy_chart(self, path: str):
        plt.style.use("ggplot")
        plt.figure(figsize=(10, 8))
        plt.plot(self.history.history["accuracy"])
        plt.plot(self.history.history["val_accuracy"])
        plt.title("Model Accuracy: " + self.model_name)
        plt.ylabel("Accuracy")
        plt.xlabel("Epochs #")
        plt.legend(["train", "validation"], loc="lower right")
        plt.savefig(path + "accuracy_" + self.model_name + ".png")
        plt.show()

    def loss_chart(self, path: str):
        plt.style.use("ggplot")
        plt.figure(figsize=(10, 8))
        plt.plot(self.history.history["loss"])
        plt.plot(self.history.history["val_loss"])
        plt.title("Model Loss:" + self.model_name)
        plt.ylabel("Loss")
        plt.xlabel("Epochs #")
        plt.legend(["train", "validation"], loc="upper left")
        plt.savefig(path + "loss_" + self.model_name + ".png")
        plt.show()


class ModelEvaluation:
    def __init__(self, conf_matrix: np.asarray, model_name: str):
        self.conf_matrix = conf_matrix
        self.model_name = model_name

    def confusion_matrix(self, path: str, labels: list):
        df_cm = pd.DataFrame(self.conf_matrix, columns=labels, index=labels)
        df_cm.index.name = "Original"
        df_cm.columns.name = "Predicted"
        plt.figure(figsize=(8, 8))
        plt.title("Confusion Matrix - " + self.model_name)
        sns.heatmap(
            df_cm / np.sum(df_cm), fmt=".2%", annot=True, annot_kws={"size": 16}
        )
        plt.savefig(path + "confusion_matrix_" + self.model_name + ".png")
        plt.show()

    def parameters(self):
        TP_pneumonia = self.conf_matrix[0, 0]
        FN_pneumonia = self.conf_matrix[0, 1] + self.conf_matrix[0, 2]
        FP_pneumonia = self.conf_matrix[1, 0] + self.conf_matrix[2, 0]
        TN_pneumonia = (
            self.conf_matrix[1, 1]
            + self.conf_matrix[1, 2]
            + self.conf_matrix[2, 1]
            + self.conf_matrix[2, 2]
        )

        sensit_pneumonia = TP_pneumonia / (TP_pneumonia + FN_pneumonia)
        spec_pneumonia = TN_pneumonia / (FP_pneumonia + TN_pneumonia)
        prec_pneumonia = TP_pneumonia / (TP_pneumonia + FP_pneumonia)
        fscore_pneumonia = (
            2
            * (sensit_pneumonia * prec_pneumonia)
            / (sensit_pneumonia + prec_pneumonia)
        )

        TP_covid = self.conf_matrix[1, 1]
        FN_covid = self.conf_matrix[1, 0] + self.conf_matrix[1, 2]
        FP_covid = self.conf_matrix[0, 1] + self.conf_matrix[2, 1]
        TN_covid = (
            self.conf_matrix[0, 0]
            + self.conf_matrix[0, 2]
            + self.conf_matrix[2, 0]
            + self.conf_matrix[2, 2]
        )

        sensit_covid = TP_covid / (TP_covid + FN_covid)
        spec_covid = TN_covid / (FP_covid + TN_covid)
        prec_covid = TP_covid / (TP_covid + FP_covid)
        fscore_covid = 2 * (sensit_covid * prec_covid) / (sensit_covid + prec_covid)

        TP_normal = self.conf_matrix[2, 2]
        FN_normal = self.conf_matrix[2, 0] + self.conf_matrix[2, 1]
        FP_normal = self.conf_matrix[0, 2] + self.conf_matrix[1, 2]
        TN_normal = (
            self.conf_matrix[0, 0]
            + self.conf_matrix[0, 1]
            + self.conf_matrix[1, 0]
            + self.conf_matrix[1, 1]
        )

        sensit_normal = TP_normal / (TP_normal + FN_normal)
        spec_normal = TN_normal / (FP_normal + TN_normal)
        prec_normal = TP_normal / (TP_normal + FP_normal)
        fscore_normal = (
            2 * (sensit_normal * prec_normal) / (sensit_normal + prec_normal)
        )

        accuracy = (
            self.conf_matrix[0, 0] + self.conf_matrix[1, 1] + self.conf_matrix[2, 2]
        ) / sum(sum(self.conf_matrix))
        print("Test Model Accuracy: {:.4f}".format(accuracy))
        print(f". . .")
        print("Viral Pneumonia Sensitivity: {:.4f}".format(sensit_pneumonia))
        print("Viral Pneumonia Specificity: {:.4f}".format(spec_pneumonia))
        print("Viral Pneumonia Precision: {:.4f}".format(prec_pneumonia))
        print("Viral Pneumonia F1-Score: {:.4f}".format(fscore_pneumonia))
        print(f". . .")
        print("COVID-19 Sensitivity: {:.4f}".format(sensit_covid))
        print("COVID-19 Specificity: {:.4f}".format(spec_covid))
        print("COVID-19 Precision: {:.4f}".format(prec_covid))
        print("COVID-19 F1-Score: {:.4f}".format(fscore_covid))
        print(f". . .")
        print("NORMAL Sensitivity: {:.4f}".format(sensit_normal))
        print("NORMAL Specificity: {:.4f}".format(spec_normal))
        print("NORMAL Precision: {:.4f}".format(prec_normal))
        print("NORMAL F1-Score: {:.4f}".format(fscore_normal))
