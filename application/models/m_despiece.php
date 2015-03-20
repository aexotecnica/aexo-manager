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
		$this->db->order_by('idDespiece','asc');
		return $this->db->get($this->tbl_despiece, $limit, $offset);
	}
	// get person by id
	function get_by_id($id){
		$this->db->where('idDespiece', $id);
		return $this->db->get($this->tbl_despiece);
	}


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

	function obtenerDespiece($idProducto){
		$sql = "CALL sp_DespieceHijosConsultar(?)";
		$params = array($idProducto);
		$query = $this->db->query($sql, $params);
		$res =$query->result();

		$query->next_result();
		$query->free_result();
		return $res;
	}
}