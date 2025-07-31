<?php
require_once('datos/Db.php');
require_once('entidades/producto.php');

class ProductoDb extends Db{

    public function getOne($id){
        global $mysqli;
        
        $sql = "SELECT p.* 
                FROM producto AS p
                WHERE id = " . $id . "
                LIMIT 1";

        $result = $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        $producto = new Producto( $result->fetch_assoc() );
        $result->free();
        return $producto;
    }

    public function getAll(){
        
        $sql = "SELECT p.* 
                FROM producto AS p
                WHERE p.eliminado = 0 
                ORDER BY p.nombre ASC";

        $result = $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'Producto');
        $result->free();
        return $array;
    }

    public function update($producto){
        
        $sql = "UPDATE producto SET nombre = '" . $producto->getNombre() . "', 
                                    descripcion = '" . $producto->getDescripcion() . "'
                WHERE id = " . $producto->getId();

        $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));

        $this->updatePrecio($producto->getId(), $producto->getFechaDesde(), $producto->getValor());

        return $producto;
    }

    public function updatePrecio($id, $fechaDesde, $valor){

        $sql = "INSERT INTO precio  (id_producto,
                                    fechaDesde,
                                    valor)
                VALUES ( " . $id . ",
                        '" . $fechaDesde . "', 
                         " . $valor . " )";

        $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        return $true;
}

    public function insert($producto){
        
        $sql = "INSERT INTO producto (nombre,
                                      descripcion)
                VALUES ('" . $producto->getNombre() . "', 
                        '" . $producto->getDescripcion() . "' )";

        $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        $producto->setId( $this->mysqli->insert_id );

        $this->updatePrecio($producto->getId(), $producto->getFechaDesde(), $producto->getValor());

        return $producto;
    }

    public function remove($producto){
        $sql = "UPDATE producto SET eliminado = 1
                WHERE id = " . $producto->getId();
        $this->mysqli->query($sql) or die("Error ");
        return true;
    }
}
?>