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
		$data['permiso'] = "[PERMISOGENERAL]";
		//echo getcwd() . "\assets\aexo-manager\uploads\ ";
		parent::cargarTemplate($data);
	}

	public function subirarchivos()
	{
		echo "empezo a subir";

		if (!empty($_FILES)) {
			if (!empty($_FILES['cliente']))
			{
				$tempFile = $_FILES['cliente']['tmp_name'];
				$fileName = "cliente-" . $_FILES['cliente']['name'];
			} else if(!empty($_FILES['movimiento'])){
				$tempFile = $_FILES['movimiento']['tmp_name'];
				$fileName = "movimiento-" . $_FILES['movimiento']['name'];
			}

			$targetPath = getcwd() . trim("/assets/aexo-manager/uploads/ ");
			$targetFile = $targetPath . $fileName ;
			move_uploaded_file($tempFile, $targetFile);

		}
	}

	public function ivacompras()
	{
		$this->M_Exportacion->delete_cliente();
		$this->M_Exportacion->delete_clienteDetalle();
		$mes = 	$this->input->post('mes');
		$anio = $this->input->post('anio');

		$this->importarProveedores($this->input->post('archivoProveedores'));
		$this->importarProveedoresDetalle($this->input->post('archivoMovimientos'));

		//$periodo = 1;
		$pathMovimientos = $this->exportarCitiCompra($mes, $anio);
		$pathAlicuotas = $this->exportarCitiCompraAlicuota($mes, $anio);

		$archivos["movimientos"] = $pathMovimientos;
		$archivos["alicuotas"] = $pathAlicuotas;

		echo json_encode($archivos);
	}

	public function ivaventas()
	{
		$this->M_Exportacion->delete_cliente();
		$this->M_Exportacion->delete_clienteDetalle();
		$this->M_Exportacion->delete_clienteVtaDetalle();

		$mes = 	$this->input->post('mes');
		$anio = $this->input->post('anio');

		$this->importarProveedores($this->input->post('archivoProveedores'));
		$this->importarClientesDetalle($this->input->post('archivoMovimientos'));

		$pathMovimientos = $this->exportarCitiVenta($mes, $anio);
		$pathAlicuotas = $this->exportarCitiVentaAlicuota($mes, $anio);

		$archivos["movimientos"] = $pathMovimientos; //$pathMovimientos;
		$archivos["alicuotas"] = $pathAlicuotas;

		echo json_encode($archivos);

	}

	private function exportarCitiCompra($periodo, $anio){
		$result = $this->M_Exportacion->citiCompra_get($periodo, $anio);
		$fileName = "output-movimientos.txt";

		$fileMovimiento = fopen(getcwd() . "\assets\aexo-manager\uploads\\" . $fileName, "w+") or die("No se pudo abrir el archivo!");
		foreach ($result as $key => $item){ 
			//var_dump($item->linea);
			$texto = $item->linea . "\r\n";
			fwrite($fileMovimiento, $texto);
		}
		fclose($fileMovimiento);

		return base_url(). "assets/aexo-manager/uploads/" . $fileName;
	}

	private function exportarCitiVenta($periodo, $anio){
		$result = $this->M_Exportacion->citiVenta_get($periodo, $anio);
		$fileName = "output-movimientosVenta.txt";

		$fileMovimiento = fopen(getcwd() . "\assets\aexo-manager\uploads\\" . $fileName, "w+") or die("No se pudo abrir el archivo!");
		foreach ($result as $key => $item){ 
			$texto = $item->linea . "\r\n";
			fwrite($fileMovimiento, $texto);
		}
		fclose($fileMovimiento);

		return base_url(). "assets/aexo-manager/uploads/" . $fileName;
	}


	private function exportarCitiCompraAlicuota($periodo, $anio){
		$result = $this->M_Exportacion->citiCompraAlicuotas_get($periodo, $anio);
		$fileName = "output-movimientos-alicuota.txt";

		$fileMovimiento = fopen(getcwd() . "\assets\aexo-manager\uploads\\" . $fileName, "w+") or die("No se pudo abrir el archivo!");
		foreach ($result as $key => $item){ 
			//var_dump($item->linea);
			$texto = $item->linea . "\r\n";
			fwrite($fileMovimiento, $texto);
		}
		fclose($fileMovimiento);
		return base_url(). "assets/aexo-manager/uploads/" . $fileName;
	}

	private function exportarCitiVentaAlicuota($periodo, $anio){
		$result = $this->M_Exportacion->citiVentaAlicuotas_get($periodo, $anio);
		$fileName = "output-movimientosVta-alicuota.txt";

		$fileMovimiento = fopen(getcwd() . "\assets\aexo-manager\uploads\\" . $fileName, "w+") or die("No se pudo abrir el archivo!");
		foreach ($result as $key => $item){ 
			//var_dump($item->linea);
			$texto = $item->linea . "\r\n";
			fwrite($fileMovimiento, $texto);
		}
		fclose($fileMovimiento);
		return base_url(). "assets/aexo-manager/uploads/" . $fileName;
	}


	private function importarProveedores($fileName){
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
			list($tipo,
				$numero,
				$linea,
				$fecha,
				$cliente,
				$vend,
				$prov,
				$zona,
				$condVta,
				$bultos,
				$valor,
				$item,
				$cantidad,
				$precio,
				$bonif, 
				$comision,
				$bien,
				$deposito,
				$pedidoTipo,
				$pedidoNro,
				$cIva,
				$iva,
				$ini,
				$lib,
				$ii,
				$iper,
				) = explode(",", $linea);

			$dataDetalle[$indice] = array(
				'tipo' 		=> 		trim(str_replace("\"","" , $tipo)),
				'numero' 	=> 		trim(str_replace("\"","" , $numero)),
				'linea' 	=> 		trim(str_replace("\"","" , $linea)),
				'fecha' 	=> 		trim(str_replace("\"","" , $fecha)),
				'cliente' 	=> 		trim(str_replace("\"","" , $cliente)),
				'vend'		=> 		trim(str_replace("\"","" , $vend)),
				'prov'		=> 		trim(str_replace("\"","" , $prov)),
				'zona'		=> 		trim(str_replace("\"","" , $zona)),
				'condVta'	=> 		trim(str_replace("\"","" , $condVta)),
				'bultos'	=> 		trim(str_replace("\"","" , $bultos)),
				'valor'		=> 		trim(str_replace("\"","" , $valor)),
				'item'		=> 		trim(str_replace("\"","" , $item)),
				'cantidad'	=> 		trim(str_replace("\"","" , $cantidad)),
				'precio'	=> 		trim(str_replace("\"","" , $precio)),
				'bonif'		=> 		trim(str_replace("\"","" , $bonif)),
				'comision'	=> 		trim(str_replace("\"","" , $comision)),
				'bien'		=> 		trim(str_replace("\"","" , $bien)),
				'deposito'	=> 		trim(str_replace("\"","" , $deposito)),
				'pedidoTipo'=> 		trim(str_replace("\"","" , $pedidoTipo)),
				'pedidoNro'	=> 		trim(str_replace("\"","" , $pedidoNro)),
				'cIva'		=> 		trim(str_replace("\"","" , $cIva)),
				'iva'		=> 		trim(str_replace("\"","" , $iva)),
				'ini'		=> 		trim(str_replace("\"","" , $ini)),
				'lib'		=> 		trim(str_replace("\"","" , $lib)),
				'ii'		=> 		trim(str_replace("\"","" , $ii)),
				'iper'		=> 		trim(str_replace("\"","" , $iper))
			   );
			$indice += 1;
		}

		fclose($fileClienteDetalle);

		$this->M_Exportacion->insert_clienteVtaDetalle($dataDetalle);
	}

	private function importarProveedoresDetalle($fileName){
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

		$this->M_Exportacion->insert_proveedorDetalle($dataDetalle);
	}

}