<?php
require_once('datos/Db.php');
require_once('entidades/pedido.php');

class PedidoDb extends Db{

    public function getOne($id){
        global $mysqli;
        
        $sql = "SELECT p.* 
                FROM pedido AS p
                WHERE p.id = " . $id . "
                LIMIT 1";

        $result = $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        $pedido = new Pedido($result->fetch_assoc());
        $pedido->setItemsPedido($this->getItems($id));
        $result->free();
        return $pedido;
    }

    public function getAll($id_cliente){
        
        $sql = "SELECT p.* 
                FROM pedido AS p
                WHERE p.id_cliente = ". $id_cliente ."
                AND p.eliminado = 0
                ORDER BY p.id DESC
                LIMIT 300";
        $result = $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'Pedido');
        $result->free();
        return $array;
    }

    public function getTodos($fecha1, $fecha2){
        
        $sql = "SELECT p.* 
                FROM pedido AS p
                WHERE p.fecha BETWEEN '" . date($fecha1) . "' AND '" . date($fecha2) . "'  
                AND p.eliminado = 0";
        $result = $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'Pedido');
        $result->free();
        return $array;
    }


    public function getTodosMes($mes){
        
        $sql = "SELECT p.* 
                FROM pedido AS p
                WHERE month(p.fecha) = '" . date($mes) . "'
                AND p.eliminado = 0";
        $result = $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'Pedido');
        $result->free();
        return $array;
    }

    public function getPendientes($fecha){
        
        $sql = "SELECT p.* 
                FROM pedido AS p
                WHERE p.fecha >= '" . $fecha . "' 
                AND p.eliminado = 0
                ORDER BY p.fecha ASC, p.id ASC";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'Pedido');
        $result->free();
        return $array;
    }

    public function getItems($idPedido){
        
        $sql = "SELECT i.id_producto, i.observacion, i.cantidad, i.precioSugerido
                FROM itempedido AS i
                WHERE i.id_pedido = " . $idPedido . " ";

        $result = $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        return $this->resourceToArray($result);
    }

    public function update($pedido){
        
        $sql = "UPDATE pedido SET 
                    fecha = '" . $pedido->getFecha() . "',        
                    direccion = '" . $pedido->getDireccion() . "',
                    descripcion = '" . $pedido->getDescripcion() . "',
                    envio = '" . $pedido->getEnvio() . "',
                    precio = " . $pedido->getPrecio() . ",
                    venta = " . $pedido->getVenta() . "
                    WHERE id = " . $pedido->getId() . " ";

        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));

        $this->removeItemPedido($pedido->getId(), true);

        $itemsPedido = $pedido->getItemsPedido();

        foreach ($itemsPedido as $item) {
          
        $this->insertItemPedido($item, $pedido->getId());

        }

        return $pedido;
    }

    public function insert($pedido){
        
        $sql = "INSERT INTO pedido (  id_cliente,
                                      id_encargado,
                                      fecha,
                                      direccion,
                                      envio,
                                      precio,
                                      venta,
                                      descripcion)
                VALUES ( " . $pedido->getIdCliente() . ", 
                         " . $pedido->getIdEncargado() . ", 
                        '" . $pedido->getFecha() . "',
                        '" . $pedido->getDireccion() . "',
                        '" . $pedido->getEnvio() . "',
                         " . $pedido->getPrecio() . ",
                         " . $pedido->getVenta() . ",
                        '" . $pedido->getDescripcion() . "' )";   

        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $pedido->setId( $this->mysqli->insert_id );

        $itemsPedido = $pedido->getItemsPedido();

        foreach ($itemsPedido as $item) {
          
        $this->insertItemPedido($item, $pedido->getId());

        }

        return $pedido;

      }

      public function insertItemPedido($item, $idPedido){

        $sql = "INSERT INTO itempedido (    id_producto,
                                            id_pedido,
                                            observacion,
                                            cantidad,
                                            precioSugerido)
                VALUES ( " . $item['id_producto'] . ", 
                         " . $idPedido . ", 
                        '" . $item['observacion'] . "',
                        '" . $item['cantidad'] . "',
                        '" . $item['precioSugerido'] . "' )";

        $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        return true;
    }

      public function removeItemPedido($idPedido, $fisico){

        if($fisico)
        {
        $sql = "DELETE FROM itempedido
                WHERE id_pedido = " . $idPedido . " ";
        } else{
        $sql = "UPDATE itempedido SET eliminado = 1
                WHERE id_pedido = " . $idPedido . " ";
        }

        $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        return true;

    }

    public function remove($pedido){
        $sql = "UPDATE pedido SET eliminado = 1
                WHERE id = " . $pedido->getId();
        $this->mysqli->query($sql) or die("Error ");
        $this->removeItemPedido($pedido->getId(), false);
        return true;
    }
}
?>