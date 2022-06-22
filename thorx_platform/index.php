<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--========== BOX ICONS ==========-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

        <!--========== CSS ==========-->
        <link rel="stylesheet" href="assets/css/styles.css">
        <link rel="stylesheet" href="assets/css/index.css">

        <title>ThorX | Inicio</title>
    </head>
    <body>
        <!--========== HEADER ==========-->
        <?php include 'header.php' ?>

        <!--========== BACKGROUND ==========-->
        <?php include 'background.php' ?>

        <!--========== INDEX ==========-->
        <main>
            <!--INTRODUCCION DEL LA PAG. PRINCIPAL-->
            <div class="main__content">
                <div class="text__information-cover">
                    <h1>La innovación en la detección de COVID-19</h1>

                    <p>ThorX es una plataforma en fase de prueba que brinda una alternativa en la detección de pacientes "Sanos",
                    con "COVID-19" o con "Neumonía Viral" mediante el uso de un modelo de red neuronal entrenado con radiografías de
                     tórax en formato de imagen ".jpg", ".jpeg" y ".png". 
                    </p>

                    <p>Este proyecto parte del repositorio "COVID-19 Radiography Dataset" en el sitio web "Kaggle", que es una plataforma
                         gratuita que pone a disposición de sus usuarios encontrar y publicar conjuntos de datos, crear modelos en un entorno de 
                         ciencia de datos, trabajar con otros científicos de datos e ingenieros de aprendizaje automático y participar en concursos 
                         para resolver desafíos de ciencia de datos.
                    </p>
                    
                    <p>Para acceder al repositorio y obtener mayor información, de click en el siguiente enlace: 
                        <a href="https://www.kaggle.com/datasets/tawsifurrahman/covid19-radiography-database">https://www.kaggle.com/datasets/tawsifurrahman/covid19-radiography-database</a>
                    </p>

                    <p>Los procedimientos para la creación de la plataforma ThorX se exponen en las siguienets cartas:
                    </p>
                    
                </div>
            </div>

            <!--3 CARTAS SOBRE INFO DEL PROYECTO-->
            
            <div class="container__cards">
                <div class="card">
                    <div class="top__card">
                        <img src="../thorx_platform/assets/img/Parte 1.png" alt="">
                    </div>
                    <h2>Creación de la Red Neuronal</h2>
                    <p>Pre procesar las imagenes, normalizarlas y convertirlas en un dataset, definir los datos de 
                    entrenamiento y validación mediante un muestreo estratificado, elaborar el modelo de red neuronal
                    definiendo las épocas, cantidad de capas y la visualización de los errores que ocurren durante la 
                    creación del modelo. Finalmente, se pone a prueba la red neuronal con imagenes no usadas en el dataset.</p>
                    <hr>
                    <div class="footer__card">
                        <h3 class="number__process">Primera Parte</h3>
                        <i>Concluido</i>
                    </div>
                </div>

                <div class="card">
                    <div class="top__card">
                        <img src="../thorx_platform/assets/img/Parte 3.png" alt="">
                    </div>
                    <h2>Repositorio en Github</h2>
                    <p>Finalizando todo el esqueleto del proyecto tanto de la Front End como de la Back End, creamos
                    un repositorio en Github y añadimos las claves SSH para poder seguir modificando el repositorio de forma
                    local, poder pushear nuevos cambios a la rama principal del proyecto y se queda almacenado remotamente para 
                    su posterior uso en la Máquina Virtual. Es importante poder notificar que cambio se hizo en cada parte.
                    </p>
                    <hr>
                    <div class="footer__card">
                        <h3 class="number__process">Segunda Parte</h3>
                        <i>Concluido</i>
                    </div>
                </div>

                <div class="card">
                    <div class="top__card">
                        <img src="../thorx_platform/assets/img/Parte 2.png" alt="">
                    </div>
                    <h2>Maquina Virtual y Sitio Web</h2>
                    <p>Definir esqueleto de proyecto con HTML5, diseño y adornos con CSS3, conexiones a la base de
                    datos con PHP, y plugins con Javascript y Angular. Posteriormente, crear una instancia de CentOS 7 
                    en Google Platform para alojar el proyecto y disponer del uso de la Red Neuronal para clasificar las
                    imagenes proporcionadas en el Sitio Web. Se emplea un script de Python para cargar modelo y pre 
                    procesar la imagen del Sitio Web.</p>
                    <hr>
                    <div class="footer__card">
                        <h3 class="number__process">Tercera Parte</h3>
                        <i>Concluido</i>
                    </div>
                </div>
            </div>

            <!--JUSTIFICACIÓN DEL PORCENTAJE DE DIAGNÓSTICO-->

            <div class="middle__content">
                <div class="text__information-cover">
                    <h1>Sobre el Porcentaje de Diagnóstico</h1>

                    <p>ThorX posee un modelo de Red Neuronal Convolucional entrenado con 18,982 imagenes en total, divididas en
                         tres clases: "COVID-19", "Viral Pneumonia" y "Normal".
                    </p>

                    <p>Estas imagenes se clasificaron en 60% para datos de entrenamiento y 40% para datos de validación por medio
                        del Muestreo Estratificado, que consiste en dividir las muestras en estratos que comparten características
                        similares. Una vez estratificados nuestras datos, se selecciona al azar y de forma proporcional, a las muestras
                         finales de cada uno de los estratos que conformarán la muestra estadística.
                    </p>

                    <p>Finalmente, los datos estratificados se utilizan para entrenar al modelo de Red Neuronal y, de esta forma,
                        se obtiene una precisión del 99.39% en el porcentaje de diagnóstico para cada prueba. 
                    </p>
                
                </div>
            </div>

            <!--DESCARGA DE LA BASE DE DATOS-->
            <div class="middle__content">
                <div class="text__information-cover">
                    <h1>Obtener Información de la Base de Datos</h1>

                    <p>Da click en el siguiente botón para obtener una tabla en Excel sobre datos de utilidad de los pacientes almacenados
                        en nuestra base de datos.
                    </p>

                    <div class="image__test">
                        <a href="../thorx_platform/table.php">
                            <input 
                            type="button" 
                            value="Descargar tablas con datos">
                        </a>
                    </div>
                
                </div>
            </div>

        </main>
        <!--========== MAIN JS ==========-->
        <script src="assets/js/main.js"></script>
    </body>
</html>
