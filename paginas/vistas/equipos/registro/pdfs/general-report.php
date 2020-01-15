<?php
  include_once '../../../../controladores/finsession.php';
  include_once '../../../../controladores/conexion.php';
  require_once $_SERVER["DOCUMENT_ROOT"].'/haberholding/plugins/fpdf/fpdf.php';
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


  class PDF extends FPDF
  {
  // Cabecera de p�gina
  function Header()
  {
  	// Logo
  	$this->Image($_SERVER["DOCUMENT_ROOT"].'/haberholding/dist/img/logo_hh.jpg',10,8,33);
  	// Arial bold 15
  	$this->SetFont('Arial','B',30);
  	// Movernos a la derecha
  	$this->Cell(90);
  	$this->Ln(5);
  	// T�tulo
  	$this->Cell(145,10,'Reporte General',0,0,'R');
  	// Salto de l�nea
  	$this->Ln(30);
  }

  // Pie de página
  function Footer()
  {
  	// Posición: a 1,5 cm del final
  	$this->SetY(-15);
  	// Arial italic 8
  	$this->SetFont('Arial','I',8);
  	// Número de página
  	$this->Cell(0,10,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'C');
  }
  }

  // Creaci�n del objeto de la clase heredada
  $pdf = new PDF();
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetFont('Times','B',12);
  //$pdf->MultiCell(27,10,'Usuarioaaaaaaaaaaaaaaaaaaaaaaa',1,'C');
  $pdf->setFillColor(181,221,255);
  $pdf->Cell(27,10,'Usuario',1,0,'C',1);
  $pdf->Cell(29,10,'Departamento',1,0,'C',1);
  $pdf->Cell(27,10,'No. Serie',1,0,'C',1);
  $pdf->Cell(27,10,'Marca',1,0,'C',1);
  $pdf->Cell(27,10,'Modelo',1,0,'C',1);
  $pdf->Cell(27,10,'S.O',1,0,'C',1);
  $pdf->Cell(27,10,'Garantia',1,1,'C',1);

  //Relleno de Datos
  $pdf->SetFont('Arial','',8);
  $cont=2;
  while($equipo = $equipos->fetch_assoc()){
    if($cont%2==0){
      $pdf->setFillColor(200,200,200);
    }else{
      $pdf->setFillColor(233,233,233);
    }
    $cont++;

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


    if((isset($_GET['depto']) && !empty($_GET['depto']) )  ){
      if(sizeof($deptos)>0){
        if(sizeof($usrs)==0)
          $pdf->Cell(27,10,'N/A',1,0,'C',1);
        else
          $pdf->Cell(27,10,$usrs[0],1,0,'C',1);

          $pdf->Cell(29,10,$deptos[0],1,0,'C',1);
        

        $pdf->Cell(27,10,$equipo['serie'],1,0,'C',1);
        $pdf->Cell(27,10,$equipo['marca'],1,0,'C',1);
        $pdf->Cell(27,10,$equipo['modelo'],1,0,'C',1);
        if(sizeof($sos)==0)
          $pdf->Cell(27,10,'N/A',1,0,'C',1);
        else
          $pdf->Cell(27,10,$sos[0],1,0,'C',1);
        $pdf->Cell(27,10,$equipo['garantia'],1,1,'C',1);
      }
    }else{
      if(sizeof($usrs)==0)
        $pdf->Cell(27,10,'N/A',1,0,'C',1);
      else
        $pdf->Cell(27,10,$usrs[0],1,0,'C',1);

      if(sizeof($deptos)>0){
        $pdf->Cell(29,10,$deptos[0],1,0,'C',1);
      }else{
        $pdf->Cell(29,10,'NA',1,0,'C',1);        
      }

      $pdf->Cell(27,10,$equipo['serie'],1,0,'C',1);
      $pdf->Cell(27,10,$equipo['marca'],1,0,'C',1);
      $pdf->Cell(27,10,$equipo['modelo'],1,0,'C',1);
      if(sizeof($sos)==0)
        $pdf->Cell(27,10,'N/A',1,0,'C',1);
      else
        $pdf->Cell(27,10,$sos[0],1,0,'C',1);
      $pdf->Cell(27,10,$equipo['garantia'],1,1,'C',1);

    }
  }

  $pdf->Output();
  ?>

 ?>
