<?php

namespace Controllers;
use MVC\Router;
use Model\BlogModel;
use Intervention\Image\ImageManagerStatic as Image;

class BlogController {

    public static function index(Router $router){
        // echo 'Index';
        $router->render('blog/index', [
            //'inicio' => true,
            //'propiedades' => $propiedades
        ]);
    }

    // ===============================================
    // CREACION DE ENTRADA
    // ===============================================
    public static function crear(Router $router){
        $errores = BlogModel::getErrores();
        $entrada = new BlogModel;
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $entrada = new BlogModel($_POST['entrada']);
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";
            if($_FILES['entrada']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['entrada']['tmp_name']['imagen'])->fit(800,600);
                $entrada->setImagen($nombreImagen);
            }
            $errores = $entrada->validar();
            if(empty($errores)){
                if(!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }
                $image->save(CARPETA_IMAGENES . $nombreImagen);
                $resultado = $entrada->guardar();
                if($resultado == "ok") {
                    header('location: /blog');
                }
            }
        }
        $router->render('blog/crear', [
            //'inicio' => true,
            'entrada' => $entrada,
            'errores' => $errores
        ]);
    }

    // ===============================================
    // ACTUALIZACION DE ENTRADA
    // ===============================================
    public static function actualizar(Router $router) {
        $id = validarORedireccionar('/blog');
        $entrada = BlogModel::find($id);
        $errores = BlogModel::getErrores();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $args = $_POST['entrada'];
            $entrada->sincronizar($args);
            $errores = $entrada->validar();
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";
            if($_FILES['entrada']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['entrada']['tmp_name']['imagen'])->fit(800,600);
                $entrada->setImagen($nombreImagen);
            }
            if (empty($errores)) {
                if($_FILES['entrada']['tmp_name']['imagen']) {
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }
                $resultado = $entrada->guardar();
                if($resultado == "ok") {
                    header('location: /blog');
                }
            }
        }
        $router->render('blog/actualizar', [
            'entrada' => $entrada,
            'errores' => $errores
        ]);
    }

    public static function blog(Router $router){
        $entradas = BlogModel::all();
        $router->render('paginas/blog', [
            'entradas' => $entradas
        ]);
    }

    public static function contacto(Router $router){
        $router->render('paginas/contacto');
    }
}