<?php
class M_EstadoParte extends CI_Model {
	// table name
	private $tbl_estadoParte= 'parte_estadoparte';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	// get number of proyectos in database
	function count_all(){
		return $this->db->count_all($this->tbl_estadoParte);
	}
	// get proyectos with paging
	function get_paged_list($limit = 10, $offset = 0){
		$this->db->order_by('idEstadoParte','asc');
		return $this->db->get($this->tbl_estadoParte, $limit, $offset);
	}
	// get person by id
	function get_by_id($id){
		$this->db->where('idEstadoParte', $id);
		return $this->db->get($this->tbl_estadoParte);
	}

	function update($idEstadoParte, $data){
        $this->db->where('idEstadoParte', $idEstadoParte);
        $this->db->update($this->tbl_estadoParte, $data);
	}

	function insert($data){
		$this->db->insert($this->tbl_estadoParte, $data);
		return $this->db->insert_id();
	}

	function delete($idEstadoParte){
        $this->db->delete($this->tbl_estadoParte,  array('idEstadoParte' => $idEstadoParte));
	}

	// get proyectos with paging
	function get_estadosConfigurados($id, $limit = 10, $offset = 0){
		$sql = "CALL sp_parte_estadosConfObtener(?)";
		$params = array($id);
		$query = $this->db->query($sql, $params);
		return $query->result();
	}

	function insertEstadosConf($data){
		$this->db->insert("parte_estadoconf", $data);
		return $this->db->insert_id();
	}

	function deleteEstadosConf($idParte){
        $this->db->delete("parte_estadoconf",  array('idParte' => $idParte));
	}

	function getEstadoTerminal($idParte){
		$this->db->select('idEstadoParte,orden,esFinal');
		$this->db->from("parte_estadoconf");
		$this->db->where('idParte', $idParte);
		$this->db->where('esFinal', 1);
		return $this->db->get();
	}


}