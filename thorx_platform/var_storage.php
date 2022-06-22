<?php
    require '../thorx_platform/config/database.php';
    $db = conectarDB();
    
    // Validando formulario (MENSAJES DE ERROR)
    $errores = [];

    // Creacion de las variables con string vacío para llenar campos con valor previo.
    $nombre = '';
    $apellido = '';
    $dia = '';
    $mes = '';
    $año = '';
    $email = '';
    $pais = '';
    $imagen = '';
    $sexo = '';
    $porcentaje = '';
    $diagnostico = '';
    
    // EJECUTAR DESPUÉS DE QUE EL USUARIO ENVIA EL FORMULARIO
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // mysqli_real_escape_string -> Permite sanitizar los datos, así como quitar numeros de nombres
        // y/o caracteres especiales no admitidos en correos. UTILIZA FILTROS DE VALIDACIÓN

        // Creacion de las variables y almacenar valor del formulario dentro de ellas.
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $dia = $_POST['dia'];
        $mes = $_POST['mes'];
        $año = $_POST['año'];
        $email = $_POST['email'];
        $pais = $_POST['pais'];
        $sexo = $_POST['sexo'];
        $diagnostico = $_POST['diagnostico'];
        $porcentaje = $_POST['porcentaje'];
        date_default_timezone_set("America/Mexico_City");
        $fecha = date("d/m/Y"); 
        $hora = date("H:i ") . "(CST)";

        if (strlen($dia) == 1){
            $dia = 0 . $dia;
        }

        $nacimiento = $dia . '/' . $mes . '/' . $año;

        // Asignar $_FILES a una variable y guardar la imagen en una carpeta dentro del proyecto.
        $imagen = $_FILES['imagen'];
        // var_dump($imagen['name']); // <- Con este puedo almacenar el nombre de la variable 
        
        //echo "<pre>";
        //var_dump($_POST);
        //echo "</pre>";

    if(!$nombre){
        $errores[] = "Debes de introducir tu(s) nombre(s).";
    }

    if(!$apellido){
        $errores[] = "Debes introducir tu apellido.";
    }

    if(!$dia){
        $errores[] = "Debes seleccionar tu día de nacimiento.";
    }

    if(!$mes){
        $errores[] = "Debes seleccionar tu mes de nacimiento.";
    }

    if(!$año){
        $errores[] = "Debes seleccionar tu año de nacimiento.";
    }

    if(!$email){
        $errores[] = "Debes introducir tu correo electrónico.";
    }

    if(!$pais){
        $errores[] = "Debes seleccionar tu país de nacimiento.";
    }
    
    // Establecer condicional de si se coloca imagen, si se repite en la base de datos y si 
    // no es una imagen torácica.
    if(!$imagen['name'] || $imagen['error']){
        $errores[] = 'La imagen es obligatoria.';
    }

    // Validar imagen por tamaño (1 MB máximo).
    $medida = 1000 * 1000; // la variable ['size'] se mide en bytes, esto lo convierte a 1 mega = 1000 kb.

    if($imagen['size'] > $medida) {
        $errores[] = "La imagen es muy pesada, debes ingresar a un tamaño menor o igual a 1 MB.";
    }

    // Validar que la imagen si sea de tórax mediante la cuarta clase 'No Coincide'.
    if($diagnostico === 'No Coincide'){
        $errores[] = "Debes seleccionar una imagen de radiografía de tórax.";
    }

    if(!$sexo){
        $errores[] = "Debes seleccionar tu sexo.";
    }

    
    // Revisar que el arreglo de errores esté vacío.
    if(empty($errores)) {

            /*SUBIR ARCHIVOS (IMAGENES Y PDF) A LA BASE DE DATOS*/

            // Crear carpeta.
            // Colocar el directorio al cual va a almacenarse la imagen.
            if($diagnostico === 'COVID-19'){
                $capretaImagenes = '../thorx_platform/images/COVID-19/';
            }

            if($diagnostico === 'Viral Pneumonia'){
                $capretaImagenes = '../thorx_platform/images/Neumonia Viral/';
            }

            if($diagnostico === 'NORMAL'){
                $capretaImagenes = '../thorx_platform/images/Normal/';
            }

            // Condicional para verificar si la carpeta ya se creó, para evitar crearla muchas veces.
            if(!is_dir($capretaImagenes)) {
                mkdir($capretaImagenes);
            }

            // Generar nombre único de imagen **MODIFICAR**.
            $nombreImagen = ($apellido . ' ' . $nombre . '_' . date("dmY")) . ".png"; // Aquí tambien se le puede colocar . ".png"

            move_uploaded_file($imagen['tmp_name'], $capretaImagenes . $nombreImagen); // Al final le puedo concatenar una extension con . ".png"
            
        // FALTA AGREGAR LOS VALORES DEL PDF DE FECHA, TIEMPO Y DIAGNÓSTICO.
        $query = " INSERT INTO formulario__users (nombre, apellido, nacimiento, email, pais, imagen, diagnostico, fecha, hora, sexo, porcentaje) 
        VALUES ( '$nombre', '$apellido', '$nacimiento', '$email', '$pais', '$nombreImagen', '$diagnostico', '$fecha', '$hora', '$sexo', '$porcentaje' ) ";
    
        // Almacenar resultados en la base de datos.
        $resultado = mysqli_query($db, $query);
    
        //while($r = $resultado->fetch_object()){
        //    //echo $r->$id.",";
        //    echo $r->$nombre.",";
        //    echo $r->$apellido.",";
        //    echo $r->$nacimiento.",";
        //    echo $r->$email.",";
        //    echo $r->$pais.",";
        //    echo $r->$nombreImagen.",";
        //    echo $r->$diagnostico.",";
        //    echo $r->$fecha.",";
        //    echo $r->$hora.",";
        //    echo $r->$sexo.",";
        //    echo $r->$porcentaje."\n";
        //}
        if($resultado) {
            // Una vez suceda el POST a la base de datos, se actualiza el formulario a vacío para que
            // no esté autocompletado.

            
            //$nombre = '';
            //$apellido = '';
            //$nacimiento = '';
            //$email = '';
            //$pais = '';
            //$imagen = '';
            //$diagnostico = '';
            //$sexo = '';
            //$porcentaje = '';
            
            // Redireccionar al usuario hacia el PDF generado
            //header('Content-Type: application/csv');
            //header('Content-Disposition: attachment; filename = clean_data.csv;');
        }
    }
}
?>