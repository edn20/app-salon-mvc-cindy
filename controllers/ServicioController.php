<?php

namespace Controllers;

use Model\CategoriaServicio;
use Model\DetalleServicio;
use Model\EstadoServicio;
use Model\Servicio;
use Model\TipoPago;
use MVC\Router;

class ServicioController {
    public static function index(Router $router) {
       if(!isset($_SESSION)) { 
            session_start();
        }
        isAdmin();
        $servicios = Servicio::all();

        foreach($servicios as $servicio) {
            $servicio->categoria = CategoriaServicio::find($servicio->categoriaId);
            $servicio->estado = EstadoServicio::find($servicio->estadoId);
            $servicio->tipopago = TipoPago::find($servicio->tipopagoId);
            $servicio->detalle = DetalleServicio::find($servicio->detalleservicioId);
        }

        $router->render('servicios/index', [
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios,
        ]);
    }

    public static function crear(Router $router) {
        if(!isset($_SESSION)) { 
            session_start();
        }
        isAdmin();

        $categorias = CategoriaServicio::all();
        $estados = EstadoServicio::all();
        $tipospagos = TipoPago::all();

        $servicio = new Servicio;
        $detalleServicio = new DetalleServicio;
        
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $detalleServicio->sincronizar($_POST);
            $alertas = $detalleServicio->validar();

            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            
            if(empty($alertas)) {
                $resultadoDetalle = $detalleServicio->guardar();
                $servicio->detalleservicioId = $resultadoDetalle['id'];
                $servicio->guardar();
                header('Location: /servicios');
            }

        }

        $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'categorias' => $categorias,
            'estados' => $estados,
            'tipospagos' => $tipospagos,
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router $router) {
        if(!isset($_SESSION)) { 
            session_start();
        }
        isAdmin();
        $id = $_GET['id'];
        if(!is_numeric($id)) {
            header('Location: /servicios');
            return;
        }
        $categorias = CategoriaServicio::all();
        $detalles = DetalleServicio::all();
        $estados = EstadoServicio::all();
        $tipospagos = TipoPago::all();

        $servicio = Servicio::find($id);
        $detalleupdate = DetalleServicio::find($servicio->detalleservicioId);
        
        $alertas = [];


        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);
            $detalleupdate->sincronizar($_POST);

            $alertas = $servicio->validar();

            if(empty($alertas)){
                $detalleupdate->guardar();
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['nombre'],
            'categorias' => $categorias,
            'detalles' => $detalles,
            'estados' => $estados,
            'tipospagos' => $tipospagos,
            'servicio' => $servicio,
            'detallesupdate' => $detalleupdate,
            'alertas' => $alertas
        ]);
    }

    public static function eliminar() {
        if(!isset($_SESSION)) { 
            session_start();
        }
        isAdmin();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $servicio = Servicio::find($id);
            $servicio->eliminar();
            header('Location: /servicios');
        }
    }
}