<?php
/*Clase Datos*/
require_once('datos/productoDb.php');
require_once('datos/precioDb.php');

class ProductoNegocio{
  
  public function listar(){
      $db = new ProductoDb();
      return $db->getAll();
  }

  public function recuperar($id){
  	 $db = new ProductoDb();
  	 return $db->getOne($id);
  }

  public function guardar(){

    	//validar los campos recibidos por $_POST
    	$valido = true;

      $_POST['nombre'] = strtolower($_POST['nombre']);
      $_POST['descripcion'] = strtolower($_POST['descripcion']);

    	$datos = $_POST;

    	if($valido){
    	//si todo está ok, guardar en BD e informar por pantalla
    		$producto = new Producto($datos);
	        $db = new ProductoDb();

  	        if($producto->getId()){

	        	if( $db->update($producto) instanceof Producto ){
	        		Util::setMsj('El producto fue actualizado con &eacute;xito','success');
	        		header('Location:?modulo=producto&accion=listar');
              die();
	        	}else{
	        		Util::setMsj('Hubo un problema actualizando el producto','danger');
	        	}
	        }else{

	        	if( $db->insert($producto) instanceof Producto ){
	        		Util::setMsj('El producto fue insertado con &eacute;xito','success');
	        		header('Location:?modulo=producto&accion=listar');
              die();
	        	}else{
	        		Util::setMsj('Hubo un problema insertando el producto','danger');
	        	}
	        }
    	}else{
    	//si hay algun error, informar por pantalla
    	}

    }

    public function eliminar(){

        //validar los campos recibidos por $_POST
        $valido = true;
        $datos = $_POST;

        if($valido){
        //si todo está ok, guardar en BD e informar por pantalla
            $producto = new Producto($datos);
            $db = new ProductoDb();

            if( $db->remove($producto)){
                Util::setMsj('El producto <strong>'.$producto->getNombre().'</strong> fue eliminado con &eacute;xito','success');
            }else{
                Util::setMsj('Hubo un problema eliminando el producto','danger');
            }
            header('Location:?modulo=producto&accion=listar');
            die();
        }else{
        //si hay algun error, informar por pantalla
        }
    }
}


?>