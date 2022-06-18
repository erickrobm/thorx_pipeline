import sys
import os

BASE_DIR = os.path.realpath(os.path.join(os.path.dirname(__file__), "..", "..", ".."))
sys.path.append(BASE_DIR)

import pytest
import pandas as pd
from thorx_pipeline.training.transformers import Files
from thorx_pipeline.config import config


def GetFiles():
    df = [
        config.PNEUMONIA_PATH,
        config.COVID_19_PATH,
        config.NORMAL_PATH,
    ]

    result = [
        config.PNEUMONIA_PATH,
        config.COVID_19_PATH,
        config.NORMAL_PATH,
    ]
    return [(df, result)]


def GetLabels():
    df = [
        config.PNEUMONIA_PATH,
        config.COVID_19_PATH,
        config.NORMAL_PATH,
    ]
    result = ["pneumonia", "covid", "normal"]
    return [(df, result)]


@pytest.mark.parametrize("df, result", GetFiles())
def test_pneumonia_file_paths(df, result):
    load_test_files = Files(1, config.SEED)
    test_result = load_test_files.file_paths(
        df[0],
        df[1],
        df[2],
    )
    load_result_files = Files(1, config.SEED_VALIDATION)
    result = load_result_files.file_paths(
        df[0],
        df[1],
        df[2],
    )
    assert test_result[0] == result[0]


@pytest.mark.parametrize("df, result", GetLabels())
def test_pneumonia_file_labels(df, result):
    load_files = Files(1, config.SEED)
    test_result = load_files.file_labels(df)

    assert test_result[0] == result[0]


@pytest.mark.parametrize("df, result", GetFiles())
def test_covid_file_paths(df, result):
    load_test_files = Files(1, config.SEED)
    test_result = load_test_files.file_paths(
        df[0],
        df[1],
        df[2],
    )
    load_result_files = Files(1, config.SEED_VALIDATION)
    result = load_result_files.file_paths(
        df[0],
        df[1],
        df[2],
    )
    assert test_result[1] == result[1]


@pytest.mark.parametrize("df, result", GetLabels())
def test_covid_file_labels(df, result):
    load_files = Files(1, config.SEED)
    test_result = load_files.file_labels(df)

    assert test_result[1] == result[1]


@pytest.mark.parametrize("df, result", GetFiles())
def test_normal_file_paths(df, result):
    load_test_files = Files(1, config.SEED)
    test_result = load_test_files.file_paths(
        df[0],
        df[1],
        df[2],
    )
    load_result_files = Files(1, config.SEED_VALIDATION)
    result = load_result_files.file_paths(
        df[0],
        df[1],
        df[2],
    )
    assert test_result[2] == result[2]


@pytest.mark.parametrize("df, result", GetLabels())
def test_normal_file_labels(df, result):
    load_files = Files(1, config.SEED)
    test_result = load_files.file_labels(df)

    assert test_result[2] == result[2]
