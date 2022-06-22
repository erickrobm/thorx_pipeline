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
        <link rel="stylesheet" href="assets/css/styles.css">
        <link rel="stylesheet" href="assets/css/forum.css">

        <title>ThorX | Comienza tu Diagnóstico</title>
    </head>
    <body ng-app="myApp" ng-controller="myCtrl">

    <!--========== VARIABLES ==========-->

    <!--========== HEADER ==========-->
    <?php include 'header.php' ?>

    <!--========== BACKGROUND ==========-->
    <?php include 'background.php' ?>

    <!--========== FORUM ==========-->
    <main>
        <div class="main__content">
            <div class="text__information-cover">
                <h1>Datos del Paciente</h1>

                <p>El presente formulario tiene como objetivo brindar un reporte en PDF por parte de la plataforma ThorX. 
                    La información provista a este medio es de carácter confidencial, 
                    y se utilizará únicamente para enriquecer la base de datos de la plataforma, para uso académico
                    y de investigación.
                </p>

                <p>Llene los campos con la mayor fidelidad y seleccione una imagen con extensión ".jpg", 
                    ".jpeg" o ".png". Posteriormente, proceda a dar click en el botón de "Validar Imagen" dos veces
                     para que esta sea verificada por el modelo de red neuronal.
                </p>

                <p>EL TAMAÑO DE LA IMAGEN NO DEBE DE EXCEDER DE 1 MB.</p>

                <p>El formulario se reiniciará si se carga una imagen no válida o un archivo que no sea con las extensiónes
                     permitidas.</p>
            </div>
        </div>

        <div class="container__forum">
            <div class="container__one">
                <form method="POST" action="pdf.php" id="formulario" enctype="multipart/form-data" name="myForm">
                    <div class="container__name">
                        <h2>Introduce tus Datos</h2>
                    </div>
                    <hr>
                    <div class="user__details">
                        <div class="input__box">
                            <span class="details">Nombre(s)</span>
                            <input 
                            type="text" 
                            placeholder="Introduce tu(s) nombre(s)" 
                            id="nombre" 
                            name="nombre"
                            class="form-control" 
                            value="<?php echo $nombre; ?>">
                        </div>

                        <div class="input__box">
                            <span class="details">Apellidos</span>
                            <input 
                            type="text" 
                            placeholder="Introduce tus apellidos" 
                            id="apellido" 
                            name="apellido" 
                            class="form-control" 
                            value="<?php echo $apellido; ?>">
                        </div>

                        <div class="input__box">
                            <span class="details">Fecha de Nacimiento</span>
                            <div class="cumple__container">
                                <select class="menu__country cumple" id="nacimiento_day" name="dia">
                                    <option value="" selected disabled>Día</option>
                                    <?php 
                                        for ($i=1; $i<=31; $i++) {
                                            echo "<option>$i</option>";
                                        }
                                    ?>
                                </select>
                                <select class="menu__country cumple" id="nacimiento_month" name="mes">
                                    <option value="" selected disabled>Mes</option>
                                    <option value="01">Enero</option>
                                    <option value="02">Febrero</option>
                                    <option value="03">Marzo</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Mayo</option>
                                    <option value="06">Junio</option>
                                    <option value="07">Julio</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                                <select class="menu__country cumple" id="nacimiento_year" name="año">
                                    <option value="" selected disabled>Año</option>
                                    <?php 
                                        for ($i=date('Y'); $i>=date('Y')-100; $i--) {
                                            echo "<option>$i</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="input__box">
                            <span class="details">Email</span>
                            <input 
                            type="email" 
                            placeholder="Introduce tu email" 
                            id="email" 
                            name="email" 
                            class="form-control" 
                            value="<?php echo $email; ?>">
                        </div>

                        <div class="input__box"> 
                        <span class="details">País</span>
                            <select class="menu__country " id="pais" name="pais">
                                <option value="" selected disabled>Selecciona tu país de nacimiento</option>
                                <option value="Afganistán">Afganistán</option>
                                <option value="Albania">Albania</option>
                                <option value="Alemania">Alemania</option>
                                <option value="Andorra">Andorra</option>
                                <option value="Angola">Angola</option>
                                <option value="Antigua y Barbuda">Antigua y Barbuda</option>
                                <option value="Arabia Saudita">Arabia Saudita</option>
                                <option value="Argelia">Argelia</option>
                                <option value="Argentina">Argentina</option>
                                <option value="Armenia">Armenia</option>
                                <option value="Australia">Australia</option>
                                <option value="Austria">Austria</option>
                                <option value="Azerbaiyán">Azerbaiyán</option>
                                <option value="Bahamas">Bahamas</option>
                                <option value="Bangladés">Bangladés</option>
                                <option value="Barbados">Barbados</option>
                                <option value="Baréin">Baréin</option>
                                <option value="Bélgica">Bélgica</option>
                                <option value="Belice">Belice</option>
                                <option value="Benín">Benín</option>
                                <option value="Bielorrusia">Bielorrusia</option>
                                <option value="Birmania">Birmania</option>
                                <option value="Bolivia">Bolivia</option>
                                <option value="Bosnia y Herzegovina">Bosnia y Herzegovina</option>
                                <option value="Botsuana">Botsuana</option>
                                <option value="Brasil">Brasil</option>
                                <option value="Brunéi">Brunéi</option>
                                <option value="Bulgaria">Bulgaria</option>
                                <option value="Burkina Faso">Burkina Faso</option>
                                <option value="Burundi">Burundi</option>
                                <option value="Bután">Bután</option>
                                <option value="Cabo Verde">Cabo Verde</option>
                                <option value="Camboya">Camboya</option>
                                <option value="Camerún">Camerún</option>
                                <option value="Canadá">Canadá</option>
                                <option value="Catar">Catar</option>
                                <option value="Chad">Chad</option>
                                <option value="Chile">Chile</option>
                                <option value="China">China</option>
                                <option value="Chipre">Chipre</option>
                                <option value="Ciudad del Vaticano">Ciudad del Vaticano</option>
                                <option value="Colombia">Colombia</option>
                                <option value="Comoras">Comoras</option>
                                <option value="Corea del Norte">Corea del Norte</option>
                                <option value="Corea del Sur">Corea del Sur</option>
                                <option value="Costa de Marfil">Costa de Marfil</option>
                                <option value="Costa Rica">Costa Rica</option>
                                <option value="Croacia">Croacia</option>
                                <option value="Cuba">Cuba</option>
                                <option value="Dinamarca">Dinamarca</option>
                                <option value="Dominica">Dominica</option>
                                <option value="Ecuador">Ecuador</option>
                                <option value="Egipto">Egipto</option>
                                <option value="El Salvador">El Salvador</option>
                                <option value="Emiratos Árabes Unidos">Emiratos Árabes Unidos</option>
                                <option value="Eritrea">Eritrea</option>
                                <option value="Eslovaquia">Eslovaquia</option>
                                <option value="Eslovenia">Eslovenia</option>
                                <option value="España">España</option>
                                <option value="Estados Unidos">Estados Unidos</option>
                                <option value="Estonia">Estonia</option>
                                <option value="Etiopía">Etiopía</option>
                                <option value="Filipinas">Filipinas</option>
                                <option value="Finlandia">Finlandia</option>
                                <option value="Fiyi">Fiyi</option>
                                <option value="Francia">Francia</option>
                                <option value="Gabón">Gabón</option>
                                <option value="Gambia">Gambia</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Ghana">Ghana</option>
                                <option value="Granada">Granada</option>
                                <option value="Grecia">Grecia</option>
                                <option value="Guatemala">Guatemala</option>
                                <option value="Guyana">Guyana</option>
                                <option value="Guinea">Guinea</option>
                                <option value="Guinea ecuatorial">Guinea ecuatorial</option>
                                <option value="Guinea-Bisáu">Guinea-Bisáu</option>
                                <option value="Haití">Haití</option>
                                <option value="Honduras">Honduras</option>
                                <option value="Hungría">Hungría</option>
                                <option value="India">India</option>
                                <option value="Indonesia">Indonesia</option>
                                <option value="Irak">Irak</option>
                                <option value="Irán">Irán</option>
                                <option value="Irlanda">Irlanda</option>
                                <option value="Islandia">Islandia</option>
                                <option value="Islas Marshall">Islas Marshall</option>
                                <option value="Islas Salomón">Islas Salomón</option>
                                <option value="Israel">Israel</option>
                                <option value="Italia">Italia</option>
                                <option value="Jamaica">Jamaica</option>
                                <option value="Japón">Japón</option>
                                <option value="Jordania">Jordania</option>
                                <option value="Kazajistán">Kazajistán</option>
                                <option value="Kenia">Kenia</option>
                                <option value="Kirguistán">Kirguistán</option>
                                <option value="Kiribati">Kiribati</option>
                                <option value="Kuwait">Kuwait</option>
                                <option value="Laos">Laos</option>
                                <option value="Lesoto">Lesoto</option>
                                <option value="Letonia">Letonia</option>
                                <option value="Líbano">Líbano</option>
                                <option value="Liberia">Liberia</option>
                                <option value="Libia">Libia</option>
                                <option value="Liechtenstein">Liechtenstein</option>
                                <option value="Lituania">Lituania</option>
                                <option value="Luxemburgo">Luxemburgo</option>
                                <option value="Macedonia del Norte">Macedonia del Norte</option>
                                <option value="Madagascar">Madagascar</option>
                                <option value="Malasia">Malasia</option>
                                <option value="Malaui">Malaui</option>
                                <option value="Maldivas">Maldivas</option>
                                <option value="Malí">Malí</option>
                                <option value="Malta">Malta</option>
                                <option value="Marruecos">Marruecos</option>
                                <option value="Mauricio">Mauricio</option>
                                <option value="Mauritania">Mauritania</option>
                                <option value="México">México</option>
                                <option value="Micronesia">Micronesia</option>
                                <option value="Moldavia">Moldavia</option>
                                <option value="Mónaco">Mónaco</option>
                                <option value="Mongolia">Mongolia</option>
                                <option value="Montenegro">Montenegro</option>
                                <option value="Mozambique">Mozambique</option>
                                <option value="Namibia">Namibia</option>
                                <option value="Nauru">Nauru</option>
                                <option value="Nepal">Nepal</option>
                                <option value="Nicaragua">Nicaragua</option>
                                <option value="Níger">Níger</option>
                                <option value="Nigeria">Nigeria</option>
                                <option value="Noruega">Noruega</option>
                                <option value="Nueva Zelanda">Nueva Zelanda</option>
                                <option value="Omán">Omán</option>
                                <option value="Países Bajos">Países Bajos</option>
                                <option value="Pakistán">Pakistán</option>
                                <option value="Palaos">Palaos</option>
                                <option value="Panamá">Panamá</option>
                                <option value="Papúa Nueva Guinea">Papúa Nueva Guinea</option>
                                <option value="Paraguay">Paraguay</option>
                                <option value="Perú">Perú</option>
                                <option value="Polonia">Polonia</option>
                                <option value="Portugal">Portugal</option>
                                <option value="Reino Unido">Reino Unido</option>
                                <option value="República Centroafricana">República Centroafricana</option>
                                <option value="República Checa">República Checa</option>
                                <option value="República del Congo">República del Congo</option>
                                <option value="República Democrática del Congo">República Democrática del Congo</option>
                                <option value="República Dominicana">República Dominicana</option>
                                <option value="Ruanda">Ruanda</option>
                                <option value="Rumanía">Rumanía</option>
                                <option value="Rusia">Rusia</option>
                                <option value="Samoa">Samoa</option>
                                <option value="San Cristóbal y Nieves">San Cristóbal y Nieves</option>
                                <option value="San Marino">San Marino</option>
                                <option value="San Vicente y las Granadinas">San Vicente y las Granadinas</option>
                                <option value="Santa Lucía">Santa Lucía</option>
                                <option value="Santo Tomé y Príncipe">Santo Tomé y Príncipe</option>
                                <option value="Senegal">Senegal</option>
                                <option value="Serbia">Serbia</option>
                                <option value="Seychelles">Seychelles</option>
                                <option value="Sierra Leona">Sierra Leona</option>
                                <option value="Singapur">Singapur</option>
                                <option value="Siria">Siria</option>
                                <option value="Somalia">Somalia</option>
                                <option value="Sri Lanka">Sri Lanka</option>
                                <option value="Suazilandia">Suazilandia</option>
                                <option value="Sudáfrica">Sudáfrica</option>
                                <option value="Sudán">Sudán</option>
                                <option value="Sudán del Sur">Sudán del Sur</option>
                                <option value="Suecia">Suecia</option>
                                <option value="Suiza">Suiza</option>
                                <option value="Surinam">Surinam</option>
                                <option value="Tailandia">Tailandia</option>
                                <option value="Tanzania">Tanzania</option>
                                <option value="Tayikistán">Tayikistán</option>
                                <option value="Timor Oriental">Timor Oriental</option>
                                <option value="Togo">Togo</option>
                                <option value="Tonga">Tonga</option>
                                <option value="Trinidad y Tobago">Trinidad y Tobago</option>
                                <option value="Túnez">Túnez</option>
                                <option value="Turkmenistán">Turkmenistán</option>
                                <option value="Turquía">Turquía</option>
                                <option value="Tuvalu">Tuvalu</option>
                                <option value="Ucrania">Ucrania</option>
                                <option value="Uganda">Uganda</option>
                                <option value="Uruguay">Uruguay</option>
                                <option value="Uzbekistán">Uzbekistán</option>
                                <option value="Vanuatu">Vanuatu</option>
                                <option value="Venezuela">Venezuela</option>
                                <option value="Vietnam">Vietnam</option>
                                <option value="Yemen">Yemen</option>
                                <option value="Yibuti">Yibuti</option>
                                <option value="Zambia">Zambia</option>
                                <option value="Zimbabue">Zimbabue</option>
                            </select>
                        </div>

                        <div class="input__box diagnostic__box">
                            <span class="details">Seleccionar imagen</span>
                            <input 
                            type="file" 
                            id="file" 
                            ng-model="cn"
                            class="form-control"
                            onchange="loadFile(event)"
                            accept="image/jpg, image/jpeg, image/png" 
                            name="imagen" 
                            class="form-control" 
                            value="<?php echo $imagen; ?>">
                            <label for="file">
                                <i class='bx bx-import nav__icon'></i> Subir imagen
                            </label>
                            
                        </div>

                    </div>

                    <div class="sex__box">
                        <input 
                        type="radio" 
                        name="sexo" 
                        id="dot-1"
                        value="Masculino"
                        checked>
                        <input 
                        type="radio" 
                        name="sexo" 
                        id="dot-2" 
                        value="Femenino">
                        <input 
                        type="radio" 
                        name="sexo" 
                        id="dot-3" 
                        value="Prefiero no decir">
                        <span class="sex__title"><h3>Sexo</h3></span>
                        <div class="sex__category">
                             <label for="dot-1">
                                <span class="dot one"></span>
                                <span class="sex">Masculino</span>
                            </label>
                            <label for="dot-2">
                                <span class="dot two"></span>
                                <span class="sex">Femenino</span>
                            </label>
                            <label for="dot-3">
                                <span class="dot three"></span>
                                <span class="sex">Prefiero no decir</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="buttons__category">
                        <div class="forum__submit">
                            <input 
                            type="submit" 
                            value="Generar PDF" 
                            class="md-accent md-raised form-control" 
                            id="submit__forum">
                        </div>

                        <div class="image__test">
                            <input 
                            type="button" 
                            ng-click="submit()"
                            value="Validar Imagen" 
                            class="md-accent md-raised form-control" 
                            id="verify__image">
                        </div>
                    </div>

                    <!--========== MOSTRAR VALORES DE LA CLASIFICACIÓN YA HABIENDO LLAMADO A LA MÁQUINA VIRTUAL ==========-->
                    <div id="resultadosdiv" class="resultadosdiv">
                        <div ng-show="success">
                            <input 
                            type="hidden"
                            name="diagnostico" 
                            id="diagnostico"
                            style="color:blue;font-weight:bold"
                            value="{: predictions[0].label :}"
                            > 
                            <input 
                            type="hidden" 
                            id="porcentaje"
                            name="porcentaje" 
                            style="color:blue"
                            value="{: predictions[0].score :}"
                            >
                        </div>
                        <div ng-show="error">
                            <span style="color:red;font-weight:bold">Error al hacer conexión con la Máquina Virtual</span>
                        </div>
                        <div ng-show="loading">
                            <img src="https://images2.tcdn.com.br/commerce/assets/store/img//loading.gif" alt="Procesando" "">
                        </div>
                </form>
            </div>
        </div>
        
    </main>


        <!--========== MAIN JS ==========-->
        <script src="assets/js/main.js"></script>

        <!--========== APIS EN LA CLASIFICACIÓN JS ==========-->
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-aria.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.4/angular-material.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-animate.js"></script>

        <!--========== MANDAR A LLAMAR LOS SERVICIOS POR LA MÁQUINA VIRTUAL ==========-->
        <script src="assets/js/virtualmachine.js"></script>

        <!--========== MANDAR A LLAMAR LOS FILTROS PARA EL FORMULARIO ==========-->
        <script src="assets/js/forum.js"></script>

        <!--========== SWEET ALERT JS ==========-->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    </body>
</html>