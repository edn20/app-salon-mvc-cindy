<?php

namespace Model;

class Servicio extends ActiveRecord {
    // Bade de datos
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'nombre', 'precio', 'categoriaId', 'estadoId', 'tipopagoId', 'detalleservicioId'];

    public $id;
    public $nombre;
    public $precio;
    public $categoriaId;
    public $estadoId;
    public $tipopagoId;
    public $detalleservicioId;
    public $categoria;
    public $estado;
    public $tipopago;
    public $detalle;
    public $tiempo;
    public $recomendaciones;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->categoriaId = $args['categoriaId'] ?? '';
        $this->estadoId = $args['estadoId'] ?? '';
        $this->tipopagoId = $args['tipopagoId'] ?? '';
        $this->detalleservicioId = $args['detalleservicioId'] ?? '';
    }

    public function validar() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre del servicio es obligatorio';
        }
        if(!$this->precio) {
            self::$alertas['error'][] = 'El precio del servicio es obligatorio';
        }
        if(!is_numeric($this->precio)) {
            self::$alertas['error'][] = 'El precio no es valido';
        }
        if(!$this->categoriaId) {
            self::$alertas['error'][] = 'La categoría del servicio es obligatoria';
        }
        if(!$this->estadoId) {
            self::$alertas['error'][] = 'El estado del servicio es obligatorio';
        }
        if(!$this->tipopagoId) {
            self::$alertas['error'][] = 'El tipo de pago es obligatorio';
        }
        
        return self::$alertas;
    }

    public static function allServiciosAPI() {
        $consulta = "SELECT servicios.id, servicios.nombre, servicios.precio, ";
        $consulta .= " servicios.categoriaId, servicios.estadoId, servicios.tipopagoId, servicios.detalleservicioId, ";
        $consulta .= " categoriasservicios.nombre AS categoria, ";
        $consulta .= " estadosservicios.estado AS estado, ";
        $consulta .= " tipospago.nombre AS tipopago, ";
        $consulta .= " detallesservicios.detalle, detallesservicios.tiempo, detallesservicios.recomendaciones ";
        $consulta .= " FROM servicios ";
        $consulta .= " LEFT OUTER JOIN categoriasservicios ";
        $consulta .= " ON servicios.categoriaId = categoriasservicios.id ";
        $consulta .= " LEFT OUTER JOIN estadosservicios ";
        $consulta .= " ON servicios.estadoId = estadosservicios.id ";
        $consulta .= " LEFT OUTER JOIN tipospago ";
        $consulta .= " ON servicios.tipopagoId = tipospago.id ";
        $consulta .= " LEFT OUTER JOIN detallesservicios ";
        $consulta .= " ON servicios.detalleservicioId = detallesservicios.id ";
        $consulta .= " WHERE estadosservicios.estado = 'Activo' ";
        $consulta .= " ORDER BY categoriasservicios.nombre ASC, servicios.nombre ASC ";

    return self::consultarSQL($consulta);
    }



    
}