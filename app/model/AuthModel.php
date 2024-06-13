<?php 

require_once "app/model/Model.php";

class authModel extends Model {

    function getUser($email){
        $db = $this->createConexion();
       
        //Enviar la consulta
        $sentencia = $db->prepare("SELECT * FROM usuario WHERE email = ?");
        $sentencia->execute([$email]);
        $usuario = $sentencia->fetch(PDO::FETCH_OBJ);
        return $usuario;

    }

}