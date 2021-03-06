<?php
class M_Despiece extends CI_Model {
	// table name
	private $tbl_despiece= 'despiece';

	function __construct()
	{
        // Call the Model constructor
		parent::__construct();
	}

	// get number of proyectos in database
	function count_all(){
		return $this->db->count_all($this->tbl_despiece);
	}
	// get proyectos with paging
	function get_paged_list($limit = 10, $offset = 0){
		$this->db->select('idDespiece, codigo, descripcion');
		$this->db->from($this->tbl_despiece);
		$this->db->join('parte', 'parte.idParte = '. $this->tbl_despiece.'.idParte');
		$this->db->where('nivel', 0);
		$this->db->order_by('idDespiece','asc');
		return $this->db->get();
	}
	// get person by id
	function get_by_id($id){
		$this->db->select('idDespiece, codigo, descripcion');
		$this->db->from($this->tbl_despiece);
		$this->db->join('parte', 'parte.idParte = '. $this->tbl_despiece.'.idParte');
		$this->db->where('idDespiece', $id);
		return $this->db->get();
	}

	// get person by idParte
	function get_by_idParte($idParte){
		$this->db->select('idDespiece, idProducto, idParte, idParent, jerarquia, nivel, cantidad');
		$this->db->from($this->tbl_despiece);
		$this->db->where('idParte', $idParte);
		return $this->db->get();
	}

	// falta joinear conntra la tabla producto para que me traiga el costo del producto. 
	function get_by_idProducto($idProducto, $cantidad){
		$this->db->select('productoprecio.idProducto,costo, precio, idParte, cantidad * ' . $cantidad . ' cantidad');
		$this->db->from($this->tbl_despiece);
		$this->db->join('productoprecio', $this->tbl_despiece  .'.idProducto = productoprecio.idProducto','left');
	    $this->db->where("((fechaInicio < curdate() and fechaFin > curdate()) or (fechaFin is null))");
		$this->db->where($this->tbl_despiece . '.idProducto', $idProducto);
		$this->db->where('nivel', 1);
		return $this->db->get();
	}

	function getDespiece_by_idProducto($idProducto, $cantidad, $nivel){
		$this->db->select('idDespiece, idProducto, ' . $this->tbl_despiece. '.idParte,' . $this->tbl_despiece. '.cantidad * ' . $cantidad . ' cantidad, descripcion, idInsumo');
		$this->db->from($this->tbl_despiece);
		$this->db->join('parte', $this->tbl_despiece  .'.idParte = parte.idParte');
		$this->db->join('insumo', 'insumo.idParte = parte.idParte and insumo.idInsumoParent is null', 'left');
		$this->db->where($this->tbl_despiece . '.idProducto', $idProducto);
		$this->db->where( $this->tbl_despiece.'.nivel', $nivel);
		
		// $this->db->get();
		// echo $this->db->last_query();
		// die();

		return $this->db->get();
	}

// SELECT `idDespiece`, `idProducto`, `despiece`.`idParte`, despiece.`cantidad` * 2 cantidad, `descripcion`, idInsumo
// FROM (`despiece`) 
// JOIN `parte` ON `despiece`.`idParte` = `parte`.`idParte`
// LEFT JOIN insumo ON insumo.`idParte` = parte.`idParte` AND insumo.`idInsumoParent` IS NULL
// WHERE `despiece`.`idProducto` = '21' AND despiece.`nivel` = 2

	function insert($data){
		$this->db->insert($this->tbl_despiece, $data);
		return $this->db->insert_id();
	}

	function update($idDespiece, $data){
        $this->db->where('idDespiece', $idDespiece);
        $this->db->update($this->tbl_despiece, $data);
	}

	function delete($idDespiece){
        $this->db->delete($this->tbl_despiece,  array('idDespiece' => $idDespiece));
	}

	function eliminarParteDespiece($idDespiece){
		$sql = "CALL sp_DespieceHijosEliminar(?);";
		$params = array($idDespiece);
		$query = $this->db->query($sql, $params);

		$res = $query->result();

		$query->next_result();
		$query->free_result();
	}

	function obtenerDespiece($idProducto, $idParte=null){
		echo $idProducto;
		if ($idParte == null){
			$sql = "CALL sp_DespieceHijosConsultar(?)";
			$params = array($idProducto);
		}else {
			$sql = "CALL sp_DespieceHijosPartesObtener(?,?)";
			$params = array($idProducto,$idParte);
		}
		$query = $this->db->query($sql, $params);
		$res = $query->result();

		$query->next_result();
		$query->free_result();
		return $res;
	}

	function obtenerDespieceXidDespiece($idDespiece){
		$sql = "CALL sp_DespieceHijosXidDespiece(?)";
		$params = array($idDespiece);
		$query = $this->db->query($sql, $params);
		$res = $query->result();

		$query->next_result();
		$query->free_result();
		return $res;
	}

	function obtenerHijosCompletos($idDespiece){
		$sql = "CALL sp_DespieceObtenerHijosCompletos(?)";
		$params = array($idDespiece);
		$query = $this->db->query($sql, $params);
		$res = $query->result();

		$query->next_result();
		$query->free_result();
		return $res;
	}

	function guardarHijo($unHijo,$idPartePadre){
		$sql = "CALL sp_DespieceHijosAgregar(?,?,?,?);";
		$params = array($unHijo->idProducto, $unHijo->idParte, $idPartePadre, floatval($unHijo->cantidad));
		$query = $this->db->query($sql, $params);
		$res = $query->result();

		$query->next_result();
		$query->free_result();
		return $res[0]->ultimoDespiece;
	}

	// function obtenerHijos($idProducto, $idParte){
	// 	$sql = "CALL sp_DespieceObtenerHijos(?,?)";
	// 	$params = array($idProducto, $idParte);
	// 	$query = $this->db->query($sql, $params);
	// 	$res =$query->result();

	// 	$query->next_result();
	// 	$query->free_result();
	// 	return $res;
	// }


	public function guardarHijoDeInsumo($arbolInsumo, $idProducto, $idDespiecePadre){
		//var_dump($arbolInsumo);
		$nuevoHijo = new M_DespieceEntidad();
		$nuevoHijo->idProducto = $idProducto;
		$nuevoHijo->idParte = $arbolInsumo->parte->idParte;
		$nuevoHijo->cantidad = $arbolInsumo->cantidad;

		$idDespiecePadre = $this->guardarHijo($nuevoHijo, $idDespiecePadre);
		if (!empty($arbolInsumo->child)){
			foreach ($arbolInsumo->child as $key => $value) {
				$this->guardarHijoDeInsumo($value, $idProducto, $idDespiecePadre);
			}
		}
	}

	function obtenerHijos($idDespiece){
		$sql = "CALL sp_DespieceObtenerHijos(?)";
		$params = array($idDespiece);
		$query = $this->db->query($sql, $params);
		$res =$query->result();

		$query->next_result();
		$query->free_result();
		return $res;
	}

	public function obtenerArbol($idProducto, $idParte=null){
		if ($idParte == null){
			$resultado =  $this->obtenerDespiece($idProducto);
		}else {

			$resultado =  $this->obtenerDespiece($idProducto,$idParte);
		}

		if ($idParte != null)
			$esArbolCompleto = false;
		else
			$esArbolCompleto = true;
		return $this->construirArbol($resultado,$esArbolCompleto);
	}

	public function obtenerArbolXidDespiece($idDespiece){
		
		$resultado =  $this->obtenerDespieceXidDespiece($idDespiece);
		return $this->construirArbol($resultado,false);
	}


	public function construirArbol($resultado,$esArbolCompleto){
		//$idParte = null;
		$root = new M_DespieceEntidad();
		$idPadre = null;
		$idPadreAnterior = null;
		//$this = new M_Despiece();

		//$resultado =  $this->obtenerDespiece($idProducto);
		/*if ($idParte == null){
			$resultado =  $this->obtenerDespiece($idProducto);
		}else {

			$resultado =  $this->obtenerDespiece($idProducto,$idParte);
		}*/

		$ultimoElemento = $resultado[count($resultado)-1];
		$listRoot = explode("/", $ultimoElemento->jerarquia);


		$countParseRoot = count($listRoot);
		unset($listRoot[count($listRoot)-2]);


		//array_splice( $listRoot, 1, 0, array('/'));

		$jerarquiaRoot = implode("/", $listRoot);
		if ($esArbolCompleto == false)
			array_splice( $listRoot, 1, 0, array('/'));
		
		$nivelAnterior = 99;
		$hijos = [];
		$diccionario = [];

		$padreAnterior = "";
		$arrPadreAnterior = [];

		
		foreach ($resultado as $key => $item) {
			$arrPadre = explode("/", $item->jerarquia);
			unset($arrPadre[count($arrPadre)-2]);
			$keyArbol = (new M_DespieceEntidad)->ArmarPadre($arrPadre);

			$jerarquiaActual = str_replace("/", "", $item->jerarquia);
			/**/
			$padre = "";
			$listTemp = explode("/", $item->jerarquia);
			unset($listTemp[count($listTemp)-2]);
			$padre = implode("/",$listTemp);
			//echo $padre . "----" . $jerarquiaRoot . "<br>";
			if ($padre != $jerarquiaRoot){
				$parte  = (new M_Parte)->get_by_id($item->idParte);
				$parte = $parte[0];

				$idPadre = $item->idPartePadre;

				$unDespiece = new M_DespieceEntidad();
				$unDespiece->idDespiece = $item->idDespiece;
				$unDespiece->parte = $parte;
				$unDespiece->idProducto = $item->idProducto;
				$unDespiece->cantidad = $item->cantidad;
				$unDespiece->nivel= $item->nivel;
				$unDespiece->esInsumo = ($item->esInsumo == 1) ? true : false;

				if ($idPadreAnterior != $idPadre){
					if (count($arrPadre) == $countParseRoot)
					{
						$unDespiece->child = $hijos;
						$hijos = [];
						array_push($root->child,$unDespiece);
					}else{
						$rar = $this->getValorDiccionario($diccionario, $jerarquiaActual);
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
					if (count($arrPadre) == $countParseRoot)
					{
						$unDespiece->child = $hijos;
						$hijos = [];
						array_push($root->child,$unDespiece);
					}
					else
					{
						if ($diccionario != NULL){
							$rar = $this->getValorDiccionario($diccionario,$keyArbol);
							if (count($rar) != 0)
							{
								$hijos = $diccionario[$keyArbol];

								array_push($hijos, $unDespiece);

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
				$parte  = (new M_Parte)->get_by_id($item->idParte);
				$parte = $parte[0];

				$root->parte = $parte;
				$root->idDespiece = $item->idDespiece;
				$root->idProducto = $item->idProducto;
				$root->cantidad = $item->cantidad;
				$root->nivel= $item->nivel;
				$root->esInsumo = ($item->esInsumo == 1) ? true : false;
			}
			$arrPadreAnterior = $arrPadre;
			$idPadreAnterior  = $idPadre;
			
		}
		return $root;
	}

	function getValorDiccionario($diccionario, $key){
		if (isset($diccionario[$key])){
			return $diccionario[$key];
		}else{
			return [];
		}
	}
}