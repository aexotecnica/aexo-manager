<?php
class M_Exportacion extends CI_Model {
	// table name
	private $tbl_oldClientes= 'old_clientes';
    private $tbl_oldClientesMovimientos= 'old_clientesmovimientos';
    

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

    function insert_clienteDetalle($data){
        $DB1 = $this->load->database('exportacion', TRUE);
        $DB1->insert_batch($this->tbl_oldClientesMovimientos, $data);
        $ultimoId = $DB1->insert_id();

        return $ultimoId;
    }

    function delete_clienteDetalle(){
        $DB1 = $this->load->database('exportacion', TRUE);
        $DB1->empty_table($this->tbl_oldClientesMovimientos);
    }

    function citiCompra_get($periodo){
        $DB1 = $this->load->database('exportacion', TRUE);
        $sql = "CALL sp_citiCompras_Movimientos(?)";
        $params = array($periodo);
        $query = $DB1->query($sql, $params);
        $res = $query->result();

        $query->next_result();
        $query->free_result();
        return $res;
    }

    function citiCompraAlicuotas_get($periodo){
        $DB1 = $this->load->database('exportacion', TRUE);
        $sql = "CALL sp_citiCompras_Alicuotas(?)";
        $params = array($periodo);
        $query = $DB1->query($sql, $params);
        $res = $query->result();

        $query->next_result();
        $query->free_result();
        return $res;
    }


}