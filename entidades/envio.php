<?php

class Envio{

	private $id;

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	private $fecha_desde;

	public function getFechaDesde(){
		return $this->fecha_desde;
	}

	public function setFechaDesde($fecha_desde){
		$this->fecha_desde = $fecha_desde;
	}

	
	private $precio;

	public function getPrecio(){
		return $this->precio;
	}

	public function setPrecio($precio){
		$this->precio = $precio;
	}

    public function __construct($array = null){
        if ($array['id']) {
        	$this->setId($array['id']);
        }
        if ($array['fecha_desde']){
        	$this->setFechaDesde($array['fecha_desde']);
        }
        else{
        	$this->setFechaDesde(date('Y-m-d')); 
        }   
        	$this->setPrecio($array['precio']);	
    }
}

?>