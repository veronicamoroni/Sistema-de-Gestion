<?php
    class Cliente {
       private $dni; 
       private $nombre;
       private $apellido;
       private $tel;
       private $email;
       private $misAutos = [];
       
       public function __construct($dni, $nombre, $apellido, $tel, $email){
            $this->dni = $dni;
            $this->nombre = $nombre;
            $this-> apellido = $apellido;
            $this->tel = $tel;
            $this->email = $email;
       }

       public function vincularAuto ($patente) {
            $this->misAutos[] = $patente;
       }

       
    public function desvincularAuto($patente) {
        $key = array_search($patente, $this->misAutos);
        if ($key !== false) {
            unset($this->misAutos[$key]);
            $this->misAutos = array_values($this->misAutos); // Reindexa el array
        }
    }
    public function eliminarAuto($patente) {
        $key = array_search($patente, $this->misAutos);
        if ($key !== false) {
            unset($this->misAutos[$key]);
            $this->misAutos = array_values($this->misAutos); // Reindexa el array
        }
    }
       public function getmisAutos() {
        return $this-> misAutos;
        }
        public function getDni() {
            return $this-> dni;
        }

        public function getNombre(){
            return $this-> nombre;
        }

        public function getApellido(){
            return $this-> apellido;
        }

        public function getTel(){
            return $this-> tel;
        }

        public function getEmail(){
            return $this-> email;
        }

        public function setDni($dni) {
            $this->dni = $dni;
        } 

        public function setNombre($nombre) {
           $this->nombre = $nombre;
        }

        public function setApellido($apellido) {
            $this->apellido = $apellido;
        }

        public function setTel($tel) {
            $this->tel = $tel;
        } 

        public function setEmail($email) {
            $this->email = $email;
        } 
       
        public function mostrar() {
            
            echo ('DNI: '.$this->dni.';'); //echo(PHP_EOL);
            echo (' Nombre: '.$this->nombre.';'); //echo(PHP_EOL);
            echo (' Apellido: '.$this->apellido.';');
            echo (' Tel: '.$this->tel.';');  
            echo (' Mail: '.$this->email); echo(PHP_EOL);
        }
    }
