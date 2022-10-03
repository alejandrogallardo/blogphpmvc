<?php

namespace Model;

class BlogModel extends ActiveRecord {

    protected static $tabla = 'entrada';
    protected static $columnasDB = ['id', 'titulo', 'entrada', 'imagen'];


    public $id;
    public $titulo;
    public $entrada;
    public $imagen;
//    public $fecha;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->entrada = $args['entrada'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
    }

    public function validar() {

        if(!$this->titulo) {
            self::$errores[] = "Debes añadir un titulo";
        }

        if(!$this->entrada) {
            self::$errores[] = 'La entrada es Obligatoria';
        }

        if(!$this->id )  {
            $this->validarImagen();
        }
        return self::$errores;
    }

    public function validarImagen() {
        if(!$this->imagen ) {
            self::$errores[] = 'La Imagen es Obligatoria';
        }
    }

}