<?php
abstract class Vehiculo {
    protected string $marca;
    protected string $modelo;
    protected string $color;
 
 
    public function __construct(string $marca, string $modelo, string $color = "Negro") {
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->color = $color;
    }
 
 
    abstract public function mover();
    abstract public function detener();
 
 
    public function obtenerInformacion(): string {
        return "Marca: {$this->marca}, Modelo: {$this->modelo}, Color: {$this->color}";
    }
    public function __toString(): string {
        return $this->obtenerInformacion();
    }


    public function getmarca(){
        return $this->marca;
    }
    public function setmarca($nuevaMarca){
        $this -> marca=$nuevaMarca;
    }

    public function getmodelo(){
        return $this-> modelo;
    }
    public function setmodelo($nuevoModelo){
        $this -> modelo=$nuevoModelo;
    }
    public function getcolor(){
        return $this-> color;
    }
    public function setcolor($nuevoColor){
        $this -> color=$nuevoColor;
    }

}

// ---------------------------


