<?php
// conexion
$conexion = new mysqli("localhost", "root", "", "eventos_deportivos");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// aqui el archivo
$archivo = fopen("eventos.csv", "r");
$total = 0;              
$insertados = 0;         //  insertados correctamente
$rechazados = 0;         
$errores = [];           

// Leer el archivo CSV línea por línea
while (($datos = fgetcsv($archivo, 1000, ",")) !== FALSE) {
    $total++;

    // comprueba si hay datos sin rellenar o que no valgan
    if (count($datos) < 6) {
        $rechazados++;
        $errores[] = "Línea $total: Datos incompletos.";
        continue; // Saltar a la siguiente línea si los datos están incompletos
    }

    // Asignar los datos del CSV
    $nombreEvento = $datos[0];
    $deporte = $datos[1];
    $fecha = $datos[2];
    $hora = $datos[3];
    $ubicacion = $datos[4];
    $organizador = $datos[5];

    // Insertar los datos en la base de datos
    $consulta = "INSERT INTO eventos (nombre_evento, tipo_deporte, fecha, hora, ubicacion, id_organizador) 
                 VALUES ('$nombreEvento', '$deporte', '$fecha', '$hora', '$ubicacion', '$organizador')";

    // Verificar si la consulta fue exitosa
    if ($conexion->query($consulta) === TRUE) {
        $insertados++;
    } else {
        $rechazados++;
        $errores[] = "Línea $total: Error en la inserción de '$nombreEvento'. Error: " . $conexion->error;
    }
}

fclose($archivo);

// resumen de los datos
echo "Número total de registros procesados: $total<br>";
echo "Número de registros insertados correctamente: $insertados<br>";
echo "Número de registros rechazados: $rechazados<br>";

// detalles de los errores
if ($rechazados > 0) {
    echo "<strong>Errores detallados:</strong><br>";
    foreach ($errores as $error) {
        echo "$error<br>";
    }
}
?>
