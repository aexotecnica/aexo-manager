<?php
class M_NecesidadPedido extends CI_Model {
	// table name
	private $tbl_necesidadPedido= 'necesidadpedido';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	// get number of proyectos in database
	function count_all(){
		return $this->db->count_all($this->tbl_necesidadPedido);
	}
	// get proyectos with paging
	function get_paged_list($limit = 10, $offset = 0){
		$this->db->order_by('idOrdenPedido','asc');
		return $this->db->get($this->tbl_necesidadPedido, $limit, $offset);
	}
	// get proyectos with paging
	function getNecesidades($limit = 800, $offset = 0){
		$this->db->select('parte.idParte idParte,codigo,descripcion parte_descripcion, sum(cantidad) cantidad');
		//$this->db->from($this->tbl_ordenPedido);
		$this->db->join('parte', 'parte.idParte = '. $this->tbl_necesidadPedido.'.idParte');
		$this->db->group_by('parte.idParte');
		return $this->db->get($this->tbl_necesidadPedido, $limit, $offset);
	}
	// get person by id
	function get_by_id($id){
		$this->db->where('idOrdenPedido', $id);
		return $this->db->get($this->tbl_necesidadPedido);
	}

	function insert($data){
        $this->db->insert($this->tbl_necesidadPedido, $data);
        $ultimoId = $this->db->insert_id();

		return $ultimoId;
	}

	function update($idOrdenPedido, $data){
        $this->db->where('idOrdenPedido', $idOrdenPedido);
        $this->db->update($this->tbl_necesidadPedido, $data);
	}

	function delete($idOrdenPedido){
		$this->db->delete($this->tbl_necesidadPedido,  array('idOrdenPedido' => $idOrdenPedido));
		return $this->db->insert_id();
	}


}