# ThorX Project
ThorX Machine Learning Enterprise Model.

## If you are using your GPU, follow this steps:

### About the Virual Environment

* Download the latest version of **Visual Studio** with an architecture compatible with your PC on: https://docs.microsoft.com/en-US/cpp/windows/latest-supported-vc-redist?view=msvc-170
* Download the **Anaconda Distribution** on: https://www.anaconda.com/products/distribution
* Once its dowloaded, open the **Anaconda Prompt** and create the **Anaconda Virtual Environment** with `conda create -n <name> python==3.8.8`. Feel free to select a name for the environment.
* Open the environment with `conda activate <name>`
* Install **CudaToolKit** and **Cudnn** with `conda install cudatoolkit=11.0 cudnn=8.0 -c=conda-forge`
* Install **Tensorflow-Gpu** with `pip install --upgrade tensorflow-gpu==2.4.1`

### How to verify if Tensorflow-GPU is correctly installed?

* On the **Anaconda Prompt** type `python`
* You may be able to run python scripts now, we´ll type the following lines:
* `import tensorflow as tf`
* `tf.test.is_gpu_available()`
* Once it finishes, you may be able to read at the end if it´s `True` that you´re using your GPU.

## If you aren´t using a GPU, follow this steps:

### About the Virual Environment

* Download the **Anaconda Distribution** on: https://www.anaconda.com/products/distribution
* Once its dowloaded, open the **Anaconda Prompt** and create the **Anaconda Virtual Environment** with `conda create -n <name> python==3.8.8`. Feel free to select a name for the environment.
* Open the environment with `conda activate <name>`
* Install **Tensorflow** with `pip install --upgrade tensorflow==2.4.1`

## Installing the libraries 
* Once you have completed the previous steps, and still using the **Anaconda Prompt**, go to the folder `/thorx_pipeline`.
* Install all the libraries in the **Virtual Environment** with `pip install -r requirements.txt`

## About running the project (from now and on, we are only going to use Anaconda Prompt)

### Creating a Raw Dataset

* The first step is to modify some variables located in `/thorx_pipelines/config/config.py` 

    **We highly recomend to only modify the following variables:**
    ```
    - MODEL_NAME
    - TEST_SIZE 
    - VALIDATION_SIZE
    - VALIDATION_SPLIT
    - IMG_RESOLUTION
    - WIDTH
    - HEIGHT
    - BS
    - EPOCHS
    ```

* Once you modify the variables, create a **Raw Dataset** with the **images path** and the **original labels** typping `cd /thorx_pipelines/data` in the **Anaconda Prompt**, and then, run the **make_raw_dataset.py** file with `python make_raw_dataset.py`

### Creating the Model 

* Go to the folder `/training` and then, run the **train_model.py** file with `python train_model.py` 
* It can take a while until it finishes all the process.

### Creating a Predicted Dataset

* Create a **Predicted Dataset** with the **images path**, the **original labels** and **predicted labels** typping `cd /thorx_pipelines/data` in the **Anaconda Prompt**, and then, run the **make_predicted_dataset.py** file with `python make_predicted_dataset.py`

### Predicting Images

* Go to the folder `/platform` and then, type in the **Anaconda Prompt**: `uvicorn service:app --reload`
* Install **Visual Studio Code** on: https://code.visualstudio.com/, and then, download the `"PHP Server"` extension.
* On **Visual Studio Code**, go to the `/thorx_platform` and then select the `forum.php` file.
* Once opened, right click into the code displayed and then, it should appear a list. Select the `PHP Server: Serve Project`






