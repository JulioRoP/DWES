<?php

require_once "vehiculos.php";
require_once "bicicleta.php";
require_once "coche.php";
require_once "concesionario.php";
require_once "interfaz.php";
require_once "moto.php";
require_once "camion.php";





$camion = new camion("ferrari", "grande ","negro", 100);

echo $camion->obtenerInformacion() . PHP_EOL;
echo $camion->mover() . PHP_EOL;
echo $camion->detener() . PHP_EOL;

$coche = new coche("ferrari", "enano ","rojo", 3);

echo $coche->obtenerInformacion() . PHP_EOL;
echo $coche->mover() . PHP_EOL;
echo $coche->detener() . PHP_EOL;