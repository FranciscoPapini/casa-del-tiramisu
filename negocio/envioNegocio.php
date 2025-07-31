<?php
/*Clase Datos*/
require_once('datos/envioDb.php');

class EnvioNegocio{
  
    public function recuperar($date){
        $db = new EnvioDb();
        return $db->getOne($date);
    }

    public function guardar(){

    	//validar los campos recibidos por $_POST
    	$valido = true;
    	$datos = $_POST;

    	if($valido){
    	//si todo está ok, guardar en BD e informar por pantalla
    		
    		$envio = new Envio($datos);
	        $db = new EnvioDb();
	        
	        
	        if($db->insert($envio) instanceof Envio ){
	        		Util::setMsj('El env&iacute;o fue actualizado con &eacute;xito','success');
	        		header('Location:?modulo=envio&accion=editar');
              die();
	        	}else{
	        		Util::setMsj('Hubo un problema actualizando el env&iacute;o','danger');
	        	}
	        
    	}else{
    	//si hay algun error, informar por pantalla
    	}

    }
  
}

?>