<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exportacion extends MY_Controller {

	private $permiso_autorizaPago;
	function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
		$this->load->model('M_Notificacion','',TRUE);
		$this->load->model('M_Exportacion','',TRUE);

		$permisos = $this->session->userdata('permisos');
		$this->permiso_autorizaPago = array_filter($permisos,
			function ($e) {
				return $e->label == '[AUTORIZAERESTADOPAGO]';
			});

	}


	public function index()
	{

		$out = $this->load->view('view_citi_compra_vta.php', NULL, TRUE);
		$data['cuerpo'] = $out;
		echo getcwd() . "\assets\aexo-manager\uploads\ ";
		parent::cargarTemplate($data);
	}

	public function subirarchivos()
	{

		var_dump($_FILES);
		if (!empty($_FILES)) {
			if (!empty($_FILES['cliente']))
			{
				$tempFile = $_FILES['cliente']['tmp_name'];
				$fileName = "cliente-" . $_FILES['cliente']['name'];
			} else if(!empty($_FILES['movimiento'])){
				$tempFile = $_FILES['movimiento']['tmp_name'];
				$fileName = "movimiento-" . $_FILES['movimiento']['name'];
			}
			$targetPath = getcwd() . trim("\assets\aexo-manager\uploads\ ");
			$targetFile = $targetPath . $fileName ;
			move_uploaded_file($tempFile, $targetFile);

		}
	}

	public function ivacompras()
	{
		$this->M_Exportacion->delete_cliente();
		$this->M_Exportacion->delete_clienteDetalle();
		$this->importarClientes($this->input->post('archivoProveedores'));
		$this->importarClientesDetalle($this->input->post('archivoMovimientos'));

		$periodo = 1;
		$pathMovimientos = $this->exportarCitiCompra($periodo);
		$pathAlicuotas = $this->exportarCitiCompraAlicuota($periodo);

		$archivos["movimientos"] = $pathMovimientos;
		$archivos["alicuotas"] = $pathAlicuotas;

		echo json_encode($archivos);

	}

	private function exportarCitiCompra($periodo){
		$result = $this->M_Exportacion->citiCompra_get($periodo);
		$fileName = "output-movimientos.txt";

		$fileMovimiento = fopen(getcwd() . "\assets\aexo-manager\uploads\\" . $fileName, "w+") or die("No se pudo abrir el archivo!");
		foreach ($result as $key => $item){ 
			//var_dump($item->linea);
			$texto = $item->linea . "\n";
			fwrite($fileMovimiento, $texto);
		}
		fclose($fileMovimiento);

		return base_url(). "assets/aexo-manager/uploads/" . $fileName;
	}

	private function exportarCitiCompraAlicuota($periodo){
		$result = $this->M_Exportacion->citiCompraAlicuotas_get($periodo);
		$fileName = "output-movimientos-alicuota.txt";

		$fileMovimiento = fopen(getcwd() . "\assets\aexo-manager\uploads\\" . $fileName, "w+") or die("No se pudo abrir el archivo!");
		foreach ($result as $key => $item){ 
			//var_dump($item->linea);
			$texto = $item->linea . "\n";
			fwrite($fileMovimiento, $texto);
		}
		fclose($fileMovimiento);
		return base_url(). "assets/aexo-manager/uploads/" . $fileName;
	}

	private function importarClientes($fileName){
		$fileCliente = fopen(base_url(). "assets/aexo-manager/uploads/" . $fileName, "r") or die("No se pudo abrir el archivo!");

		$data = array();
		$indice = 0;

		while(!feof($fileCliente)) {
			$linea = fgets($fileCliente);
			list($codigo, 
				$codAgr, 
				$nombre, 
				$dato1, 
				$dato2, 
				$dato3, 
				$categoriaIva, 
				$nroIngrBrutos, 
				$cuit, 
				$saldoActual,
				$fechaUltimaCompra, 
				$moneda, 
				$prov) = explode(",", $linea);

			$data[$indice] = array(
			      'codigo' => 			trim(str_replace("\"","" , $codigo)),
			      'codAgr' => 			trim(str_replace("\"","", $codAgr)),
			      'nombre' => 			trim(str_replace("\"","", $nombre)),
			      'dato1' => 			trim(str_replace("\"","", $dato1)),
			      'dato2' => 			trim(str_replace("\"","", $dato2)),
			      'categoriaIva' => 	trim(str_replace("\"","", $categoriaIva)),
			      'nroIngrBrutos' => 	trim(str_replace("\"","", $nroIngrBrutos)),
			      'cuit' => 			trim(str_replace("\"","", $cuit)),
			      'saldoActual' => 		trim(str_replace("\"","", $saldoActual)),
			      'fechaUltimaCompra'=>	trim(str_replace("\"","", $fechaUltimaCompra)),
			      'moneda' => 			trim(str_replace("\"","", $moneda)),
			      'prov' => 			trim(str_replace("\"","", $prov))
			   );
			$indice +=1;
		}
		
		fclose($fileCliente);

		$this->M_Exportacion->insert_cliente($data);
	}

	private function importarClientesDetalle($fileName){
		$indice = 0;
		$fileClienteDetalle = fopen(base_url(). "assets/aexo-manager/uploads/" . $fileName, "r") or die("No se pudo abrir el archivo!");
		while(!feof($fileClienteDetalle)) {
			$linea = fgets($fileClienteDetalle);
			list($fecha,
				$tipo,
				$numero,
				$rc,
				$codigo,
				$detalle,
				$tipoMov,
				$gravado,
				$iva,
				$noIns,
				$mon,
				$gravado2,
				$iva2,
				$noIns2,
				$ivaPer) = explode(",", $linea);

			$dataDetalle[$indice] = array(
			      'fecha' => 			trim(str_replace("\"","" , $fecha)),
			      'tipo' => 			trim(str_replace("\"","", $tipo)),
			      'numero' => 			trim(str_replace("\"","", $numero)),
			      'rc' => 				trim(str_replace("\"","", $rc)),
			      'codigo' => 			trim(str_replace("\"","", $codigo)),
			      'detalle' => 			trim(str_replace("\"","", $detalle)),
			      'tipoMov' => 			trim(str_replace("\"","", $tipoMov)),
			      'gravado' => 			trim(str_replace("\"","", $gravado)),
			      'iva' => 				trim(str_replace("\"","", $iva)),
			      'noIns' => 			trim(str_replace("\"","", $noIns)),
			      'mon' => 				trim(str_replace("\"","", $mon)),
			      'gravado2' => 		trim(str_replace("\"","", $gravado2)),
			      'iva2' => 			trim(str_replace("\"","", $iva2)),
			      'noIns2' => 			trim(str_replace("\"","", $noIns2)),
			      'ivaPer' => 			trim(str_replace("\"","", $ivaPer))
			   );
			$indice +=1;
		}

		
		fclose($fileClienteDetalle);

		$this->M_Exportacion->insert_clienteDetalle($dataDetalle);
	}

}