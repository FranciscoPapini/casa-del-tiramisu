<?php
require_once('datos/Db.php');
require_once('entidades/encargado.php');

class EncargadoDb extends Db{

    public function getOne($id){
        global $mysqli;

        $sql = "SELECT e.* 
                FROM encargado AS e
                WHERE id = " . $id . "
                LIMIT 1";

        $result = $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        $encargado = new Encargado( $result->fetch_assoc() );
        $result->free();
        return $encargado;
    }

    public function getAll(){
        
        $sql = "SELECT e.*
                FROM encargado AS e
                WHERE e.eliminado = 0
                ORDER BY e.apellido ASC, e.nombre ASC";

        $result = $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'Encargado');
        $result->free();
        return $array;
    }

    public function login($user, $password){
        
        $sql = "SELECT e.* 
                FROM encargado AS e
                WHERE e.usuario = '" . $user . "'
                AND e.password = '" . md5($password) . "'
                AND e.eliminado = 0
                LIMIT 1";


        $result = $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        if($result->num_rows > 0){
	        $encargado = new Encargado( $result->fetch_assoc() );
	        $result->free();
	        return $encargado;
        }else{
        	return false;
        }
    }

    public function update($encargado){
  
            $sql = "UPDATE encargado SET nombre = '" . $encargado->getNombre() . "', 
                                       apellido = '" . $encargado->getApellido() . "', ";
                                       if($encargado->getPassword()){
                                            $sql.= "password = '".md5($encargado->getPassword())."', ";
                                        }
                                       $sql.= " 
                                       email = '" . $encargado->getEmail() . "'                   
                    WHERE id = " . $encargado->getId();
        $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        return $encargado;
    }

    public function checkEncargado($usuario){

        $sql = "SELECT e.*
        FROM encargado AS e
        WHERE e.usuario = '" . $usuario . "'";
        $result = $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        if($result->num_rows > 0){
            return false;
        }
        else{
            return true;
        }   
    }

    public function insert($encargado){

        $sql = "INSERT INTO encargado(   nombre,
                                         apellido,
                                         usuario,
                                         password,
                                         email)
                VALUES ('" . $encargado->getNombre() . "', 
                        '" . $encargado->getApellido() . "', 
                        '" . $encargado->getUsuario() . "',
                        '" . md5($encargado->getPassword()) . "',
                        '" . $encargado->getEmail() . "' )";

        $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        $encargado->setId( $this->mysqli->insert_id );
        return $encargado;
    }

    public function remove($encargado){
        $sql = "UPDATE encargado SET eliminado = 1
                WHERE id = " . $encargado->getId();
        $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        return true;
    }
}
?>