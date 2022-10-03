<?php
    require '../config/database.php';
    require '../config/functions.php';
    require __DIR__ . '/../vendor/autoload.php';

    $db = Conexion::conectar();
    use Model\ActiveRecord;
    ActiveRecord::setDB($db);