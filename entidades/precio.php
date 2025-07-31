<?php

class Precio{

	private $id;

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
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
        if ($array['id']) {
        	$this->setId($array['id']);
        }
        if ($array['fechaDesde']){
        	$this->setFechaDesde($array['fechaDesde']);
        }
        else{
        	$this->setFechaDesde(date('Y-m-d')); 
        }
        if ($array['valor']) {
        	$this->setValor($array['valor']);	
        }
        else{
        	$this->setValor($array['precioGavet']);
        }	
    }
}

?>