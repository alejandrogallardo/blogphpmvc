<?php

namespace Controllers;
use MVC\Router;
use Model\AuthModel;
use Intervention\Image\ImageManagerStatic as Image;

class AuthController {
    public static function login(Router $router){

        $router->render('auth/login');

        /*$router->render('auth/login', [
            //'inicio' => true,
            //'propiedades' => $propiedades
        ]);*/
    }

    public static function registro(Router $router){

        $router->render('auth/registro');

        /*$router->render('auth/registro', [
            //'inicio' => true,
            //'propiedades' => $propiedades
        ]);*/
    }
}