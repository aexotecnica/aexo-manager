<?php
class M_OrdenCompra extends CI_Model {
	// table name
	private $tbl_ordenPedido= 'ordencompra';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	// get number of proyectos in database
	function count_all(){
		return $this->db->count_all($this->tbl_ordenPedido);
	}
	// get proyectos with paging
	function get_paged_list($limit = 10, $offset = 0){
		$this->db->select('idOrdenCompra,idEstadoCompra, proveedor.idProveedor idProveedor, fecha, fechaEntrega, nombre proveedor_nombre');
		//$this->db->from($this->tbl_ordenPedido);
		$this->db->join('proveedor', 'proveedor.idProveedor = '. $this->tbl_ordenPedido.'.idProveedor');
		$this->db->order_by('idOrdenCompra','asc');
		return $this->db->get($this->tbl_ordenPedido, $limit, $offset);
	}
	// get person by id
	function get_by_id($id){
		$this->db->select('idOrdenCompra,idEstadoCompra, proveedor.idProveedor idProveedor, fecha, fechaEntrega, precioTotal, costoTotal, nombre proveedor_nombre');
		$this->db->join('proveedor', 'proveedor.idProveedor = '. $this->tbl_ordenPedido.'.idProveedor');
		$this->db->where('idOrdenCompra', $id);
		return $this->db->get($this->tbl_ordenPedido);
	}

	function insert($data){
        $this->db->insert($this->tbl_ordenPedido, $data);
        $ultimoId = $this->db->insert_id();

		return $ultimoId;
	}

	function guardar($data){
		$sql = "CALL sp_OrdenPedidoAgregar(?,?,?,?,?,?,?);";
		$params = array($data["idProveedor"], 
						$data["fecha"], 
						$data["fechaEntrega"], 
						$data["idEstadoCompra"],
						$data["precioTotal"],
						$data["costoTotal"]);
		$query = $this->db->query($sql, $params);

		$res = $query->result();

		$query->next_result();
		$query->free_result();
		//echo $this->db->last_query();
		return $res[0];
	}

	function update($idOrdenCompra, $data){
        $this->db->where('idOrdenCompra', $idOrdenCompra);
        $this->db->update($this->tbl_ordenPedido, $data);
	}

	function delete($idOrdenCompra){
        $this->db->delete($this->tbl_ordenPedido,  array('idOrdenCompra' => $idOrdenCompra));
		return $this->db->insert_id();
	}

	function obtenerOrdenesYDetalles($ids){
		$sql = "CALL sp_OrdenPedidoDetalleEnConjunto(?);";
		$params = array($ids);
		$query = $this->db->query($sql, $params);

		$res = $query->result();

		$query->next_result();
		$query->free_result();
		//echo $this->db->last_query();
		return $res;
	}

}