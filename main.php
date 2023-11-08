<?php
    require_once('ServiceCliente.php');
    require_once('Cliente.php');
    require_once('ServiceVehiculo.php');
    require_once('vehiculo.php');
    require_once('reserva.php');
    require_once('ServiceReserva.php');
    
    
    $servicioCliente = new ServiceCliente();
    $servicioVehiculo = new ServiceVehiculo();
    $servicioVehiculo->setServicioCliente($servicioCliente);
    $servicioReserva = new ServiceReserva();
    $servicioReserva->setServicioCliente($servicioCliente);
    $servicioReserva->setServicioVehiculo($servicioVehiculo);
    $conexion = Conexion::obtenerInstancia();
    $bd = $conexion->obtenerConexion();        
     /*   
    $servicioCliente->leer();
    $servicioVehiculo->leer();

    */
       
    function menuPrincipal() {
        echo ('========= Bienvenidos =========='); echo(PHP_EOL);
        echo ('===== PosService AutoMotion ===='); echo(PHP_EOL);
        echo ('================='); echo(PHP_EOL);
        echo ('Menu de opciones'); echo(PHP_EOL);
        echo ('================='); echo(PHP_EOL);
        echo ('1-Clientes.'); echo(PHP_EOL);
        echo ('2-Vehículos.'); echo(PHP_EOL);
        echo ('3-Reservas de Posventa.'); echo(PHP_EOL);
        echo ('0-Salir.'); echo(PHP_EOL);
    }
            
           
    function menuCliente() {

        echo(PHP_EOL);
        echo ('================='); echo(PHP_EOL);
        echo ('Menu de Clientes.'); echo(PHP_EOL);
        echo ('================='); echo(PHP_EOL);
        echo ('1 - Alta de Clientes.'); echo(PHP_EOL);
        echo ('2 - Modificar Clientes.'); echo(PHP_EOL);
        echo ('3 - Baja de Clientes.'); echo(PHP_EOL);
        echo ('4 - Buscar un Cliente.'); echo(PHP_EOL);
        echo ('5 - Mostrar Lista de Clientes.'); echo(PHP_EOL);
        echo ('6 - lista de autos vinculados.'); echo(PHP_EOL);
        echo ('0 - Salir.'); echo(PHP_EOL);
       
        
    }
        
    function menuVehiculo() {
        
        echo ('================='); echo(PHP_EOL);
        echo ('Menu de Vehículos.'); echo(PHP_EOL);
        echo ('================='); echo(PHP_EOL);
        echo ('1 - Alta de Vehículos.'); echo(PHP_EOL);
        echo ('2 - Modificar Vehículo.'); echo(PHP_EOL);
        echo ('3 - Baja de Vehículo.'); echo(PHP_EOL);
        echo ('4 - Buscar un Vehiculo.'); echo(PHP_EOL);
        echo ('5 - Lista vehiculos.'); echo(PHP_EOL);
        echo ('0 - Salir.'); echo(PHP_EOL);
    }
    function menuReserva() {
        echo ('================='); echo(PHP_EOL);
        echo ('Menu de Reservas.'); echo(PHP_EOL);
        echo ('================='); echo(PHP_EOL);
        echo ('1 - Alta de Reserva.'); echo(PHP_EOL);
        echo ('2 - Modificar Reservas.'); echo(PHP_EOL);
        echo ('3 - Baja de Reservas.'); echo(PHP_EOL);
        echo ('4 - Lista de Reservas.'); echo(PHP_EOL);
        echo ('0 - Salir.'); echo(PHP_EOL);
    }

    $opcion = " ";
    while ($opcion != 0) {
        menuPrincipal();
        $opcion = readline('Ingrese una opción: ');

        switch ($opcion) {
            case 1:
                echo('Seleccionaste Menú de clientes.'.PHP_EOL); 
                $opcionC = "";
                while ($opcionC != 0) {
                    menuCliente();
                    $opcionC = readline('Ingrese una opción: ');
                    switch ($opcionC) {
                        case 1: 
                            echo('Seleccionaste dar de alta a un cliente.'.PHP_EOL);
                            $servicioCliente->altaCliente(); break;
                           
                        case 2: 
                            echo('Seleccionaste modificar un cliente.'.PHP_EOL);
                            $servicioCliente->modificarCliente(); break;
                        case 3: 
                            echo('Seleccionaste dar de baja a un cliente.'.PHP_EOL);
                            $servicioCliente->bajaCliente(); break;
                        case 4: 
                            echo('Seleccionaste buscar un cliente.'.PHP_EOL);
                            $servicioCliente->buscarCliente(); break;
                        case 5: 
                            echo('Lista de clientes.'.PHP_EOL);
                            $servicioCliente->listaCliente(); break;
                        
                        case 6: 
                                echo('Lista de clientes con sus vehículos.'.PHP_EOL);
                                $servicioCliente->listarClientesConVehiculos(); break;    
                           
                        case 0: 
                           /* $servicioCliente->grabar();*/
                            echo ('Regresar al Menú Principal.'.PHP_EOL); break;
                        default: 
                            echo('Opción inválida.'.PHP_EOL);
                    }
                }
                break;
            
            case 2: 
                echo('Seleccionaste Menú de vehículos.'.PHP_EOL);
                $opcionV = "";
                while ($opcionV != 0) {
                    menuVehiculo();
                    $opcionV = readline('Ingrese una opción: ');
                    switch ($opcionV) {
                        case 1: 
                            echo('Seleccionaste dar de alta a un vehículo.'.PHP_EOL);
                            $servicioVehiculo->altaVehiculo(); break;
                        case 2: 
                            echo('Seleccionaste modificar un vehículo.'.PHP_EOL);
                            $servicioVehiculo->modificarVehiculo(); break;
                        case 3: 
                            echo('Seleccionaste dar de baja a un vehículo.'.PHP_EOL);
                            $servicioVehiculo->bajaVehiculo(); break;
                        case 4: 
                            echo('Seleccionaste buscar un vehículo.'.PHP_EOL);
                            $servicioVehiculo->buscarVehiculo(); break;
                        case 5: 
                            echo('Seleccionaste lista de vehículos.'.PHP_EOL);
                            $servicioVehiculo->listaVehiculo(); break;
                        case 0: 
                           /* $servicioVehiculo->grabar();*/ 
                            echo ('Regresar al Menú Principal.'.PHP_EOL); break;
                        default: 
                            echo('Opción inválida.'.PHP_EOL);
                    }
                }
                break;
                case 3:
                    $opcionR = "";
                    while ($opcionR != 0) {
                        menuReserva();
                        $opcionR = readline('Ingrese una opción: ');
                        switch ($opcionR) {
                            case 1:
                                echo('Seleccionaste dar de alta una reserva.'.PHP_EOL);
                                $servicioReserva->altaReserva();
                                break;
                            case 2:
                                echo('Seleccionaste modificar una reserva.'.PHP_EOL);
                                $servicioReserva->modificarReserva($idReserva);
                                break;
        
                            case 3:
                                echo('Seleccionaste dar de baja una reserva.' . PHP_EOL);
                                $idReserva = readline('Ingrese el ID de la reserva a dar de baja: ');
                                if (is_numeric($idReserva)) {
                                    $servicioReserva->bajaReservaPorId(intval($idReserva));
                                    } else {
                                    echo('ID de reserva no válido. Debes ingresar un número.' . PHP_EOL);
                                    }
                                     break;
        
                            case 4:
                                echo('Lista de reservas.'.PHP_EOL);
                                $servicioReserva->listaReservas();
                                // Llamar a la función para mostrar la lista de reservas
                                break;
        
                            case 0:
                              /*  $servicioVehiculo->grabar(); */
                            echo ('Regresar al Menú Principal.'.PHP_EOL); break;
                             
        
                            default:
                                echo('Opción inválida.'.PHP_EOL);
                        }
                    }
                    break;
            
            case 0: $servicioCliente->salida(); break;
        }
       
    }
    