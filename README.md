# ThorX Project
ThorX Machine Learning Enterprise Model 

## About the Virual Environment with Tensowflow-GPU
* Download the latest version of Visual Studio with an architecture compatible with your PC on: https://docs.microsoft.com/en-US/cpp/windows/latest-supported-vc-redist?view=msvc-170
* Download the Anaconda Distribution on: https://www.anaconda.com/products/distribution
* Once its dowloaded, open the Anaconda Prompt and create the Anaconda Virtual Environment with `conda create -n <name> python==3.8.8`. Feel free to select a name for the environment.
* Open the environment with `conda activate <name>`.
* Install CudaToolKit and Cudnn with `conda install cudatoolkit=11.0 cudnn=8.0 -c=conda-forge`
* Install Tensorflow-Gpu with `pip install --upgrade tensorflow-gpu==2.4.1`

### How to verify if Tensorflow-GPU is correctly installed?
* On the Anaconda Prompt type `python`
* You may be able to run python scripts now, we´ll type the following lines:
* `import tensorflow as tf`
* `tf.test.is_gpu_abailable()`
* Once it finishes, you may be able to read at the end if it´s `True` that you´re using your GPU.




