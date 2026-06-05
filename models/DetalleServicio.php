<?php

namespace Model;

class DetalleServicio extends ActiveRecord {
    protected static $tabla = 'detallesservicios';
    protected static $columnasDB = ['id', 'detalle', 'tiempo', 'recomendaciones'];

    public $id;
    public $detalle;
    public $tiempo;
    public $recomendaciones;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->detalle = $args['detalle'] ?? '';
        $this->tiempo = $args['tiempo'] ?? '';
        $this->recomendaciones = $args['recomendaciones'] ?? '';
    }

    public function validar() {
        if(!$this->detalle) {
            self::$alertas['error'][] = 'El detalle del servicio es obligatorio';
        }
        if(!$this->tiempo) {
            self::$alertas['error'][] = 'El tiempo del servicio es obligatorio';
        }
        if(!is_numeric($this->tiempo)) {
            self::$alertas['error'][] = 'El tiempo no es valido';
        }
        if(!$this->recomendaciones) {
            self::$alertas['error'][] = 'El consejo del servicio es obligatoria';
        }
        
        return self::$alertas;
    }

    
}