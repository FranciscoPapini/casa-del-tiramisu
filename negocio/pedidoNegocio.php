<?php
/*Clase Datos*/
require_once('datos/pedidoDb.php');

class PedidoNegocio{
  
  public function listar($id_cliente){
      $db = new PedidoDb();
      return $db->getAll($id_cliente);
  }

  public function recuperar($id){
  	 $db = new PedidoDb();
  	 return $db->getOne($id);
  }

  public function mostrar($fecha1, $fecha2){ //si esta en uso, dependiendo de las fechas me trae en esos valores pedidos pend.
      $db = new PedidoDb();
      return $db->getTodos($fecha1, $fecha2);
  }

  public function mostrarMes($fecha){ // no esta en uso, me trae pedidos pendientes
      $db = new PedidoDb();
      return $db->getTodosMes($fecha);
  }

  public function pendientes($fecha){ //no esta en uso, me trae los pedidos pendientes segun una fecha
     $db = new PedidoDb();
     return $db->getPendientes($fecha);
  }

   public function guardar(){

    if($_POST['nuevo_producto'] == 1) {

require_once('datos/productoDb.php');
require_once('datos/precioDb.php');

      $_POST['nombre'] = strtolower($_POST['nombre']);
      $_POST['descipcion'] = strtolower($_POST['descipcion']);

      $valido = true;

      $datos = $_POST;

      if($valido){
      //si todo está ok, guardar en BD e informar por pantalla
        $producto = new Producto($datos);
          $db = new ProductoDb();

            if($producto->getId()){
          }else{

            if( $db->insert($producto) instanceof Producto ){
              Util::setMsj('El producto fue insertado con &eacute;xito','success');
              if ($_POST['id_pedido']){
              header('Location:?modulo=pedido&accion=editar&id='.$_POST['id_pedido'].'&id_cliente='.$_POST['id_cliente']);
              } else {
              header('Location:?modulo=pedido&accion=editar&id_cliente='.$_POST['id_cliente']);
              }
              die();
            }else{
              Util::setMsj('Hubo un problema insertando el producto','danger');
              header('Location:?modulo=pedido&accion=editar&id_cliente='.$_POST['id_cliente']);
            }
          }
      }else{
      //si hay algun error, informar por pantalla
      }







    } else { 



      $_POST['direccion'] = strtolower($_POST['direccion']);
      $_POST['descipcion'] = strtolower($_POST['descipcion']);
    	//validar los campos recibidos por $_POST
    	$valido = true;
    	$datos = $_POST;

      if($datos['envio']){ //si viene con envio seteo el precio del envio
        $precio = $_POST['precioenvio'];
      }
      else{
        $precio = 0;
      }  

      if($_POST['id_cliente'] == 1) //si es una venta (cliente id=1) seteo estos valores
      {
        $datos['venta'] = 1;
        $precio = 0;
      }
      else {
        $datos['venta'] = 0;
      }
      $datos['fecha'] = Util::dateToDb($datos['fecha']);

  

      for($i=0; $i<count($datos['preciosSugeridos']); $i++){
        $precio += $datos['preciosSugeridos'][$i];
      }

      $datos['precio'] = $precio;

    	if($valido){
    	//si todo está ok, guardar en BD e informar por pantalla
      		$pedido = new Pedido($datos);
	        $db = new PedidoDb();

            if($pedido->getId()){
	        	if( $db->update($pedido) instanceof Pedido ){
              if($datos['venta'] == 0) { //si es una venta
              Util::setMsj('El pedido fue actualizado con &eacute;xito','success');
              } else {
              Util::setMsj('La venta fue actualizada con &eacute;xito','success');
              }
	        	}else{

              if($datos['venta'] == 0) { 
              Util::setMsj('Hubo un problema actualizando el pedido','danger');
              } else {
              Util::setMsj('Hubo un problema actualizando la venta','danger');
              }
	        	}
	        }else{

	        	if( $db->insert($pedido) instanceof Pedido ){
              if($datos['venta'] == 0) { //si es una venta
              Util::setMsj('El pedido fue insertado con &eacute;xito','success');
              } else {
              Util::setMsj('La venta fue insertada con &eacute;xito','success');
              }
	        	}else{

              if($datos['venta'] == 0) { 
              Util::setMsj('Hubo un problema insertando el pedido','danger');
              } else {
              Util::setMsj('Hubo un problema insertando la venta','danger');
              }

	        	}
	        }
          unset($_SESSION['buscador']); //vacio la session
          header('Location:?modulo=pedido&accion=listar&id_cliente='.$_GET['id_cliente']);
          die();
    	}else{
    	//si hay algun error, informar por pantalla
    	}

    } //de producto nuevo == 1

    }



public function guardarVenta(){


    if($_POST['nuevo_producto'] == 1) {


require_once('datos/productoDb.php');
require_once('datos/precioDb.php');

      $_POST['nombre'] = strtolower($_POST['nombre']);
      $_POST['descipcion'] = strtolower($_POST['descipcion']);

      $valido = true;

      $datos = $_POST;

      if($valido){
      //si todo está ok, guardar en BD e informar por pantalla
        $producto = new Producto($datos);
          $db = new ProductoDb();

            if($producto->getId()){
          }else{

            if( $db->insert($producto) instanceof Producto ){
              Util::setMsj('El producto fue insertado con &eacute;xito','success');

              if ($_POST['id_pedido']){
              header('Location:?modulo=pedido&accion=editar&id='.$_POST['id_pedido'].'&id_cliente='.$_POST['id_cliente']);
              } else {
              header('Location:?modulo=pedido&accion=generar');
              }

              die();
            }else{
              Util::setMsj('Hubo un problema insertando el producto','danger');
              header('Location:?modulo=pedido&accion=editar&id_cliente='.$_POST['id_cliente']);
            }
          }
      }else{
      //si hay algun error, informar por pantalla
      }



    } else {


      $_POST['direccion'] = strtolower($_POST['direccion']);
      $_POST['descipcion'] = strtolower($_POST['descipcion']);
      //validar los campos recibidos por $_POST
      $valido = true;
      $datos = $_POST;

      $datos['fecha'] = Util::dateToDb($datos['fecha']);

      $datos['envio'] = 0;
      $datos['venta'] = 1;
      $precio = 0;    

      for($i=0; $i<count($datos['preciosSugeridos']); $i++){
        $precio += $datos['preciosSugeridos'][$i];
      }

      $datos['precio'] = $precio;

      if($valido){
      //si todo está ok, guardar en BD e informar por pantalla
          $pedido = new Pedido($datos);
          $db = new PedidoDb();

            if($pedido->getId()){
            
              Util::setMsj('No es posible realizar esto','danger');
              header('Location:?modulo=cliente&accion=buscar');
              die();

          }else{

            if( $db->insert($pedido) instanceof Pedido ){ //inserto la venta
              Util::setMsj('La venta fue insertada con &eacute;xito','success');
            }else{
              Util::setMsj('Hubo un problema insertando la venta','danger');
            }
          }
          unset($_SESSION['buscador']);
          header('Location:?modulo=pedido&accion=listar&id_cliente=1');
          die();
      }else{
      //si hay algun error, informar por pantalla
      }

    } //si es nuevo producto

    }



        public function eliminar(){

        //validar los campos recibidos por $_POST
        $valido = true;
        $datos = $_POST;

        if($valido){
        //si todo está ok, guardar en BD e informar por pantalla
            $pedido = new Pedido($datos);
            $db = new PedidoDb();

            if( $db->remove($pedido)){

              if($pedido->getIdCliente() == 1) { //si es una venta
              Util::setMsj('La venta fue eliminada con &eacute;xito','success');
              } else {
              Util::setMsj('El pedido fue eliminado con &eacute;xito','success');
              }

            }else{

              if($pedido->getIdCliente() == 1) { //si es una venta
              Util::setMsj('Hubo un problema eliminando la venta','danger');
              } else {
                Util::setMsj('Hubo un problema eliminando el pedido','danger');
              }
            }
            header('Location:?modulo=pedido&accion=listar&id_cliente='.$pedido->getIdCliente());
            die();
        }else{
        //si hay algun error, informar por pantalla
        }
    }
}


?>