<?php

namespace Model;

class ActiveRecord {

    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    // Errores
    protected static $errores = [];


    // Definir la conexión a la BD
    public static function setDB($database) {
        self::$db = $database;
    }

    // Validación
    public static function getErrores() {
        return static::$errores;
    }

    public function validar() {
        static::$errores = [];
        return static::$errores;
    }

    // Registros - CRUD
    public function guardar() {
        $resultado = '';
        if(!is_null($this->id)) {
            $resultado = $this->actualizar();
        } else {
            $resultado = $this->crear();
        }
        return $resultado;
    }

    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE id = ${id}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    public static function get($limite) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT ${limite}";

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // ===========================================
    // CREA NUEVO REGISTRO PDO
    // ===========================================
    public function crear() {
        $atributos = $this->sanitizarAtributos();
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";
        $resultado = self::$db->prepare($query);
        if ($resultado -> execute()) {
            return "ok";
        } else {
            return "error";
        }
        $resultado = null;
    }

    // ===========================================
    // ACTUALIZA REGISTRO PDO
    // ===========================================
    public function actualizar() {
        $atributos = $this->sanitizarAtributos();
        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }
        $query = "UPDATE " . static::$tabla ." SET ";
        $query .=  join(', ', $valores );
        $query .= " WHERE id = '" . trim($this->id) . "' ";
        $query .= " LIMIT 1 ";
        $resultado = self::$db->prepare($query);
        if ($resultado -> execute()) {
            return "ok";
        } else {
            return "error";
        }
        $resultado = null;
    }

    // Eliminar un registro
    public function eliminar() {
        // Eliminar el registro
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);

        if($resultado) {
            $this->borrarImagen();
        }

        return $resultado;
    }

    // ===========================================
    // CONSULTA SQL PDO
    // ===========================================
    public static function consultarSQL($query) {
        $stmt = self::$db->prepare($query);
        $stmt->execute();
        $array = [];
        while($registro = $stmt->fetch()) {
            $array[] = static::crearObjeto($registro);
        }
        return $array;
    }

    protected static function crearObjeto($registro) {
        $objeto = new static;
        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key  )) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }



    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    // TODO: REVISAR COMO LIMPIAR LOS DATOS
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        //TODO: buscar la forma de sanitizar con PDO
        foreach($atributos as $key => $value ) {
            // $sanitizado[$key] = self::$db->escape_string($value);
            // $sanitizado[$key] = self::$db->FILTER_SANITIZE_STRING($value);
            $sanitizado[$key] = htmlspecialchars($value);
            //$sanitizado[$key] = $value;
        }
        return $sanitizado;
    }


    public function sincronizar($args = []) {
        foreach($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    // Subida de archivos
    public function setImagen($imagen) {
        // Elimina la imagen previa
        if( !is_null($this->id) ) {
            $this->borrarImagen();
        }
        // Asignar al atributo de imagen el nombre de la imagen
        if($imagen) {
            $this->imagen = $imagen;
        }
    }

    // Elimina el archivo
    public function borrarImagen() {
        // Comprobar si existe el archivo
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }
}