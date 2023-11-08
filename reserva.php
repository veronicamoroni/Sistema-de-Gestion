<?php
class Reserva {
    private $id;
    private $cliente;
    private $vehiculo;
    private $fecha;
    private $descripcion;

    public function __construct( $id,$cliente, $vehiculo, $fecha, $descripcion) {
        $this->id = $id;
        $this->cliente = $cliente;
        $this->vehiculo = $vehiculo;
        $this->fecha = $fecha;
        $this->descripcion = $descripcion;
    }

    public function getCliente() {
        return $this->cliente;
    }

    public function getVehiculo() {
        return $this->vehiculo;
    }
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function getFecha() {
        return $this->fecha;
    }
    public function setFecha($fecha) {
         $this->fecha= $fecha;
    }
    
    public function getDescripcion() {
        return $this->descripcion;
    }
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
}
?>