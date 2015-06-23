<?php
class M_Cliente extends CI_Model {
	// table name
	private $tbl_cliente= 'cliente';
	

	function __construct()
	{
        // Call the Model constructor
		parent::__construct();
	}

	// get number of proyectos in database
	function count_all(){
		return $this->db->count_all($this->tbl_cliente);
	}
	// get proyectos with paging
	function get_paged_list($limit = 10, $offset = 0){
		$this->db->order_by('idCliente','asc');
		return $this->db->get($this->tbl_cliente, $limit, $offset);
	}

	function filter_clientes($keyword){
		$this->db->select('idCliente, nombre, responsable');
		$this->db->where("nombre like '%" . $keyword ."%'");
		$this->db->order_by('nombre','asc');
		return $this->db->get($this->tbl_cliente);
	}

	function get_by_id($id){
		$this->db->select('idCliente, nombre, idTipoCliente, idCategoriaIVA, telefono_1, cuit, domicilio, calle, numero, 
							idProvincia, localidad, partido, codigoPostal, 
							responsable, email, paginaWeb, volumenFact, 
							dias_horarios, latitud, longitud');
		$this->db->where("idCliente",$id);
		$this->db->order_by('nombre','asc');
		return $this->db->get($this->tbl_cliente);
	}


	function insert($data){
		$this->db->insert($this->tbl_cliente, $data);
		return $this->db->insert_id();
	}

	function update($idCliente, $data){
        $this->db->where('idCliente', $idCliente);
        $this->db->update($this->tbl_cliente, $data);
	}

	function delete($idCliente){
        $this->db->delete($this->tbl_cliente,  array('idCliente' => $idCliente));
	}

}