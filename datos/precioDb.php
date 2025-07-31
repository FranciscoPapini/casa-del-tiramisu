<?php
require_once('datos/Db.php');
require_once('entidades/precio.php');

class PrecioDb extends Db{

    public function getOne($id_producto, $fecha){
        global $mysqli;

        $sql = "SELECT p.*
                FROM precio AS p
                WHERE p.id_producto = " . $id_producto . "
                AND p.fechaDesde <= '".Util::dateToDB($fecha)."' 
                ORDER BY p.fechaDesde DESC, p.id_producto DESC, p.id DESC
                LIMIT 1";

        $result = $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        
        if($result->num_rows > 0){
            $precio = new Precio( $result->fetch_assoc() );
            $result->free();
            return $precio;
        }else{

        $sql = "SELECT p.*
                FROM precio AS p
                WHERE p.id_producto = " . $id_producto . "
                ORDER BY p.fechaDesde DESC, p.id_producto DESC, p.id DESC
                LIMIT 1";

        $result = $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        $precio = new Precio( $result->fetch_assoc() );
        $result->free();
        return $precio;

        }
    }

    public function insert($precio){
        
        $sql = "INSERT INTO precio   (fechaDesde,
                                     valor)
                VALUES ('" . $precio->getFechaDesde() . "', 
                        '" . $precio->getValor() . "')";
        
        $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        $precio->setId( $this->mysqli->insert_id );
        return $precio;
    }
}
?>