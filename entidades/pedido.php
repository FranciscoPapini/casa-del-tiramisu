<?php

class Pedido{

	private $id;

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;

	}

	private $id_cliente;

	public function getIdCliente(){
		return $this->id_cliente;
	}

	public function setIdCliente($id_cliente){
		$this->id_cliente = $id_cliente;
	}

	private $id_encargado;

	public function getIdEncargado(){
		return $this->id_encargado;
	}

	public function setIdEncargado($id_encargado){
		$this->id_encargado = $id_encargado;

	}

	private $fecha;

	public function getFecha(){
		return $this->fecha;
	}

	public function setFecha($fecha){
		$this->fecha = $fecha;
	}

	private $descripcion;

	public function getDescripcion(){
		return $this->descripcion;
	}

	public function setDescripcion($descripcion){
		$this->descripcion = $descripcion;
	}


	private $direccion;

	public function getDireccion(){
		return $this->direccion;
	}

	public function setDireccion($direccion){
		$this->direccion = $direccion;
	}

	private $envio;

	public function getEnvio(){
		return $this->envio;
	}

	public function setEnvio($envio){
		$this->envio = $envio;

	}

	private $precio;

	public function getPrecio(){
		return $this->precio;
	}

	public function setPrecio($precio){
		$this->precio = $precio;

	}


	private $venta;

	public function getVenta(){
		return $this->venta;
	}

	public function setVenta($venta){
		$this->venta = $venta;

	}


	private $itemsPedido;

	public function getItemsPedido(){
		return $this->itemsPedido;
	}

	public function setItemsPedido($itemsPedido){
		$this->itemsPedido = $itemsPedido;

	}

	public function __construct($array = null){
		if($array){
			if($array['id']){
				$this->setId($array['id']);
			}

			$this->setIdCliente($array['id_cliente']);
			$this->setIdEncargado($_SESSION['encargado']['id']);
			$this->setFecha($array['fecha']);
			$this->setEnvio(($array['envio'] == ('on' || 1))? 1 : 0);
			
			$this->setVenta(($array['venta'] == ('on' || 1))? 1 : 0);

			$aux3 = ($array['direccion'])? $array['direccion'] : 0;
			$this->setDireccion($aux3);

			$aux2 = ($array['descripcion'])? $array['descripcion'] : 0;
			$this->setDescripcion($aux2);

			$this->setPrecio($array['precio']);

			$aux = array();
			for ($i=0; $i<count($array['productos']); $i++){ 
				$aux[$i]['id_producto'] = $array['productos'][$i];
				$aux[$i]['observacion'] = $array['observaciones'][$i];
				$aux[$i]['cantidad'] = $array['cantidades'][$i];
				$aux[$i]['precioSugerido'] = $array['preciosSugeridos'][$i];
				$precio += $array['preciosSugeridos'][$i];
			}
			$this->setItemsPedido($aux);
		}
	}

}

?>