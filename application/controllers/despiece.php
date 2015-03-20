<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Despiece extends MY_Controller {
	private $permiso_autorizaPago;
	function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
		$this->load->model('M_Parte','',TRUE);
		$this->load->model('M_Despiece','',TRUE);
		$this->load->model('M_DespieceEntidad','',TRUE);

		$permisos = $this->session->userdata('permisos');
		$this->permiso_autorizaPago = array_filter($permisos,
			function ($e) {
				return $e->label == '[DESPIECE]';
			});

	}

	public function ver(){
		$arbolDespiece = $this->construirArbol(1);
		//var_dump($arbolDespiece);
		$data['actionDelForm'] = 'partes/traerPartes';
		$data['arbolDespiece'] = $arbolDespiece;
		//print_r($arbolDespiece);
		echo $this->buildItem($arbolDespiece);
		
		// $out = $this->load->view('view_despieceArbol.php', $data, TRUE);
		// $data['cuerpo'] = $out;

		// parent::cargarTemplate($data);
	}

	public function buildItem($arbolDespiece){
		$insumo = ($arbolDespiece->esInsumo == 1) ? "{<span style='float:right' class='label label-primary'>Insumo</span>}" : "";

		$retorno = "<li class='dd-item' data-id='" . $arbolDespiece->idParte . "' id='" . $arbolDespiece->idParte . "'>"
		. "<div class='dd3-content'>"
		. "<a href='javascript:detalleDespiece(" . $arbolDespiece->idParte . "," . $arbolDespiece->idProducto . ");'>" . $arbolDespiece->parte->descripcion . " / Cantidad: " . $arbolDespiece->cantidad . "  " . $insumo . "</a>"
		. "</div>";
		
		if (!empty($arbolDespiece->child)){
			$retorno .= "<ol class='dd-list'>";
			foreach ($arbolDespiece->child as $key => $value) {
				$retorno .= $this->buildItem($value);
			}
			$retorno .= "</ol>";
		}
		$retorno .= "</li>";

		return $retorno;

	}

	public function construirArbol($idProducto){
		$idParte = null;
		$root = new M_DespieceEntidad();
		$idPadre = null;
		$idPadreAnterior = null;

		//var_dump($this->M_Parte->get_by_id(1624)->result());
		$resultado =  $this->M_Despiece->obtenerDespiece($idProducto);
			//var_dump($this->M_Parte->get_by_id(1624)->result());
		

		// echo "resultado<br>";
		// var_dump($resultado);
		$ultimoElemento = $resultado[count($resultado)-1];
		$listRoot = explode("/", $ultimoElemento->jerarquia);

		// echo "<br>listRoot<br>";
		// var_dump($listRoot);

		$countParseRoot = count($listRoot);
		//$listRoot.RemoveAt(listRoot.Count - 2);
		unset($listRoot[count($listRoot)-2]);
		// echo "<br>listRoot<br>";
		// var_dump($listRoot);
		

		array_splice( $listRoot, 1, 0, array('/'));
		$jerarquiaRoot = implode("", $listRoot);
		
		//$root->Child = new array('' => , );;
		$nivelAnterior = 99;
		$hijos = [];
		$diccionario = [];
		//     Dictionary<string, List<Despiece>> diccionario = new Dictionary<string, List<Despiece>>();

		$padreAnterior = "";
		//var_dump($this->M_Parte->get_by_id(1624)->result());
		$arrPadreAnterior = [];

		
		foreach ($resultado as $key => $item) {
			$arrPadre = explode("/", $item->jerarquia);
			unset($arrPadre[count($arrPadre)-2]);
			$keyArbol = M_DespieceEntidad::ArmarPadre($arrPadre);

			$jerarquiaActual = str_replace("/", "", $item->jerarquia);
			/**/
			$padre = "";
			$listTemp = explode("/", $item->jerarquia);
			unset($listTemp[count($listTemp)-2]);
			$padre = implode("/",$listTemp);
			// echo "<br>padre<br>";
			// echo ($padre);
			/**/
			echo "padre" . "   " . $padre . "----" . "item:" . $item->jerarquia;

			if ($padre != $jerarquiaRoot){
				$parte  = $this->M_Parte->get_by_id($item->idParte)->result();
				$parte = $parte[0];

				$idPadre = $item->idPartePadre;

				$unDespiece = new M_DespieceEntidad();
				$unDespiece->parte = $parte;
				$unDespiece->cantidad = $item->cantidad;
				$unDespiece->esInsumo = ($item->esInsumo == 1) ? true : false;

				echo $parte->descripcion . "<br><br><br>";

				//if (!$arrPadre.SequenceEqual(arrPadreAnterior))
				//echo "<br> arrPadre " . $key . " <br>";
				//var_dump($arrPadre);

				//if (!$this->contieneSecuencia($arrPadreAnterior, $arrPadre)){
				if ($idPadreAnterior != $idPadre){
					if (count($arrPadre) == $countParseRoot)
					{
						$unDespiece->child = $hijos;
						$hijos = [];
						array_push($root->child,$unDespiece);
					}else{
						//$rar = $diccionario[$jerarquiaActual];
						$rar = $this->getValorDiccionario($diccionario, $jerarquiaActual);
						echo "jerarquiaActual: " . $jerarquiaActual . "----------";
						if (isset($diccionario[$jerarquiaActual])){
							$unDespiece->child = $this->getValorDiccionario($diccionario, $jerarquiaActual);
							$rar2 = $this->getValorDiccionario($diccionario,$keyArbol);
							if (count($rar2) != 0){
								$hijos = $this->getValorDiccionario($diccionario,$keyArbol);
								array_push($hijos,$unDespiece);
								$diccionario[$keyArbol] = $hijos;
							}else{
								$hijos = [];
								array_push($hijos,$unDespiece);
								$diccionario[$keyArbol] =  $hijos;
							}
						}else{
							$hijos = [];
							array_push($hijos,$unDespiece);
							$diccionario[$keyArbol] =  $hijos;
						}
					}
				}else {
					echo "paso por el else";
					if (count($arrPadre) == $countParseRoot)
					{
						$unDespiece->child = $hijos;
						$hijos = [];
						array_push($root->child,$unDespiece);
					}
					else
					{
						if ($diccionario != NULL){
							$rar = $diccionario[$keyArbol];
							echo "keyArbol" . $keyArbol . "------";
							if (count($rar) != 0)
							{
								$hijos = $diccionario[$keyArbol];

								array_push($hijos, $unDespiece);

								//array_push($diccionario[$keyArbol], $hijos);
								$diccionario[$keyArbol] =  $hijos;

							}
							else
							{
								array_push($hijos,$unDespiece);
								$diccionario[$keyArbol] = $hijos;
							}	
						}   else
						{
							array_push($hijos,$unDespiece);
							$diccionario[$keyArbol] = $hijos;
						}	
						
					}
				}
			} else{
				$parte  = $this->M_Parte->get_by_id($item->idParte)->result();
				$parte = $parte[0];

					//$root = new M_DespieceEntidad();
				$root->parte = $parte;
				$root->cantidad = $item->cantidad;
				$root->esInsumo = ($item->esInsumo == 1) ? true : false;
			}
			$arrPadreAnterior = $arrPadre;
			$idPadreAnterior  = $idPadre;
			
			//return $root;
		}
		print_r($root);
		return $root;
		
	}

	function contieneSecuencia($sequencia, $origen){
		$haystack = join('', $origen);
		echo $haystack . "------";
		var_dump( $sequencia);
		echo "<br><br><br>";
		if ($sequencia == null){
			return false;
		}else {
			preg_match_all('/' . implode('',$sequencia) . '/', $haystack , $matches, PREG_OFFSET_CAPTURE);
			return isset($matches[0][0]);	
		}
		
	}

	function getValorDiccionario($diccionario, $key){
		if (isset($diccionario[$key])){
			return $diccionario[$key];
		}else{
			return [];
		}
	}


}