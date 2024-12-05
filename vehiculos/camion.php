<?php

require_once "Vehiculos.php";

class camion extends Vehiculo{

    protected float $capacidadCarga ;

    public function __construct(string $marca, string $modelo, string $color, int $capacidadCarga  ) {
        parent::__construct($marca, $modelo, $color);
        $this->capacidadCarga  = $capacidadCarga ;
    }
    public function mover(): string {
        return "El camion {$this->marca} {$this->modelo} {$this->color} {$this->capacidadCarga} se mueve.";
    }
    public function detener(): string {
        return "El camion  {$this->marca} {$this->modelo} {$this->color} {$this->capacidadCarga} está parado.";
    }
    public function obtenerInformacion(): string {
        return "El camion Marca: {$this->marca}, Modelo: {$this->modelo}, Color: {$this->color}, Carga: {$this->capacidadCarga}";
    }
}

?>