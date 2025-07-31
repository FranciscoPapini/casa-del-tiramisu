<?php
/*Clase Datos*/
require_once('datos/precioDb.php');

class PrecioNegocio{
  
    public function recuperar($id_producto, $date){
        $db = new PrecioDb();
        return $db->getOne($id_producto, $date);
    }

    public function guardar(){

    	//validar los campos recibidos por $_POST
    	$valido = true;
    	$datos = $_POST;

    	if($valido){
    	//si todo está ok, guardar en BD e informar por pantalla
    		
    		$gavet = new Precio($datos);
	        $db = new PrecioDb();
	        
	        
	        if($db->insert($precio) instanceof Precio ){
	        		Util::setMsj('El precio fue actualizado con &eacute;xito','success');
	        		header('Location:?modulo=precio&accion=editar');
              die();
	        	}else{
	        		Util::setMsj('Hubo un problema actualizando el precio','danger');
	        	}
	        
    	}else{
    	//si hay algun error, informar por pantalla
    	}

    }
  
}

?>