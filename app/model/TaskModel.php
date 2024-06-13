<?php
require_once "app/model/Model.php";

class TaskModel extends Model{

    /*Estamos en el modelo de TAREAS, por ende, 
    se pueden utilizar nombres más concisos y descriptivos. 
    Por ejemplo, en lugar de getAllTasks(), simplemente getAll() podría ser 
    suficiente si queda claro que se refiere a todas las tareas.

    (HACER LO MISMO EN LOS CONTROLADORES Y VISTAS)
    */

    function getAll(){
        //abrimos la conexion;
        $db = $this->createConexion();
       
        //Enviar la consulta
        $sentencia = $db->prepare("SELECT * FROM tarea");
        $sentencia->execute();
        $tareas = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $tareas;
    }
    
    function insert($nombre, $descr, $prioridad){
        //abrimos la conexion;
        $db = $this->createConexion();
       
        //Enviar la consulta
        $resultado= $db->prepare("INSERT INTO tarea (nombre, descripcion, prioridad) VALUES (?,?,?)");
        $resultado->execute([$nombre, $descr, $prioridad]); // ejecuta
    }
    
    
    function delete($id){
        $db = $this->createConexion();
        $resultado= $db->prepare("DELETE FROM tarea WHERE id = ?");
        $resultado->execute([$id]); // ejecuta
    }
    
    function finalize($id){
        $db = $this->createConexion();
        $resultado= $db->prepare("UPDATE tarea SET finalizada = ? WHERE id = ?");
        $resultado->execute([1,$id]); // ejecuta
    }
    
    function get($id){
        //abrimos la conexion;
        $db = $this->createConexion();
       
        //Enviar la consulta
        $sentencia = $db->prepare("SELECT * FROM tarea WHERE id = ?");
        $sentencia->execute([$id]);
        $tarea = $sentencia->fetch(PDO::FETCH_OBJ);
        return $tarea;
    }
}