<?php

    require_once 'database.php';

    $query = mysqli_query($db,"SELECT * FROM formulario__users");

    date_default_timezone_set("America/Mexico_City");
    $fecha = date("d/m/Y"); 

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename = public_data_thorx.xls');
    header('Pragma: no-cache');
    header('Expires: 0');
    echo '<table border = 1>';
    echo '<tr>';
    echo '<th colspan=12>Public Data ThorX Fecha: ';
    echo ' ' . $fecha;
    echo '</th>';
    echo '</tr>';
    echo '<tr><th>ID</th><th>NOMBRE(S)</th><th>APELLIDO(S)</th><th>EMAIL</th><th>PAIS</th>
    <th>IMAGEN</th><th>DIAGNOSTICO</th><th>SEXO</th><th>FECHA</th><th>HORA</th>
    <th>NACIMIENTO</th><th>PORCENTAJE</th></tr>';

    while ($row = mysqli_fetch_array($query)){
        echo '<tr>';
        echo '<td>'.$row['id'].'</td>';
        echo '<td>'.$row['nombre'].'</td>';
        echo '<td>'.$row['apellido'].'</td>';
        echo '<td>'.$row['email'].'</td>';
        echo '<td>'.$row['pais'].'</td>';
        echo '<td>'.$row['imagen'].'</td>';
        echo '<td>'.$row['diagnostico'].'</td>';
        echo '<td>'.$row['sexo'].'</td>';
        echo '<td>'.$row['fecha'].'</td>';
        echo '<td>'.$row['hora'].'</td>';
        echo '<td>'.$row['nacimiento'].'</td>';
        echo '<td>'.$row['porcentaje'].'</td>';
        echo '</tr>';
    }

    echo '</table>';
?>