<?php
require_once 'app/controller/Controller.php';
require_once 'app/model/TaskModel.php';

class TaskApiController extends Controller {

    private $model;

    public function __construct() {
        parent::__construct();
        $this->model = new TaskModel();
    }

    public function getAll() { //debo poner el token
        $user = $this->authHelper->currentUser(); 
        if($user){
           
            try {
                // Obtener todas las tareas del modelo
                if(empty($_GET['atr']) && empty($_GET['order']) )
                    $tareas = $this->model->getAll();
                else
                    $tareas = $this->model->getAll($_GET['atribute'], $_GET['order']);
               
                if($tareas){
                    $response = [
                    "status" => 200,
                    "data" => $tareas
                    ];
                    // Si hay tareas, devolverlas con un código 200 (éxito)
                    $this->view->response($response, 200);
                }
                else
                    // Si no hay tareas, devolver un mensaje con un código 404 (no encontrado)
                        $this->view->response("No hay tareas en la base de datos", 404);
            } catch (Exception $e) {
                // En caso de error del servidor, devolver un mensaje con un código 500 (error del servidor)
                $this->view->response("Error de servidor", 500);
            }
        }else{
            $this->view->response("Sin autorizacion", 401);
        }
    }

    public function getTask($params = null) {
        $user = $this->authHelper->currentUser(); 
        if($user){
            $id = $params[':ID'];
    
            try {
                // Obtiene una tarea del modelo
                $tarea = $this->model->get($id);
                // Si existe la tarea, la retorna con un código 200 (éxito)
                if($tarea){
                    $response = [
                    "status" => 200,
                    "message" => $tarea
                   ];
                    $this->view->response($response, 200);
                //    $this->view->response($tareas, 200);
                }
                else{
                    $response = [
                        "status" => 404,
                        "message" => "No existe la tarea en la base de datos."
                    ];
                    $this->view->response($response, 404);
                }
            } catch (Exception $e) {
                // En caso de error del servidor, devolver un mensaje con un código 500 (error del servidor)
                $this->view->response("Error de servidor", 500);
            }
        }else{
            $this->view->response("Sin autorizacion", 401);
        }
    }  
    
    public function addTarea() {
        $tareaNueva = $this->getData();

        $lastId = $this->model->insert(
                $tareaNueva->titulo, 
                $tareaNueva->descripcion, 
                $tareaNueva->prioridad);
        
        if($lastId){
            $this->view->response("Se insertó correctamente con id: $lastId", 200);
        }else{
             $this->view->response("No se pudo insertar correctamente la tarea", 404);
        }


    }

    public function borrarTarea($params = null) {
        $id = $params[':ID'];
        $tarea = $this->model->get($id);
        if ($tarea) {
            $this->model->delete($id);

            $this->view->response("Tarea $id, eliminada", 200);
        } else {
            $this->view->response("Tarea $id, no encontrada", 404);
        }
    }

    public function finalizarTarea($params = null) {
        $id = $params[':ID'];
        $tarea = $this->model->get($id);
        if ($tarea) {
            $titulo = $tarea->nombre;
            $this->model->finalize($id);

            $this->view->response("Tarea $titulo, finalizada", 200);
        } else {
            $this->view->response("Tarea $id, no encontrada", 404);
        }
    }    
}