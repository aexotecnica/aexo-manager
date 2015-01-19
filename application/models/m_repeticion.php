<?php
class M_Repeticion extends CI_Model {
	// table name
	private $tbl_repeticion= 'repeticion';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	// get number of proyectos in database
	function count_all(){
		return $this->db->count_all($this->tbl_repeticion);
	}
	// get proyectos with paging
	function get_paged_list($limit = 10, $offset = 0){
		$this->db->order_by('idRepeticion','asc');
		return $this->db->get($this->tbl_repeticion, $limit, $offset);
	}
	// get person by id
	function get_by_id($id){
		$this->db->where('idRepeticion', $id);
		return $this->db->get($this->tbl_repeticion);
	}

	function insert($data){
        $this->db->insert($this->tbl_repeticion, $data);
		return $this->db->insert_id();
	}
}