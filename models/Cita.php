<?php

namespace Model;

class Cita extends ActiveRecord {
    // BAse de datos
    protected static $tabla = 'citas';
    protected static $columnasDB = ['id','fecha','hora','usuarioId'];

    public $id;
    public $fecha;
    public $hora;
    public $usuarioId;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->usuarioId = $args['usuarioId'] ?? '';
    }

    public function validar() {
        if(!$this->fecha) {
            self::$alertas['error'][] = 'Debe escoger una fecha';
        }
        if($this->fecha) {
            $timestamp = strtotime($this->fecha);
            $diaSemana = date('w', $timestamp);

            if($diaSemana == 0) {
                self::$alertas['error'][] ='No laboramos los domingos';
            }
        }
        if(!$this->hora) {
            self::$alertas['error'][] = 'Debe escoger una hora';
        }
        if($this->hora) {
            $horaMinima = '09:00';
            $horaMaxima = '20:00';

            if($this->hora < $horaMinima || $this->hora > $horaMaxima) {
                self::$alertas['error'][] = 'Nuestro horario de antención es de 9:00 a 20:00';
            }
        }
        

        return self::$alertas;
    }
}