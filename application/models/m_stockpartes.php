<?php
class M_StockPartes extends CI_Model {
	// table name
	private $tbl_stock= 'stockpartes';
	

	function __construct()
	{
        // Call the Model constructor
		parent::__construct();
	}

	// get number of proyectos in database
	function count_all(){
		return $this->db->count_all($this->tbl_stock);
	}
	// get proyectos with paging
	function get_paged_list($limit = 10, $offset = 0){
		$this->db->select('idStockPartes, '. $this->tbl_stock.'.idParte, parte.descripcion descripcion, parte_estadoparte.descripcion estadoParte_descripcion, cantidad,fechaIngreso, idAlmacen');
		$this->db->join('parte', 'parte.idParte = '. $this->tbl_stock.'.idParte');
		$this->db->join('parte_estadoparte', 'parte_estadoparte.idEstadoParte = '. $this->tbl_stock.'.idEstadoParte');
		$this->db->order_by('idParte','asc');
		$this->db->order_by($this->tbl_stock.'.idEstadoParte','asc');
		return $this->db->get($this->tbl_stock, NULL, $offset);
	}

	function get_by_id($id){
		$this->db->select('idStockPartes, idParte, cantidad,fechaIngreso, idAlmacen,idEstadoParte');
		$this->db->where("idStockPartes",$id);
		$this->db->order_by('idParte','asc');
		return $this->db->get($this->tbl_stock);
	}

	function get_by_parte($idParte){
		$this->db->select('idStockPartes, '. $this->tbl_stock.'.idParte,parte.descripcion parte_detalle,'. $this->tbl_stock .' .cantidad, cantUsadaInsumo, fechaIngreso, idAlmacen ,idEstadoParte, IF(insumo.idParte IS NULL,0,1 ) esInsumo',false);
		$this->db->join('parte', 'parte.idParte = '. $this->tbl_stock.'.idParte');
		$this->db->join('insumo','parte.idParte = insumo.idParte AND insumo.idInsumoParent IS NULL', 'left');
		$this->db->where($this->tbl_stock.".idParte",$idParte);
		$this->db->order_by($this->tbl_stock.'.idParte','asc');

		// $this->db->get($this->tbl_stock);
		// echo $this->db->last_query();die();
		return $this->db->get($this->tbl_stock);
	}

	function actualizarStock($data){
		$sql = "CALL sp_StockActualizar(?,?,?,?,?,?,?);";
		//$params = array();
		$query = $this->db->query($sql, $data);

		$res = $query->result();

		$query->next_result();
		$query->free_result();
		//echo $this->db->last_query();
		return true;
	}

	function getFaltantes(){
		$sql = "CALL sp_StockObtenerFaltantes();";
		//$params = array();
		$query = $this->db->query($sql);

		$res = $query->result();

		$query->next_result();
		$query->free_result();
		//echo $this->db->last_query();
		return $res;
	}

	function getFaltantesGral(){
		$sql = "CALL sp_StockObtenerFaltantesGral();";
		//$params = array();
		$query = $this->db->query($sql);

		$res = $query->result();

		$query->next_result();
		$query->free_result();
		//echo $this->db->last_query();
		return $res;
	}

	function insert($data){
		$this->db->insert($this->tbl_stock, $data);
		return $this->db->insert_id();
	}

	function update($idStockPartes, $data){
        $this->db->where('idStockPartes', $idStockPartes);
        $this->db->update($this->tbl_stock, $data);
	}

	function delete($idStockPartes){
        $this->db->delete($this->tbl_stock,  array('idStockPartes' => $idStockPartes));
	}

}