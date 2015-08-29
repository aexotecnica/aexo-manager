<?php
class M_Exportacion extends CI_Model {
	// table name
	private $tbl_oldClientes= 'old_clientes';
    private $tbl_oldProveedorMovimiento= 'old_clientesmovimientos';
    private $tbl_oldVtaMovimiento= 'old_vtamovimiento';
    

    function __construct()
    {
        // Call the Model constructor
        
        parent::__construct();
    }
    
	function insert_cliente($data){
        $DB1 = $this->load->database('exportacion', TRUE);
        $DB1->insert_batch($this->tbl_oldClientes, $data);
        $ultimoId = $DB1->insert_id();

		return $ultimoId;
	}

	function delete_cliente(){
        $DB1 = $this->load->database('exportacion', TRUE);
        $DB1->empty_table($this->tbl_oldClientes);
	}

    function insert_proveedorDetalle($data){
        try {
            $DB1 = $this->load->database('exportacion', TRUE);
            $DB1->insert_batch($this->tbl_oldProveedorMovimiento, $data);
            $ultimoId = $DB1->insert_id();

            return $ultimoId;    
        }catch (Exception $e) {
            echo json_encode(array(
                'error' => array(
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
                ),
            ));
        }
        
    }

    function insert_clienteVtaDetalle($data){
        $DB1 = $this->load->database('exportacion', TRUE);
        $DB1->insert_batch($this->tbl_oldVtaMovimiento, $data);
        $ultimoId = $DB1->insert_id();

        return $ultimoId;
    }

    function delete_clienteDetalle(){
        $DB1 = $this->load->database('exportacion', TRUE);
        $DB1->empty_table($this->tbl_oldProveedorMovimiento);
    }

    function delete_clienteVtaDetalle(){
        $DB1 = $this->load->database('exportacion', TRUE);
        $DB1->empty_table($this->tbl_oldVtaMovimiento);
    }

    function citiCompra_get($periodo, $anio){
        $DB1 = $this->load->database('exportacion', TRUE);
        $sql = "CALL sp_citiCompras_Movimientos(?,?)";
        $params = array($periodo, $anio);
        $query = $DB1->query($sql, $params);
        $res = $query->result();

        $query->next_result();
        $query->free_result();
        return $res;
    }

    function citiVenta_get($periodo, $anio){
        $DB1 = $this->load->database('exportacion', TRUE);
        $sql = "CALL sp_citiVentas_Movimientos(?,?)";
        $params = array($periodo, $anio);
        $query = $DB1->query($sql, $params);
        $res = $query->result();

        $query->next_result();
        $query->free_result();
        return $res;
    }

    function citiCompraAlicuotas_get($periodo, $anio){
        $DB1 = $this->load->database('exportacion', TRUE);
        $sql = "CALL sp_citiCompras_Alicuotas(?,?)";
        $params = array($periodo, $anio);
        $query = $DB1->query($sql, $params);
        $res = $query->result();

        $query->next_result();
        $query->free_result();
        return $res;
    }

    function citiVentaAlicuotas_get($periodo, $anio){
        $DB1 = $this->load->database('exportacion', TRUE);
        $sql = "CALL sp_citiVentas_alicuotas(?,?)";
        $params = array($periodo, $anio);
        $query = $DB1->query($sql, $params);
        $res = $query->result();

        $query->next_result();
        $query->free_result();
        return $res;
    }


}