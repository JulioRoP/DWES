<?php

interface VehiculoElectrico {

    public function cargarBateria();
    public function estadoBateria();

}

class Tesla extends Vehiculo implements VehiculoElectrico {
    private int $bateria;

    public function __construct(string $marca, string $modelo, string $color, int $bateria) {
        parent::__construct($marca, $modelo, $color);
        $this->bateria = $bateria;
    }

    public function cargarBateria(): string {
        $this->bateria = 100;
        return "La batería está completamente cargada.";
    }

    public function estadoBateria(): string {
        return "Estado de la batería: {$this->bateria}%";
    }

    public function mover(): string {
        return "El Tesla {$this->marca} está en movimiento.";
    }

    public function detener(): string {
        return "El Tesla {$this->marca} se ha detenido.";
    }

    public function obtenerInformacion(): string {
        return parent::obtenerInformacion() . ", Batería: {$this->bateria}%";
    }
}




