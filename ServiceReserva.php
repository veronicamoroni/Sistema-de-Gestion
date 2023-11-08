<?php
require_once('Reserva.php');
require_once ('conexion.php');
class ServiceReserva {
    private $reservas = [];
    private $servicioCliente;
    private $servicioVehiculo;
    private $patentesReservadas = [];
    private $idCount = 1; // Contador para asignar IDs únicos a las reservas

    
    
    public function setServicioCliente($servicioCliente) {
        $this->servicioCliente = $servicioCliente;
    }

    public function setServicioVehiculo($servicioVehiculo) {
        $this->servicioVehiculo = $servicioVehiculo;
    }
    public function altaReserva() {
        $dniCliente = readline('Ingrese el DNI del cliente: ');
        $patente = readline('Ingrese la patente del vehículo: ');
    
        // Verificar si la patente ya está reservada
        if (in_array($patente, $this->patentesReservadas)) {
            echo ('La patente ya está reservada en otra reserva. No se pudo registrar la reserva.' . PHP_EOL);
            return;
        }
    
        $cliente = $this->servicioCliente->buscarClienteDni($dniCliente);
        $vehiculo = $this->servicioVehiculo->buscarVehiculo($patente);
    
        if ($cliente && $vehiculo) {
            $fechaIngresada = readline('Ingrese la fecha y hora de la reserva (en un formato reconocible, ej. "2023-12-31 15:30"): ');
    
            $timestampIngresado = strtotime($fechaIngresada);
    
            if ($timestampIngresado === false) {
                echo ('Fecha y hora ingresada no válida. No se pudo registrar la reserva.' . PHP_EOL);
                return;
            }
    
            // Verificar si la fecha y hora están ocupadas
            if ($this->esFechaOcupada($timestampIngresado)) {
                echo ('La fecha y hora seleccionada ya está reservada. No se pudo registrar la reserva.' . PHP_EOL);
                return;
            }
    
            // Agregar la patente a la lista de patentes reservadas antes de crear la reserva
            $this->patentesReservadas[] = $patente;
    
            $descripcion = readline('Descripción de la reserva: ');
    
            $fecha = date('Y-m-d H:i:s', $timestampIngresado);
    
            // Crear el objeto Reserva
            $reserva = new Reserva($this->idCount, $cliente, $vehiculo, $fecha, $descripcion);
            $this->reservas[] = $reserva;
            $this->idCount++;
    
            // Insertar los datos en la base de datos PostgreSQL
            $conexion = Conexion::obtenerInstancia();
            $bd = $conexion->obtenerConexion();
    
            $sql = "INSERT INTO reservas (cliente_dni, vehiculo_patente, fecha, descripcion) VALUES (:cliente_dni, :vehiculo_patente, :fecha, :descripcion)";
            $stmt = $bd->prepare($sql);
            $stmt->bindParam(':cliente_dni', $cliente->getDni(), PDO::PARAM_STR);
            $stmt->bindParam(':vehiculo_patente', $vehiculo->getPatente(), PDO::PARAM_STR);
            $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
    
            if ($stmt->execute()) {
                echo ('La reserva se ha registrado correctamente en la base de datos. ID de la reserva: ' . $reserva->getId() . PHP_EOL);
                echo ('Fecha y hora de la reserva: ' . $fecha . PHP_EOL);
            } else {
                echo ('No se pudo insertar la reserva en la base de datos.' . PHP_EOL);
            }
        } else {
            echo ('Cliente o vehículo no encontrado. No se pudo registrar la reserva.' . PHP_EOL);
        }
    }
    
    
    private function esFechaOcupada($timestampIngresado) {
        // Verificar si la fecha y hora ya está ocupada en una reserva existente
        foreach ($this->reservas as $reserva) {
            $timestampReserva = strtotime($reserva->getFecha());
            if ($timestampReserva === $timestampIngresado) {
                return true; // Fecha y hora ocupada
            }
        }
        return false; // Fecha y hora disponible
    }
    
    public function bajaReservaPorId($id) {
        $indice = $this->buscarReservaPorId($id);
        if ($indice !== false) {
            unset($this->reservas[$indice]);
            echo ('La reserva con ID ' . $id . ' se ha eliminado correctamente.' . PHP_EOL);
        } else {
            echo ('Reserva no encontrada con el ID ' . $id . PHP_EOL);
        }
    }

    private function buscarReservaPorId($id) {
        foreach ($this->reservas as $indice => $reserva) {
            if ($reserva->getId() == $id) {
                return $indice;
            }
        }
        return false;
    } /*
    public function bajaReservaPorId($id) {
        $indice = $this->buscarReservaPorId($id);
        if ($indice !== false) {
            unset($this->reservas[$indice]);
            echo ('La reserva con ID ' . $id . ' se ha eliminado correctamente.' . PHP_EOL);
        } else {
            echo ('Reserva no encontrada con el ID ' . $id . PHP_EOL);
        }
    }

    private function buscarReservaPorId($id) {
        foreach ($this->reservas as $indice => $reserva) {
            if ($reserva->getId() == $id) {
                return $indice;
            }
        }
        return false;
    }
    */
       
    public function listaReservas() {
        foreach ($this->reservas as $reserva) {
            echo('Id ' . $reserva->getId() . PHP_EOL);
            echo('Cliente: ' . $reserva->getCliente()->getNombre() . ' ' . $reserva->getCliente()->getApellido() . PHP_EOL);
            echo('Vehículo: ' . $reserva->getVehiculo()->getMarca() . ' ' . $reserva->getVehiculo()->getModelo() . PHP_EOL);
            echo('Fecha: ' . $reserva->getFecha() . PHP_EOL);
            echo('Descripción: ' . $reserva->getDescripcion() . PHP_EOL);
            echo(PHP_EOL);
        }
    }
    /*
    public function modificarReserva($id) {
        $idReserva = readline('Ingrese el ID de la reserva a modificar: ');
        $indice = $this->buscarReservaPorId($id);
        if ($indice !== false) {
            $reserva = $this->reservas[$indice];
            
            echo ('Reserva encontrada. Puede realizar modificaciones a continuación.' . PHP_EOL);
            
            $descripcion = readline('Ingrese la nueva descripción de la reserva: ');
            
            $reserva->setDescripcion($descripcion);
            
            echo ('La reserva con ID ' . $id . ' se ha modificado correctamente.' . PHP_EOL);
        } else {
            echo ('Reserva no encontrada con el ID ' . $id . PHP_EOL);
        }
    }  

    */
    public function modificarReserva($idReserva) {
        $idReserva = readline('Ingrese el ID de la reserva a modificar: ');
        $indice = $this->buscarReservaPorId($idReserva);
        if ($indice !== false) {
            $reserva = $this->reservas[$indice];
            
            echo ('Reserva encontrada. Puede realizar modificaciones a continuación.' . PHP_EOL);
            
            $descripcion = readline('Ingrese la nueva descripción de la reserva: ');
            $fecha = readline('Ingrese la nueva fecha de la reserva: ');
            $reserva->setDescripcion($descripcion);
            $reserva->setFecha($fecha);
            
            echo ('La reserva con ID ' . $idReserva . ' se ha modificado correctamente.' . PHP_EOL);
        } else {
            echo ('Reserva no encontrada con el ID ' . $idReserva . PHP_EOL);
        }
    }
    
    
    
    
    
    
}
