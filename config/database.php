<?php
class Conexion {
    static public function conectar(){
        $link = new PDO('mysql:host=localhost;port=3307;dbname=blog_mvc_test', 'perro', '123456');
        $link->exec('set names utf8');
        return $link;
    }
}