<?php

class Producto{

	private $id;

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}


	private $nombre;

	public function getNombre(){
		return $this->nombre;
	}

	public function setNombre($nombre){
		$this->nombre = $nombre;
	}


	private $descripcion;

	public function getDescripcion(){
		return $this->descripcion;
	}

	public function setDescripcion($descripcion){
		$this->descripcion = $descripcion;
	}

	private $fechaDesde;

	public function getFechaDesde(){
		return $this->fechaDesde;
	}

	public function setFechaDesde($fechaDesde){
		$this->fechaDesde = $fechaDesde;
	}

	private $valor;

	public function getValor(){
		return $this->valor;
	}

	public function setValor($valor){
		$this->valor = $valor;
	}



	public function __construct($array = null){
        if($array){
        	if($array['id']){
        		$this->setId($array['id']);
        	}
        $this->setNombre($array['nombre']);
        $this->setDescripcion($array['descripcion']);
        if ($array['fechaDesde']){
        	$this->setFechaDesde($array['fechaDesde']);
        }
        else{
        	$this->setFechaDesde(date('Y-m-d')); 
        }
        if ($array['precioGavet']) {
        	$this->setValor($array['precioGavet']);	
        }
        else{
        	$this->setValor($array['precioActual']);
        }	
        
        }
    }

}

?>