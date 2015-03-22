<?php 
class M_DespieceEntidad  extends CI_Model {
	public $idProducto;
	public $idParte;
	public $nivel;
	public $cantidad;
	public $esInsumo;
	public $parte;
	public $child = [];

	public function ArmarPadre($padres)
	{
		$idpadre = "";

		foreach ($padres as $key => $item) 
		{
			$idpadre .= $item;

		}
		return $idpadre;
		
	}
}