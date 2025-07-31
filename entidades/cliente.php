<?php

class Cliente{

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


	private $direccion;

	public function getDireccion(){
		return $this->direccion;
	}

	public function setDireccion($direccion){
		$this->direccion = $direccion;
	}


	private $telefono;

	public function getTelefono(){
		return $this->telefono;
	}

	public function setTelefono($telefono){
		$this->telefono = $telefono;
	}


    public function __construct($array = null){
        if($array){
        	if($array['id']){
        		$this->setId($array['id']);
        	}

        $this->setNombre($array['nombre']);
        $this->setDireccion($array['direccion']);
        $this->setTelefono($array['telefono']);
    	}	
    }

}

?>
