<?php
class M_FacturaVenta extends CI_Model {
	// table name
	private $tbl_facturaVenta= 'facturaVta';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	// get number of proyectos in database
	function count_all(){
		return $this->db->count_all($this->tbl_facturaVenta);
	}
	// get proyectos with paging
	function get_paged_list($limit = 10, $offset = 0){
		$this->db->order_by('idFactura','asc');
		return $this->db->get($this->tbl_facturaVenta, $limit, $offset);
	}
	// get person by id
	function get_by_id($id){
		$this->db->where('idFactura', $id);
		return $this->db->get($this->tbl_facturaVenta);
	}

	function get_proximoNumFactura(){
		$this->db->select('IFNULL(MAX(`nroFactura`), 0) + 1 as `UltimoNro`', false);
		$this->db->from($this->tbl_facturaVenta);
		$nroFacturaResult = $this->db->get()->result();

		return $nroFacturaResult[0]->UltimoNro;	
	}

	function guardar($data){
		$sql = "CALL sp_FacturaVtaAgregar(?,?,?,?,?,?);";
		$params = array($data["idCliente"], 
						$data["nroFactura"],
						$data["fechaFactura"], 
						$data["fechaVencimiento"], 
						$data["importe"],
						$data["iva"]);
		$query = $this->db->query($sql, $params);

		$res = $query->result();

		$query->next_result();
		$query->free_result();
		echo $this->db->last_query();

		var_dump($res);
		return $res[0];
	}

}