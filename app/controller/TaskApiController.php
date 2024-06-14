<?php
require_once('app/model/TaskModel.php');
require_once('app/view/JSONView.php');

class TaskApiController {

    private $model;
    private $view;

    private $data;

    public function __construct() {
        $this->model = new TaskModel();
        $this->view = new JSONView();

        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }

    public function getTasks() {

        try {
            // Obtener todas las tareas del modelo
            $tareas = $this->model->getAll();
            if($tareas){
                $response = [
                "status" => 200,
                "data" => $tareas
               ];
                $this->view->response($response, 200);
            //    $this->view->response($tareas, 200);

            }
                 // Si hay tareas, devolverlas con un código 200 (éxito)
            else
                // Si no hay tareas, devolver un mensaje con un código 404 (no encontrado)
                 $this->view->response("No hay tareas en la base de datos", 404);
        } catch (Exception $e) {
            // En caso de error del servidor, devolver un mensaje con un código 500 (error del servidor)
            $this->view->response("Error de servidor", 500);
        }
    }

    public function getTask($params = null) {
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

    }  
    
    // public function addTarea() {
    //     $tareaNueva = $this->getData();

    //     $lastId = $this->model->save(
    //             $tareaNueva->titulo, 
    //             $tareaNueva->descripcion, 
    //             $tareaNueva->prioridad);

    //     $this->view->response("Se insertó correctamente con id: $lastId", 200);

    // }

    // public function borrarTarea($params = null) {
    //     $id = $params[':ID'];
    //     $tarea = $this->model->get($id);
    //     if ($tarea) {
    //         $this->model->delete($id);

    //         $this->view->response("Tarea $id, eliminada", 200);
    //     } else {
    //         $this->view->response("Tarea $id, no encontrada", 404);
    //     }
    // }

    // public function finalizaTarea($params = null) {
    //     $id = $params[':ID'];
    //     $tarea = $this->model->get($id);
    //     if ($tarea) {
    //         $titulo = $tarea->titulo;
    //         $this->model->end($id);

    //         $this->view->response("Tarea $titulo, finalizada", 200);
    //     } else {
    //         $this->view->response("Tarea $id, no encontrada", 404);
    //     }
    // }    
}