<?php
class M_Parte extends CI_Model {
	// table name
	private $tbl_parte= 'parte';

	function __construct()
	{
        // Call the Model constructor
		parent::__construct();
	}

	// get number of proyectos in database
	function count_all(){
		return $this->db->count_all($this->tbl_parte);
	}
	// get proyectos with paging
	function get_paged_list($limit = 10, $offset = 0){
		$this->db->order_by('idParte','asc');
		return $this->db->get($this->tbl_parte, $limit, $offset);
	}

	function get_partesFinales(){
		$this->db->where('esParteFinal', 1);
		$this->db->order_by('idParte','asc');
		return $this->db->get($this->tbl_parte);
	}

	function filter_partes($keyword){
		$this->db->select('idParte, descripcion');
		$this->db->where("descripcion like '%" . $keyword ."%'");
		$this->db->order_by('descripcion','asc');
		return $this->db->get($this->tbl_parte);
	}

	// get person by id
	function get_by_id($id){
		$this->db->where('idParte', $id);
		return $this->db->get($this->tbl_parte);
	}


	function insert($data){
		$this->db->insert($this->tbl_parte, $data);
		return $this->db->insert_id();
	}

	function update($idParte, $data){
        $this->db->where('idParte', $idParte);
        $this->db->update($this->tbl_parte, $data);
	}

	function delete($idParte){
        $this->db->delete($this->tbl_parte,  array('idParte' => $idParte));
	}
}