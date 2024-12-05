<?php

require_once "Vehiculos.php";

final class bicicleta extends Vehiculo{

    public function __construct(string $marca, string $modelo, float $color ) {
        parent::__construct($marca, $modelo, $color);
    }
    public function mover(): string {
        return "La bici  {$this->marca} {$this->modelo} {$this->color} se mueve.";
    }
    public function detener(): string {
        return "La bici  {$this->marca} {$this->modelo} {$this->color} está parado.";
    }

    public function pedalear(): string {
        return "La vici esta Pedaleando.";
    }
}

?>