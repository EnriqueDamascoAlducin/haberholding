<?php 

  include_once '../../../../controladores/finsession.php';
  include_once '../../../../controladores/conexion.php';
  require_once $_SERVER["DOCUMENT_ROOT"].'/haberholding/plugins/PHPExcel/Classes/PHPExcel.php';

  //Consultas para obtener datos

  $equipos = "SELECT eq.id,eq.serie, eq.fecha_max_garantia as garantia, ma.nombre as marca, mo.nombre as modelo FROM equipos eq INNER JOIN marcas ma ON ma.id = eq.id_marca INNER JOIN modelos mo ON mo.id = eq.id_modelo Where eq.status <>0 ";
  $usuXequipo = "SELECT CONCAT(IFNULL(nombre_usu,''),' ',IFNULL(apellidop_usu,'')) as usuario, nombre_depto as depto FROM usuarios u INNER JOIN usuarios_equipo ue ON u.id_usu = ue.id_usuario INNER JOIN departamentos ON depto_usu = id_depto WHERE ue.status<>0 and u.status_usu<>0 and id_equipo = ? ";

  $so = "SELECT s.nombre FROM software s INNER JOIN equipos_software es ON s.id = es.id_componente WHERE s.id_clasificacion = 1 AND id_equipo = ? ";
  if(isset($_GET['depto']) && !empty($_GET['depto']) ){
    $usuXequipo .= "  AND depto_usu = ".$_GET['depto'];
  }
  if(isset($_GET['marca']) && !empty($_GET['marca']) ){
    $equipos .= " AND eq.id_marca=".$_GET['marca'];
  }
  if(isset($_GET['modelos']) && !empty($_GET['modelos']) ){
    $equipos .= " AND eq.id_modelo=".$_GET['modelos'];
  }
  if(isset($_GET['garantia']) && !empty($_GET['garantia']) ){
    $equipos .= " AND fecha_max_garantia is not null AND fecha_max_garantia<='".$_GET['garantia']."'";
  }
  $equipos.="  ORDER BY eq.serie asc, eq.id   ";
  //  echo $select.$from.$where;
  //Consulta Preparada para consegur el departamento y el usuario
  $preparedUsuXequipo  = $con->prepare($usuXequipo);
  $preparedSO = $con->prepare($so);

$equipos = $con->query($equipos);


//Comienza Creación de Excel
$fila=3;
$titulo=1;
$enc=2;
$objphp= new PHPExcel();
$gdImage = imagecreatefrompng($_SERVER["DOCUMENT_ROOT"].'/haberholding/dist/img/logo_hh.png');//Logotipo
$objphp->getProperties()
        ->setCreator("HaberHolding")
        ->setLastModifiedBy("HaberHolding")
        ->setTitle("Reporte General")
        ->setSubject("Reporte General")
        ->setDescription("Reporte General")
        ->setKeywords("haberholding")
        ->setCategory("Equipos");
$objphp->setActiveSheetIndex(0);
$objphp->getActiveSheet()->setTitle('General');
////////// Para dibujar el logo


	$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
	$objDrawing->setName('Logotipo');
	$objDrawing->setDescription('Logotipo');
	$objDrawing->setImageResource($gdImage);
	$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
	$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
	$objDrawing->setHeight(100);
	$objDrawing->setCoordinates('B1');
	$objDrawing->setWorksheet($objphp->getActiveSheet());
////////////Dibujar el log

/////////////////     Estilos de las celdas (titulos y contenido)
$estiloTituloReporte = array(
    	'font' => array(
			'name'      => 'Arial',
			'bold'      => true,
			'italic'    => false,
			'strike'    => false,
			'size' =>25
    	),
    	'fill' => array(
			'type'  => PHPExcel_Style_Fill::FILL_SOLID
		),
    	'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_NONE
			)
    	),
    	'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    	)
	);

	$estiloTituloColumnas = array(
    	'font' => array(
			'name'  => 'Arial',
			'bold'  => true,
			'size' =>10,
			'color' => array('rgb' => 'FFFFFF')
    	),
    	'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => '538DD5')
    	),
    	'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN
			)
    	),
    	'alignment' =>  array(
			'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
    	)
	);

	$estiloInformacion = new PHPExcel_Style();
	$estiloInformacion->applyFromArray( array(
    	'font' => array(
			'name'  => 'Arial',
			'color' => array('rgb' => '000000')
	    ),
    	'fill' => array(
			'type'  => PHPExcel_Style_Fill::FILL_SOLID
		),
    	'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN
			)
    	),
		'alignment' =>  array(
			'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
    	)
	));


/////////////////     Estilos de las celdas (titulos y contenido)



$objphp->getActiveSheet()->getStyle('A1:Q1')->applyFromArray($estiloTituloReporte);
$objphp->getActiveSheet()->getRowDimension(1)->setRowHeight(100);
$objphp->getActiveSheet()->getColumnDimension('A')->setWidth(25);
//$objphp->getActiveSheet()->setCellValue('B'.$titulo,'Reporte de Vuelos de Volar en Globo');


$objphp->getActiveSheet()->setCellValue('B'.$titulo, 'Reporte General');
$objphp->getActiveSheet()->mergeCells('B'.$titulo.':G'.$titulo);
$objphp->getActiveSheet()->getStyle('A'.$enc.':G'.$enc)->applyFromArray($estiloTituloColumnas);

$objphp->getActiveSheet()->setCellValue('A'.$enc, 'Usuario');
$objphp->getActiveSheet()->getColumnDimension('A')->setWidth(25);
$objphp->getActiveSheet()->setCellValue('B'.$enc, 'Departamento');
$objphp->getActiveSheet()->getColumnDimension('B')->setWidth(25);
$objphp->getActiveSheet()->setCellValue('C'.$enc, 'No. Serie');
$objphp->getActiveSheet()->getColumnDimension('C')->setWidth(25);
$objphp->getActiveSheet()->setCellValue('D'.$enc, 'Marca');
$objphp->getActiveSheet()->getColumnDimension('D')->setWidth(25);
$objphp->getActiveSheet()->setCellValue('E'.$enc, 'Modelo ');
$objphp->getActiveSheet()->getColumnDimension('E')->setWidth(25);
$objphp->getActiveSheet()->setCellValue('F'.$enc, 'S.O');
$objphp->getActiveSheet()->getColumnDimension('F')->setWidth(25);
$objphp->getActiveSheet()->setCellValue('G'.$enc, 'Garantia');
$objphp->getActiveSheet()->getColumnDimension('G')->setWidth(30);

while($equipo = $equipos->fetch_assoc()){

    $preparedUsuXequipo->bind_param('i',$equipo['id']);
    $preparedUsuXequipo->execute();
    $usuario = $preparedUsuXequipo->get_result();
    $usrs=[];
    $deptos=[];
    foreach ($usuario as $usr) {
      $usrs[] = $usr['usuario'];
      $deptos[]= $usr['depto'];
  	}
    $preparedSO->bind_param('i',$equipo['id']);
    $preparedSO->execute();
    $SSOO = $preparedSO->get_result();
    $sos=[];
    foreach ($SSOO as $SSO) {
      $sos[] = $SSO['nombre'];
    }
    if(sizeof($usrs)>0)
	  	$usuario = $usrs[0];
	else
		$usuario = "NA";
	if(sizeof($deptos)>0)  	
	  	$depto = $deptos[0];
	else
		$depto = "NA";
	if(sizeof($sos)>0)		
  		$so = $sos[0];
  	else
  		$so = "NA";
    if((isset($_GET['depto']) && !empty($_GET['depto']) )  ){
    	if(sizeof($deptos)>0){
			$objphp->getActiveSheet()->setCellValue('A'.$fila, $usuario);
			$objphp->getActiveSheet()->setCellValue('B'.$fila, $depto);
			$objphp->getActiveSheet()->setCellValue('C'.$fila, $equipo['serie']);
			$objphp->getActiveSheet()->setCellValue('D'.$fila, $equipo['marca']);
			$objphp->getActiveSheet()->setCellValue('E'.$fila, $equipo['modelo']);
			$objphp->getActiveSheet()->setCellValue('F'.$fila, $so);
			$objphp->getActiveSheet()->setCellValue('G'.$fila, $equipo['garantia']);
			$fila++;
    	}
    }else{
		$objphp->getActiveSheet()->setCellValue('A'.$fila, $usuario);
		$objphp->getActiveSheet()->setCellValue('B'.$fila, $depto);
		$objphp->getActiveSheet()->setCellValue('C'.$fila, $equipo['serie']);
		$objphp->getActiveSheet()->setCellValue('D'.$fila, $equipo['marca']);
		$objphp->getActiveSheet()->setCellValue('E'.$fila, $equipo['modelo']);
		$objphp->getActiveSheet()->setCellValue('F'.$fila, $so);
		$objphp->getActiveSheet()->setCellValue('G'.$fila, $equipo['garantia']);
		$fila++;
    }
}
$fila--;
$objphp->getActiveSheet()->setSharedStyle($estiloInformacion, "A3:G".$fila);


header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Disposition: attachment;filename="reporteExcel.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objphp, 'Excel2007');
$objWriter->save('php://output');
exit;
?>