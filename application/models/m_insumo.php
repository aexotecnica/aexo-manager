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
		$this->db->select('idInsumo, '. $this->tbl_insumo.'.idParte, codigoInsumo, codigo, descripcion');
		$this->db->from($this->tbl_insumo);
		$this->db->join('parte', 'parte.idParte = '. $this->tbl_insumo.'.idParte');
		$this->db->where('nivel', 1);
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


	function get_by_idParte($idParte){
		$this->db->select('idInsumo, codigoInsumo');
		$this->db->from($this->tbl_insumo);
		$this->db->where('idParte', $idParte);
		$this->db->where('nivel', 1);
		return $this->db->get();
	}

	function insert($unInsumo, $idInsumoPadre, $jerarquia, $nivel, $codigo){
		$data = array(
		   'idParte' => $unInsumo->parte->idParte ,
		   'jerarquia' => $jerarquia,
		   'idInsumoParent' => $idInsumoPadre,
		   'nivel' => $nivel, 
		   'cantidad' => $unInsumo->cantidad,
		   'codigoInsumo' => $codigo
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

	function eliminarInsumo($codigo){
		$this->db->delete($this->tbl_insumo,  array('codigoInsumo' => $codigo));	
	}

	function obtenerInsumos($idParte=null, $idInsumo = null){
		$sql = "CALL sp_InsumoHijosConsultar(?,?)";
		$params = array($idParte, $idInsumo);
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

	function guardarHijo($unHijo,$idPartePadre){
		$sql = "CALL sp_InsumoHijosAgregar(?,?,?);";
		$params = array($unHijo->idParte, $idPartePadre, $unHijo->cantidad);
		$query = $this->db->query($sql, $params);

		$res = $query->result();

		$query->next_result();
		$query->free_result();
		echo $this->db->last_query();
		return $res[0]->ultimoInsumo;
	}

	function guardar($unInsumo, $idInsumoPadre, $jerarquia){
		$sql = "CALL sp_InsumoAgregar(?,?,?,?)";
		$params = array($unInsumo->parte->idParte, $jerarquia, $idInsumoPadre, $nivel, $unInsumo->cantidad);
		$query = $this->db->query($sql, $params);

		$query->next_result();
		$query->free_result();
		return $this->db->insert_id();
	}

	function eliminarParteInsumo($idInsumo){
		$sql = "CALL sp_InsumoHijosEliminar(?);";
		$params = array($idInsumo);
		$query = $this->db->query($sql, $params);

		$res = $query->result();

		$query->next_result();
		$query->free_result();
	}

	function obtenerArbol($idParte=null, $idInsumo = null){
		$res = $this->obtenerInsumos($idParte, $idInsumo);
		$arbol = $this->construirArbol($res, true);
		return $arbol;
	}

	public function construirArbol($resultado,$esArbolCompleto){
		$root = new M_InsumoEntidad();
		$idPadre = null;
		$idPadreAnterior = null;

		$ultimoElemento = $resultado[count($resultado)-1];
		$listRoot = explode("/", $ultimoElemento->jerarquia);


		$countParseRoot = count($listRoot);
		unset($listRoot[count($listRoot)-2]);

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
			$keyArbol = (new M_InsumoEntidad)->ArmarPadre($arrPadre);

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

				$unInsumo = new M_InsumoEntidad();
				$unInsumo->idInsumo = $item->idInsumo;
				$unInsumo->parte = $parte;
				$unInsumo->cantidad = $item->cantidad;
				$unInsumo->nivel = $item->nivel;

				if ($idPadreAnterior != $idPadre){
					if (count($arrPadre) == $countParseRoot)
					{
						$unInsumo->child = $hijos;
						$hijos = [];
						array_push($root->child,$unInsumo);
					}else{
						$rar = $this->getValorDiccionario($diccionario, $jerarquiaActual);
						if (isset($diccionario[$jerarquiaActual])){
							$unInsumo->child = $this->getValorDiccionario($diccionario, $jerarquiaActual);
							$rar2 = $this->getValorDiccionario($diccionario,$keyArbol);
							if (count($rar2) != 0){
								$hijos = $this->getValorDiccionario($diccionario,$keyArbol);
								array_push($hijos,$unInsumo);
								$diccionario[$keyArbol] = $hijos;
							}else{
								$hijos = [];
								array_push($hijos,$unInsumo);
								$diccionario[$keyArbol] =  $hijos;
							}
						}else{
							$hijos = [];
							array_push($hijos,$unInsumo);
							$diccionario[$keyArbol] =  $hijos;
						}
					}
				}else {
					if (count($arrPadre) == $countParseRoot)
					{
						$unInsumo->child = $hijos;
						$hijos = [];
						array_push($root->child,$unInsumo);
					}
					else
					{
						if ($diccionario != NULL){
							$rar = $this->getValorDiccionario($diccionario,$keyArbol);
							if (count($rar) != 0)
							{
								$hijos = $diccionario[$keyArbol];

								array_push($hijos, $unInsumo);

								$diccionario[$keyArbol] =  $hijos;

							}
							else
							{
								array_push($hijos,$unInsumo);
								$diccionario[$keyArbol] = $hijos;
							}	
						}   else
						{
							array_push($hijos,$unInsumo);
							$diccionario[$keyArbol] = $hijos;
						}	
						
					}
				}
			} else{
				$parte  = (new M_Parte)->get_by_id($item->idParte);
				$parte = $parte[0];

				$root->parte = $parte;
				$root->idInsumo = $item->idInsumo;
				$root->cantidad = $item->cantidad;
				$root->nivel = $item->nivel;
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