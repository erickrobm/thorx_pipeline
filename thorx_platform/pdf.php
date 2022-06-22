<?php include 'var_storage.php'?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--========== BOX ICONS ==========-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

        <!--========== CSS ==========-->
        <link rel="stylesheet" href="assets/css/pdf.css">

        <title>ThorX | Reporte</title>
    </head>
    <body>
        <!--========== VARIABLES ==========-->
        <?php 
        // Mandar a llamar variables del formulario.
        $nombre = strtoupper($_POST['nombre']); 
        $apellido = strtoupper($_POST['apellido']);

        $dia = $_POST['dia'];
        $mes = $_POST['mes'];
        $año = $_POST['año'];

        if (strlen($dia) == 1){
            $dia = 0 . $dia;
        }

        $nacimiento = $dia.'/'.$mes.'/'.$año;
        
        $email = $_POST['email'];
        $pais = $_POST['pais'];
        $sexo = $_POST['sexo'];

        // Mandar a llamar nombre de la imagen del formulario.
        if($diagnostico === 'COVID-19'){
            $capretaImagenes = 'images/COVID-19/';
        }

        if($diagnostico === 'Viral Pneumonia'){
            $capretaImagenes = 'images/Neumonia Viral/';
        }

        if($diagnostico === 'NORMAL'){
            $capretaImagenes = 'images/Normal/';
        }

        // Nombre de Imagen
        $nombreImagen = ($apellido . ' ' . $nombre . '_' . date("dmY")) . ".png";
        
        $diagnostico = $_POST['diagnostico'];
        $porcentaje = $_POST['porcentaje'];

        ?>

        <!--========== HEADER ==========-->
        <header class="l-header" id="header">
            <nav class="nav bd-container">
                <a href="#" class="nav__logo">Reporte | ThorX</a>

                <div class="nav__menu" id="nav-menu">
                    <ul class="nav__list">
                        <li class="nav__item">
                            <a href="../thorx_platform/index.php" class="nav__link active-link">
                                <i class='bx bx-home nav__icon'></i>Regresar al Inicio
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="#advise" class="nav__link active-link">
                                <i class='bx bxs-news nav__icon'></i>Aviso
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="#birthday" class="nav__link active-link">
                                <i class='bx bxs-baby-carriage nav__icon'></i>Fecha de Nacimiento
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="#sex" class="nav__link active-link">
                                <i class='bx bx-male-female nav__icon'></i>Sexo
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="#email" class="nav__link active-link">
                                <i class='bx bx-envelope nav__icon'></i>Correo Electrónico
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="#country" class="nav__link active-link">
                                <i class='bx bx-world nav__icon'></i>País de Nacimiento
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="#diagnostic" class="nav__link active-link">
                                <i class='bx bx-bar-chart-alt-2 nav__icon'></i>Diagnóstico
                            </a>
                        </li>
                    </ul>
                </div>
                <!--========== CLICK PARA DEPLEGAR MENU EN DISP. MOVILES ==========-->
                <div class="nav__toggle" id="nav-toggle">
                    <i class='bx bx-grid-alt' ></i>
                </div>
            </nav>
        </header>

        <main class="l-main bd-container">
            <!-- Todos los elementos desde este punto se podran visualizar en el PDF generado -->

            <div class="resume" id="area-resume">

                <!--========== Inicio ==========-->
                <section class="inicio" id="inicio">
                    <div class="inicio__container section bd-grid">
                        <div class="logo__data bd-grid">
                            <img src="assets/img/Thor X SF.png" alt="" class="logo__img"> 
                        </div>
                        <div class="inicio__data bd-grid">
                            <input type="hidden" value="<?php echo $apellido . '_' . $nombre;?>" id="nombre">
                            <h1 class="inicio__title"><?php echo $nombre; ?> <b><?php echo $apellido; ?></b></h1>
                        </div>
                    </div>

                    <!-- Boton para DARK MODE -->
                    <i class='bx bx-moon change-theme' title="Theme" id="theme-button"></i>

                    <!-- Boton para generar y descargar el PDF desde Computadora --> 
                    <i class='bx bx-download generate-pdf' title="Generate PDF" id="resume-button"></i> 
                </section>  
                
                <!--========== Aviso ==========-->
                <section class="advise section" id="advise">
                    <p class="advise__description">Este reporte contiene datos personales y la predicción del diagnóstico por parte de la Plataforma ThorX de la imagen que se introdujo. 
                                                    Estos datos se manejarán de manera confidencial para fines de investigación.</p>                       
                </section>
                
                <!--========== Fecha de Nacimiento ==========-->
                <section class="birthday section" id="birthday">
                     <h2 class="section-title">Fecha de Nacimiento</h2>
                    
                     <div class="birthday__container bd-grid">
                        <h3 class="birthday__info">
                            <i class='bx bx-party birthday__icon'></i><?php echo $nacimiento; ?> 
                        </h3>
                     </div>
                </section>

                <!--========== Sexo ==========-->
                <section class="sex section" id="sex">
                    <h2 class="section-title">Sexo</h2>

                     <div class="sex__container bd-grid">
                        <h3 class="sex__info">
                            <i class='bx bx-male-female sex__icon'></i><?php echo $sexo; ?> 
                        </h3>
                     </div>
                </section>

                <!--========== Correo ==========-->
                <section class="email section" id="email">
                    <h2 class="section-title">Correo Electrónico</h2>

                    <div class="email__container bd-grid">
                       <h3 class="email__info">
                            <i class='bx bx-envelope email__icon'></i><?php echo $email; ?> 
                       </h3>
                    </div>
                </section>

                <!--========== Nacionalidad  ==========-->
                <section class="country section" id="country">
                    <h2 class="section-title">País de Nacimiento</h2>

                    <div class="country__container bd-grid">
                       <h3 class="country__info">
                            <i class='bx bx-world country__icon'></i><?php echo $pais; ?>
                       </h3>
                    </div>
                </section>

                <!--========== Diagnostico  ==========-->
                <section class="diagnostic section" id="diagnostic">
                    <h2 class="section-title">Diagnóstico </h2>  
                    <h3 class="diagnostic__detail"><b><?php echo $diagnostico; ?></b></h3> 

                    <div class="diagnostic__container bd-grid">

                        <img src="<?php echo $capretaImagenes . $nombreImagen; ?>" alt="" class="diagnostic__img">
                        
                        <h3 class="diagnostic__info">
                            <i class='bx bx-bar-chart-alt-2 diagnostic__icon'></i>Certeza en el Diagnóstico: <b><?php echo $porcentaje; ?>%</b> <!-- MODIFICAR VARIABLE PHP -->
                        </h3>
                    </div>
                </section>

                <!--========== Día y hora en que se genera el PDF  ==========-->
                <section class="time section" id="date">
                    <div id="current__date">
                        <h3 id="date__info" class="date__info"></h3>
                        <h3 id="time__info" class="time__info"></h3>
                    </div>
                </section>
            </div>
        </main>

        <!--========== SCROLL HACIA ARRIBA ==========-->
        <a href="#inicio" class="scrolltop" id="scroll-top">
            <i class='bx bx-up-arrow-alt scrolltop__icon'></i>
        </a>

        <!--========== HTML2PDF ==========-->
        <script src="assets/js/html2pdf.bundle.min.js"></script>

        <!--========== MAIN JS ==========-->
        <script src="assets/js/pdf.js"></script>

        <!--========== MANDAR A LLAMAR LOS SERVICIOS POR LA MÁQUINA VIRTUAL ==========-->
        <script src="assets/js/virtualmachine.js"></script>
    </body>
</html>