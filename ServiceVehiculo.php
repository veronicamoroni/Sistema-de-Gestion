<?php
    require_once ('vehiculo.php');
    require_once ('conexion.php');

    class ServiceVehiculo {

        private $vehiculos = [];
        private $servicioCliente;

        public function setServicioCliente($servicioCliente){
            $this->servicioCliente = $servicioCliente;
        }
        public function __construct() {
            // Lógica para cargar vehículos desde la base de datos y almacenarlos 
            $conexion = Conexion::obtenerInstancia();
            $bd = $conexion->obtenerConexion();
        
            $sql = "SELECT * FROM vehiculos";
            $result = $bd->query($sql);
        
            if ($result) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $vehiculo = new Vehiculo($row['patente'], $row['marca'], $row['modelo']); // Suponiendo que tienes una clase Vehiculo
                    $this->vehiculos[] = $vehiculo; // Asegúrate de que estás usando la variable correcta ($vehiculo)
                }
            }
        }
        
        
        public function altaVehiculo() {
            $dni = readline('Ingrese DNI Cliente: ');
            $patente = readline('Ingrese la patente del vehiculo: ');
            $modelo = readline('Ingrese modelo del Vehiculo: ');
            $marca = readline('Ingrese marca del Vehiculo: ');
        
            // Create a new vehicle
            $vehiculo = new Vehiculo($patente, $marca, $modelo);
        
            // Find the client using DNI
            $cliente = $this->servicioCliente->buscarClienteDni($dni);
        
            if ($cliente) {
                // Set the client for the vehicle
                $vehiculo->setCliente($cliente);
        
                // Add the vehicle to the client's list of vehicles
                $cliente->vincularAuto($patente);
        
                // Add the vehicle to the list of vehicles
                $this->vehiculos[] = $vehiculo;
                echo ('El vehículo se ha cargado correctamente.' . PHP_EOL);

                // Database Insertion
                $conexion = Conexion::obtenerInstancia();
                $bd = $conexion->obtenerConexion();
        
                $sql = "INSERT INTO vehiculos (patente, marca, modelo) VALUES ('$patente', '$marca', '$modelo')";
        
                if ($bd->query($sql)) {
                    echo(PHP_EOL);
                    echo "Vehículo agregado a la base de datos con éxito." . PHP_EOL;
                } else {
                    echo "Error al agregar el vehículo a la base de datos." . PHP_EOL;
                }
            } else {
                echo ('Cliente no encontrado. No se pudo vincular el vehículo.' . PHP_EOL);
            }
        }
        

        public function listaVehiculo() {     // Función para mostrar vehiculos
            foreach ($this->vehiculos as $x){
                $x->mostrar();
                }
            }   
        
            public function bajaVehiculo() {
                $patente = strtolower(readline('La patente del vehiculo a dar de baja es: '));
                $conexion = Conexion::obtenerInstancia();
            $bd = $conexion->obtenerConexion();

            $sql = "DELETE FROM vehiculos WHERE patente = '$patente'";

            if ($bd->query($sql)) {
                echo ('El vehiculo se ha eliminado de la Base de Datos.' . PHP_EOL);
                foreach ($this->vehiculos as $vehiculos => $v) {
                    if (strtolower($v->getPatente()) === $patente) {
            
                        // Obtén al cliente del vehículo
                        $cliente = $v->getCliente();
                        if ($cliente) {
                            // Desvincula el vehículo del cliente
                            $cliente->desvincularAuto($patente);
                        }
            
                        // Elimina el vehículo de la lista de vehículos
                        unset($this->vehiculos[$vehiculos]);
                        $this->vehiculos = array_values($this->vehiculos); // Reindexa el array
            
                        echo ('El vehículo se ha eliminado correctamente.' . PHP_EOL);
                        return true;
                    
                    }}
            
                echo ('Vehiculo No encontrado.' . PHP_EOL);
                return false;
                    }}
            /*
            public function bajaVehiculo() {
                
                $patente = strtolower(readline('La patente del vehiculo a dar de baja es: '));

                foreach ($this->vehiculos as $vehiculos => $v) {
                if (strtolower($v->getPatente()) === $patente) {
                
                        // Obtén al cliente del vehículo
                        $cliente = $v->getCliente();
                        if ($cliente) {
                            // Desvincula el vehículo del cliente
                            $cliente->desvincularAuto($patente);
                        }
            
                        unset($this->vehiculos[$vehiculos]);
                        echo ('El vehiculo se ha eliminado correctamente.' . PHP_EOL);
                        return true;
                    }
                }
            
                echo ('Vehiculo No encontrado.' . PHP_EOL);
                return false;
            }
        */
        public function buscarVehiculo($patente) {
            //$patente = readline('La patente a buscar: ');
            foreach ($this->vehiculos as $vehiculos => $v) {
                if ($v->getpatente() == $patente) {
                    return $v;
                }
            }
            return null;
        }
/*

public function buscarVehiculo($patente) {
    $patente = readline('La patente a buscar: ');
    foreach ($this->vehiculos as $vehiculo) {
        if ($vehiculo->getPatente() == $patente) {
            return $vehiculo; // Devuelve el vehículo encontrado
        }
    }
    return null; // Devuelve null si no se encontró el vehículo
}*/
        public function modificarVehiculo() {
            $patente = readline('La patente del vehiculo a modificar es: ');
            foreach ($this->vehiculos as $vehiculos) {
                if ($vehiculos->getPatente() == $patente) {
                    $newpatente = readline('Nueva patente: ');
                    $newmarca = readline ('Nueva marca: ');
                    $newmodelo = readline ('Nuevo modelo: ');
                    
                    $vehiculos->setPatente($newpatente);
                    $vehiculos->setMarca($newmarca);
                    $vehiculos->setModelo($newmodelo);
                    $conexion = Conexion::obtenerInstancia();
                    $bd = $conexion->obtenerConexion();
            
                    $sql = "UPDATE vehiculos 
                            SET patente = '$patente', marca = '$newmarca', modelo = '$newmodelo'
                            WHERE patente = '$patente'";
                    
                    if ($bd->query($sql))
                    echo ('El vehiculo se ha modificado exitasamente.'.PHP_EOL); 
                    return true; 
                }     
                    
                    
            } 
                    echo ('El vehiculo No existe.'.PHP_EOL);
                    return false;  
        }
        /*
        public function grabar() {
            $arrSerVeh = serialize($this->vehiculos);
            file_put_contents("vehiculos.json", $arrSerVeh);
            //print_r ($arrSer); echo(PHP_EOL);
        }

        public function leer() {
            $recArrVeh = file_get_contents("vehiculos.json");
            $arrOrigVeh = unserialize($recArrVeh);
            //print_r ($arrOrig);
            $this->vehiculos = $arrOrigVeh;
        }*/                
    }