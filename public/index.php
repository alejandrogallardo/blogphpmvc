<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../includes/app.php';

    use MVC\Router;
    use Controllers\PaginasController;
    use Controllers\BlogController;
    use Controllers\AuthController;

    $router = new Router();

    $router->get('/', [PaginasController::class, 'index']);
    $router->get('/nosotros', [PaginasController::class, 'nosotros']);

    $router->get('/contacto', [PaginasController::class, 'contacto']);

    // AUTH
    $router->get('/login', [AuthController::class, 'login']);
    $router->get('/registro', [AuthController::class, 'registro']);

    // BLOG
    $router->get('/blog', [PaginasController::class, 'blog']);
    $router->get('/blog/crear', [BlogController::class, 'crear']);
    $router->post('/blog/crear', [BlogController::class, 'crear']);
    $router->get('/blog/actualizar', [BlogController::class, 'actualizar']);
    $router->post('/blog/actualizar', [BlogController::class, 'actualizar']);

    $router->comprobarRutas();