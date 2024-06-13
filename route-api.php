<?php
    require_once('libs/Router.php');
    require_once('app/controller/TaskApiController.php');
    

    $router = new Router();

    // GET http://localhost/api/tareas 
    $router->addRoute('tareas', 'GET', 'TaskApiController', 'getAll');
    //$router->addRoute('tareas', 'GET', 'TaskApiController', 'obtenerTareas');
    $router->addRoute('tareas/:ID', 'GET', 'TaskApiController', 'getTask');

    // $router->addRoute('tareas', 'POST', 'TaskApiController', 'addTarea');
    // $router->addRoute('tareas/:ID', 'DELETE', 'TaskApiController', 'borrarTarea');
    // $router->addRoute('tareas/:ID', 'PUT', 'TaskApiController', 'finalizaTarea');

    $router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
