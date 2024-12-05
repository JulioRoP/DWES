<?php

require_once "Vehiculos.php";

class Moto extends Vehiculo{

    protected int $cilindrada;

    public function __construct(string $marca, string $modelo, string $color, int $cilindrada ) {
        parent::__construct($marca, $modelo, $color);
        $this->cilindrada = $cilindrada;
    }
    public function mover(): string {
        return "La moto  {$this->marca} {$this->modelo} {$this->color} {$this->cilindrada}se mueve.";
    }
    public function detener(): string {
        return "La moto  {$this->marca} {$this->modelo} {$this->color} {$this->cilindrada}está parado.";
    }
    public function obtenerInformacion(): string {
        return "La moto Marca: {$this->marca}, Modelo: {$this->modelo}, Color: {$this->color}, cilindrada: {$this->cilindrada}";
    }
}

?>