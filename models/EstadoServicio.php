<?php

namespace Model;

class EstadoServicio extends ActiveRecord {
    protected static $tabla = 'estadosservicios';
    protected static $columnasDB = ['id', 'estado'];

    public $id;
    public $estado;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->estado = $args['estado'] ?? '';
    }

    
}