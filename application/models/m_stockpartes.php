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
		$this->db->order_by('idStockPartes','asc');
		return $this->db->get($this->tbl_stock, $limit, $offset);
	}

	function get_by_id($id){
		$this->db->select('idStockPartes, idParte, cantidad,fecUltimoIngreso, idAlmacen,idEstadoParte');
		$this->db->where("idStockPartes",$id);
		$this->db->order_by('idParte','asc');
		return $this->db->get($this->tbl_stock);
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