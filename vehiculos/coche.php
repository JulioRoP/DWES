<?php

require_once "Vehiculos.php";

class coche extends Vehiculo{

    protected int $numeroPuertas;

    public function __construct(string $marca, string $modelo, string $color, int $numeroPuertas ) {
        parent::__construct($marca, $modelo, $color);
        $this->numeroPuertas = $numeroPuertas;
    }
    public function mover(): string {
        return "El coche {$this->marca} {$this->modelo} {$this->color} {$this->numeroPuertas} se mueve.";
    }
    public function detener(): string {
        return "El coche {$this->marca} {$this->modelo} {$this->color} {$this->numeroPuertas}está parado.";
    }
    public function obtenerInformacion(): string {
        return "El coche Marca: {$this->marca}, Modelo: {$this->modelo}, Color: {$this->color}, Puertas: {$this->numeroPuertas}";
    }
}

?>