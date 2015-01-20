<?php
class M_MovimientoSaldoMes extends CI_Model {
	// table name
	private $tbl_movimientosaldo = 'movimientosaldomes';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('session');
    }
    
	// get number of Clientes in database
	function count_all(){
		return $this->db->count_all('movimientosaldomes');
	}


	
}