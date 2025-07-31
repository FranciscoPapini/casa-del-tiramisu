<?php
/*Clase Datos*/
require_once('datos/clienteDb.php');

class ClienteNegocio{
  
  public function listar(){
      $db = new ClienteDb();
      return $db->getAll();
  }

  public function recuperar($id){
  	 $db = new ClienteDb();
  	 return $db->getOne($id);
  }



  public function buscar(){ //busca un cliente
     $db = new ClienteDb();

     $cliente = $db->getOneBuscado($_POST['buscador']);

     if (is_null($cliente->getId())) { //si no existe el cliente inicio la session y voy a agregar
     $_SESSION['buscador'] = $_POST['buscador'];
     header('Location:?modulo=cliente&accion=editar');
     die();
     } else { //si existe voy a editar o ver pedidos
     unset($_SESSION['buscador']);
     header('Location:?modulo=cliente&accion=editar&id='.$cliente->getId().'&ver=1');
     die();
     }


  }




   public function guardar(){


      $_POST['nombre'] = strtolower($_POST['nombre']);
      $_POST['direccion'] = strtolower($_POST['direccion']);
    	//validar los campos recibidos por $_POST
    	$valido = true;
    	$datos = $_POST;

    	if($valido){
    	//si todo está ok, guardar en BD e informar por pantalla
    		$cliente = new Cliente($datos);
	        $db = new ClienteDb();
	        if($cliente->getId()){
	        	if( $db->update($cliente) instanceof Cliente ){
	        		Util::setMsj('El cliente fue actualizado con &eacute;xito','success');
              header('Location:?modulo=pedido&accion=listar&id_cliente='.$cliente->getId());
              die();
	        	}else{
	        		Util::setMsj('Hubo un problema actualizando el cliente','danger');
              header('Location:?modulo=cliente&accion=listar');
              die();
            }
	        }
          else{
            if( $db->checkCliente($cliente->getTelefono()) ){
  	        	if( $db->insert($cliente) instanceof Cliente ){
  	        		Util::setMsj('El cliente fue insertado con &eacute;xito','success');
                $cliente = $db->getUno();
                header('Location:?modulo=pedido&accion=editar&id_cliente='.$cliente->getId());
                die();
  	        	}else{
  	        		Util::setMsj('Hubo un problema insertando el cliente','danger');
  	        	  header('Location:?modulo=cliente&accion=listar');
                die();

              }
	        }
          else{
            Util::setMsj('El cliente <strong>' . $cliente->getNombre() . '</strong> con tel&eacute;fono <strong>' . $cliente->getTelefono() . '</strong> ya existe','danger');
            header('Location:?modulo=cliente&accion=listar');
            die();
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
            $cliente = new Cliente($datos);
            $db = new ClienteDb();

            if( $db->remove($cliente)){
                Util::setMsj('El cliente <strong>'.$_POST['nombre'].'</strong> fue eliminado con &eacute;xito','success');
            }else{
                Util::setMsj('Hubo un problema eliminando el cliente','danger');
            }
            header('Location:?modulo=cliente&accion=listar');
            die();
        }else{
        //si hay algun error, informar por pantalla
        }
    }
}


?>