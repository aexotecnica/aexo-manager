<?php 
class M_InsumoEntidad  extends CI_Model {
	public $idInsumo;
	public $idParte;
	public $nivel;
	public $cantidad;
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