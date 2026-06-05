<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController {
    public static function index() {
       $servicios = Servicio::allServiciosAPI();

       $categorias = [];

        foreach($servicios as $servicio) {
            $categoriaId = $servicio->categoriaId;

            if(!isset($categorias[$categoriaId])) {
                $categorias[$categoriaId] = [
                    'id' => $servicio->categoriaId,
                    'nombre' => $servicio->categoria,
                    'servicios' => []
                ];
            }

            $categorias[$categoriaId]['servicios'][] = [
                'id' => $servicio->id,
                'nombre' => $servicio->nombre,
                'precio' => $servicio->precio,
                'categoriaId' => $servicio->categoriaId,
                'categoria' => $servicio->categoria,
                'estadoId' => $servicio->estadoId,
                'estado' => $servicio->estado,
                'tipopagoId' => $servicio->tipopagoId,
                'tipopago' => $servicio->tipopago,
                'detalleservicioId' => $servicio->detalleservicioId,
                'detalle' => $servicio->detalle,
                'tiempo' => $servicio->tiempo,
                'recomendaciones' => $servicio->recomendaciones
            ];
        }
        
       echo json_encode(array_values($categorias));
    }

    public static function guardar() {
        // Almacena la cita y devuelve el ID
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();
        $id = $resultado['id'];
        
        // Almacena la Cita y los Servicios
        $idServicios = explode(",", $_POST['servicios']);

        foreach($idServicios as $idServicio) {
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

        echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $cita = Cita::find($id);
            $cita->eliminar();
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}