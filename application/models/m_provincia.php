<?php
class M_Provincia extends CI_Model {
	// table name
	private $tbl_provincia= 'provincia';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	// get number of proyectos in database
	function count_all(){
		return $this->db->count_all($this->tbl_provincia);
	}
	// get proyectos with paging
	function get_paged_list($limit = 10, $offset = 0){
		$this->db->order_by('idProvincia','asc');
		return $this->db->get($this->tbl_provincia, $limit, $offset);
	}
	// get person by id
	function get_by_id($id){
		$this->db->where('idProvincia', $id);
		return $this->db->get($this->tbl_provincia);
	}

}