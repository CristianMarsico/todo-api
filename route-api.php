<?php
    require_once('libs/Router.php');
    require_once 'config.php';
    require_once('app/controller/Controller.php');
    require_once('app/controller/TaskApiController.php');
    require_once('app/controller/AuthApiController.php');
    

    $router = new Router();

    // GET http://localhost/api/tareas 
    $router->addRoute('tareas', 'GET', 'TaskApiController', 'getAll');
    $router->addRoute('tareas/:ID', 'GET', 'TaskApiController', 'getTask');

    $router->addRoute('tareas', 'POST', 'TaskApiController', 'addTarea');
    $router->addRoute('tareas/:ID', 'DELETE', 'TaskApiController', 'borrarTarea');
    $router->addRoute('tareas/:ID', 'PUT', 'TaskApiController', 'finalizarTarea');


    $router->addRoute('auth', 'POST',    'AuthApiController', 'login');
    $router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
