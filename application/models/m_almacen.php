<?php
class M_Almacen extends CI_Model {
	// table name
	private $tbl_almacen= 'almacen';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	// get number of proyectos in database
	function count_all(){
		return $this->db->count_all($this->tbl_almacen);
	}
	// get proyectos with paging
	function get_paged_list($limit = 10, $offset = 0){
		$this->db->order_by('idAlmacen','asc');
		return $this->db->get($this->tbl_almacen, $limit, $offset);
	}
	// get person by id
	function get_by_id($id){
		$this->db->where('idAlmacen', $id);
		return $this->db->get($this->tbl_almacen);
	}

}