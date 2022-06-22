<?php

function conectarDB() : mysqli {
    $db = mysqli_connect('localhost', 'root', 'root', 'thorx_mvc');
    // utf8 es para usar acentos y ñ´s.
    $db->set_charset("utf8");

    if(!$db) {
        echo "Error no se pudo conectar";
        exit;
    }

    return $db;
}
