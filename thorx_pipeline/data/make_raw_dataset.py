import sys
import os
import pandas as pd

BASE_DIR = os.path.realpath(os.path.join(os.path.dirname(__file__), "..", ".."))
sys.path.append(BASE_DIR)
from thorx_pipeline import config
from thorx_pipeline.training.transformers import Files

import logging

logger = logging.getLogger("make_raw_dataset.py")
logger.setLevel(logging.INFO)

formatter = logging.Formatter("%(asctime)s:%(name)s:%(message)s")

file_handler = logging.FileHandler("thorx_raw_dataset.log")
file_handler.setFormatter(formatter)
logger.addHandler(file_handler)

logger.info(f"Loading file paths . . .")
print(f"Loading file paths . . .")
load_files = Files(config.SAMPLES, config.SEED)

image_paths = load_files.file_paths(
    config.PNEUMONIA_PATH,
    config.COVID_19_PATH,
    config.NORMAL_PATH,
)
print(f". . . 33.3%")

logger.info(f"Loading image labels . . .")
print(f"Loading image labels . . .")
image_labels = load_files.file_labels(image_paths)
print(f". . . 66.7%")

logger.info(f"Creating raw dataset . . .")
print(f"Creating raw dataset . . .")
df_images_path = pd.DataFrame(
    image_paths,
    columns=(["images_path"]),
)

df_original_targets = pd.DataFrame(
    image_labels,
    columns=(["images_label"]),
)

covid_db_df = pd.concat(
    [df_images_path, df_original_targets],
    axis=1,
    join="inner",
)

covid_db_df.to_csv(
    config.RAW_DATASET_PATH + config.RAW_DATASET_NAME + config.MODEL_NAME + ".csv",
    index=False,
)

logger.info(
    f"{config.RAW_DATASET_NAME + config.MODEL_NAME}.csv created correctly, located at: {config.RAW_DATASET_PATH}"
)
print(
    f"{config.RAW_DATASET_NAME + config.MODEL_NAME}.csv created correctly, located at: {config.RAW_DATASET_PATH}"
)
print(f". . . 100%")
