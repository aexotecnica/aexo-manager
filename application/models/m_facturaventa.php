<?php
class M_FacturaVenta extends CI_Model {
	// table name
	private $tbl_facturaVenta= 'facturavta';

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
		$this->db->select('idFactura,nroFactura, cliente.idCliente idCliente, fechaFactura, fechaVencimiento, nombre cliente_nombre, importe, estadofactura.descripcion descripcionEstado');
		$this->db->join('cliente', 'cliente.idCliente = '. $this->tbl_facturaVenta.'.idCliente');
		$this->db->join('estadofactura', 'estadofactura.idEstadoFactura = '. $this->tbl_facturaVenta.'.idEstadoFactura');
		$this->db->order_by('idFactura','asc');
		return $this->db->get($this->tbl_facturaVenta, $limit, $offset);
	}

	function get_list($idEstadoFactura){
		$this->db->select('idFactura,nroFactura, cliente.idCliente idCliente, fechaFactura, fechaVencimiento, nombre cliente_nombre, importe, estadofactura.descripcion descripcionEstado');
		$this->db->join('cliente', 'cliente.idCliente = '. $this->tbl_facturaVenta.'.idCliente');
		$this->db->join('estadofactura', 'estadofactura.idEstadoFactura = '. $this->tbl_facturaVenta.'.idEstadoFactura');
		$this->db->order_by('idFactura','asc');
		$this->db->where($this->tbl_facturaVenta.'.idEstadoFactura', $idEstadoFactura);
		return $this->db->get($this->tbl_facturaVenta);
	}


	// get person by id
	function get_by_id($id){
		$this->db->select('idFactura,nroFactura, cliente.idCliente idCliente, fechaFactura, fechaVencimiento, nombre cliente_nombre, importe, iva');
		$this->db->join('cliente', 'cliente.idCliente = '. $this->tbl_facturaVenta.'.idCliente');
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
		$sql = "CALL sp_FacturaVtaAgregar(?,?,?,?,?,?,?);";
		$params = array($data["idCliente"], 
						$data["nroFactura"],
						$data["fechaFactura"], 
						$data["fechaVencimiento"], 
						$data["importe"],
						$data["iva"],
						$data["idEstadoFactura"]);
		$query = $this->db->query($sql, $params);

		$res = $query->result();

		$query->next_result();
		$query->free_result();
		//echo $this->db->last_query();

		//var_dump($res);
		return $res[0];
	}

	function update($idFactura, $data){
        $this->db->where('idFactura', $idFactura);
        $this->db->update($this->tbl_facturaVenta, $data);
	}

}