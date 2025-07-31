<?php

class Encargado{

	private $id;

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	
	private $apellido;

	public function getApellido(){
		return $this->apellido;
	}

	public function setApellido($apellido){
		$this->apellido = $apellido;
	}


	private $nombre;

	public function getNombre(){
		return $this->nombre;
	}

	public function setNombre($nombre){
		$this->nombre = $nombre;
	}


	private $usuario;

	public function getUsuario(){
		return $this->usuario;
	}

	public function setUsuario($usuario){
		$this->usuario = $usuario;
	}


	private $password;

	public function getPassword(){
		return $this->password;
	}

	public function setPassword($password){
		$this->password = $password;
	}


	private $email;

	public function getEmail(){
		return $this->email;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function __construct($array = null){
        if($array){
        	if($array['id']){
        		$this->setId($array['id']);
        	}
        $this->setNombre($array['nombre']);
        $this->setApellido($array['apellido']);
        $this->setUsuario($array['usuario']);
        $this->setPassword($array['password']);
        $this->setEmail($array['email']);
        }
    }

}

?>