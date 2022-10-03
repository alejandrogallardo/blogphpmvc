<?php

namespace Controllers;
use MVC\Router;
use Model\BlogModel;

class PaginasController {

    public static function index(Router $router){
        // echo 'Index';
        $router->render('paginas/index', [
            //'inicio' => true,
            //'propiedades' => $propiedades
        ]);
    }

    public static function nosotros(Router $router){
        $router->render('paginas/nosotros', [
            //'inicio' => true,
            //'propiedades' => $propiedades
        ]);
    }

    public static function blog(Router $router){
        $entradas = BlogModel::all();
        //debuguear($entradas);
        $router->render('paginas/blog', [
            'entradas' => $entradas
        ]);
    }

    public static function contacto(Router $router){
        $router->render('paginas/contacto');
    }
}