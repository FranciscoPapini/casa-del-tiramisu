<?php
require_once('datos/Db.php');
require_once('entidades/envio.php');

class EnvioDb extends Db{

    

    public function getOne($fecha){
        
        $sql = "SELECT e.*
                FROM envio AS e
                WHERE e.fecha_desde <= '".Util::dateToDB($fecha)."' 
                ORDER BY e.fecha_desde DESC, e.id DESC
                LIMIT 1";

        $result = $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        $envio = new Envio( $result->fetch_assoc() );
        $result->free();
        return $envio;
    }

    public function insert($envio){
        
        $sql = "INSERT INTO envio   (fecha_desde,
                                     precio)
                VALUES ('" . $envio->getFechaDesde() . "', 
                        '" . $envio->getPrecio() . "')";
        
        $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        $envio->setId( $this->mysqli->insert_id );
        return $envio;
    }
}
?>