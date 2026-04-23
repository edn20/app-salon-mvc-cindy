<?php 

namespace Controllers;

use Model\AdminCita;
use Model\Cita;
use MVC\Router;

class CitaController {
    public static function index(Router $router) {
        session_start();
        isAuth();

        $router->render('cita/index', [
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id']
        ]);
    }

    public static function mostrar(Router $router) {
        session_start();
        isAuth();
        
        $usuarioId = $_GET['id'] ?? '';
        $usuarioAuth = $_SESSION['id'];

        //Validar GET numerico
        if(!is_numeric($usuarioId)) {
            header('Location: /cita');
        }

        //Validar que el usuario no intente ver los datos de otro usuario
        if($usuarioId !== $usuarioAuth) {
            header('Location: /cita');
        }


        
                
        //Consultar la base de datos
        $consulta = "SELECT citas.id, citas.hora, citas.fecha, usuarios.id as usuarioId, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasServicios ";
        $consulta .= " ON citasServicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasServicios.servicioId ";
        $consulta .= " WHERE usuarioId =  '${usuarioId}' ";

        $citas = AdminCita::SQL($consulta);

        $router->render('citas/mostrar', [
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id'],
            'citas' => $citas
        ]);
    }

    public static function actualizar(Router $router) {
        session_start();
        isAuth();

        $id = $_GET['id'];

        $cita = Cita::find($id);
        $alertas = [];


        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cita->sincronizar($_POST);
            $alertas = $cita->validar();
            if(empty($alertas)) {
                $cita->guardar();
                header('Location: /cita?reagendada=1');
            }
        }

        $router->render('citas/actualizar', [
            'nombre' => $_SESSION['nombre'],
            'cita' => $cita,
            'alertas' => $alertas
            
        ]);
    }
}