<?php
class M_Insumo extends CI_Model {
	// table name
	private $tbl_insumo= 'insumo';

	function __construct()
	{
        // Call the Model constructor
		parent::__construct();
	}

	// get number of proyectos in database
	function count_all(){
		return $this->db->count_all($this->tbl_insumo);
	}
	// get proyectos with paging
	function get_paged_list($limit = 10, $offset = 0){
		$this->db->select('idInsumo, codigo, descripcion');
		$this->db->from($this->tbl_insumo);
		$this->db->join('parte', 'parte.idParte = '. $this->tbl_insumo.'.idParte');
		$this->db->where('nivel', 0);
		$this->db->order_by('idInsumo','asc');
		return $this->db->get();
	}
	// get person by id
	function get_by_id($id){
		$this->db->select('idInsumo, codigo, descripcion');
		$this->db->from($this->tbl_insumo);
		$this->db->join('parte', 'parte.idParte = '. $this->tbl_insumo.'.idParte');
		$this->db->where('idInsumo', $id);
		return $this->db->get();
	}


	function insert($unDespiece, $idInsumoPadre, $jerarquia, $nivel){
		$data = array(
		   'idParte' => $unDespiece->parte->idParte ,
		   'jerarquia' => $jerarquia,
		   'idInsumoParent' => $idInsumoPadre,
		   'nivel' => $nivel, 
		   'cantidad' => $unDespiece->cantidad
		);
		$this->db->insert($this->tbl_insumo, $data);
		$idInsumoNuevo = $this->db->insert_id();

		$data = array(
		   'jerarquia' => $jerarquia . $idInsumoNuevo . "/"
		);
		$this->db->where('idInsumo', $idInsumoNuevo );
        $this->db->update($this->tbl_insumo, $data);
		
		return $idInsumoNuevo ;
	}

	function update($idInsumo, $data){
        $this->db->where('idInsumo', $idInsumo);
        $this->db->update($this->tbl_insumo, $data);
	}

	function delete($idInsumo){
        $this->db->delete($this->tbl_insumo,  array('idInsumo' => $idInsumo));
	}

	function obtenerInsumos($idParte=null){
		if ($idParte != null){
			$sql = "CALL sp_InsumoHijosConsultar(?)";
			$params = array($idParte);
		}
		$query = $this->db->query($sql, $params);
		$res =$query->result();

		$query->next_result();
		$query->free_result();
		return $res;
	}


	function obtenerHijos($idInsumo){
		$sql = "CALL sp_InsumoObtenerHijos(?)";
		$params = array($idInsumo);
		$query = $this->db->query($sql, $params);
		$res =$query->result();

		$query->next_result();
		$query->free_result();
		return $res;
	}

	function guardar($unDespiece, $idInsumoPadre, $jerarquia){
		$sql = "CALL sp_InsumoAgregar(?,?,?,?)";
		$params = array($unDespiece->parte->idParte, $jerarquia, $idInsumoPadre, $nivel, $unDespiece->cantidad);
		$query = $this->db->query($sql, $params);

		$query->next_result();
		$query->free_result();
		return $this->db->insert_id();
	}

	public function construirArbol($idParte){
		$root = new M_DespieceEntidad();
		$idPadre = null;
		$idPadreAnterior = null;
		$resultado =  $this->obtenerInsumos($idParte);

		$ultimoElemento = $resultado[count($resultado)-1];
		$listRoot = explode("/", $ultimoElemento->jerarquia);

		$countParseRoot = count($listRoot);
		unset($listRoot[count($listRoot)-2]);

		array_splice( $listRoot, 1, 0, array('/'));
		$jerarquiaRoot = implode("", $listRoot);
		
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

			if ($padre != $jerarquiaRoot){
				$parte  = (new M_Parte)->get_by_id($item->idParte)->result();
				$parte = $parte[0];

				$idPadre = $item->idPartePadre;

				$unDespiece = new M_DespieceEntidad();
				$unDespiece->idInsumo = $item->idInsumo;
				$unDespiece->parte = $parte;
				$unDespiece->cantidad = $item->cantidad;
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
				$parte  = (new M_Parte)->get_by_id($item->idParte)->result();
				$parte = $parte[0];

				$root->parte = $parte;
				$root->idInsumo = $item->idInsumo;
				$root->cantidad = $item->cantidad;
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