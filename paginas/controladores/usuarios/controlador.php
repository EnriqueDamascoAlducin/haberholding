<?php
include_once '../conexion.php';
include_once '../finsession.php';
	if(isset($_POST['opc']) && $_POST['opc'] == "agregar"){
		if(!isset($_POST['noempleado']) || empty(trim($_POST['noempleado']))){
			$errores['campos'][] = "noempleado";
		}
		if(!isset($_POST['nombre']) || empty(trim($_POST['nombre'])))	{
			$errores['campos'][] = "nombre";
		}
		if(!isset($_POST['apellidop']) || empty($_POST['apellidop'])){
			$errores['campos'][] = "apellidop";
		}
		if(!isset($_POST['sexo']) || empty($_POST['sexo'])){
			$errores['campos'][] = "sexo";
		}
		if(!isset($_POST['correo']) || empty($_POST['correo']) || !filter_var($_POST['correo'],FILTER_VALIDATE_EMAIL)){
			$errores['campos'][] = "correo";
		}
		if(!isset($_POST['departamento']) || empty($_POST['departamento'])){
			$errores['campos'][] = "departamento";
		}
		if(!isset($_POST['puesto']) || empty($_POST['puesto'])){
			$errores['campos'][] = "puesto";
		}
		if(!isset($_POST['ingreso']) || empty($_POST['ingreso'])){
			$errores['campos'][] = "ingreso";
		}
		if(!isset($_POST['contrasena']) || empty($_POST['contrasena'])){
			$errores['campos'][] = "contrasena";
		}
		if(!isset($_POST['confirmarcontrasena']) || empty($_POST['confirmarcontrasena'])){
			$errores['campos'][] = "confirmarcontrasena";
		}
		if(empty(trim($_POST['apellidom']))){
			$_POST['apellidom'] == "null";
		}
		if(empty(trim($_POST['extension']))){
			$_POST['extension'] == "null";
		}
		if(!isset($errores)){
			if(($_POST['contrasena']) != ($_POST['confirmarcontrasena'])) {
				$errores['contrasena'][] = "true";
			}else{
				$query = "INSERT INTO usuarios (nombre_usu,apellidop_usu,apellidom_usu,sexo_usu,correo_usu,noempleado_usu,depto_usu,puesto_usu,extension_usu,contrasena_usu,ingreso_usu) VALUES ";
				//$errores['success'][]= $con->query();
				$errores['success'][]=$query;
			}
		}
		echo json_encode($errores);
	}elseif(isset($_POST['opc']) && $_POST['opc']=="editar"){

	}elseif(isset($_POST['opc']) && $_POST['opc']=="eliminar"){

	}elseif(isset($_POST['opc']) && $_POST['opc'] == "departamentos"){
		$query = "Select id_puesto as id, nombre_puesto as text from puestos where status_puesto and  iddepto_puesto = ".$_POST['depto'];
		//echo $query;
		$deptos = $con->query($query );
		$opciones = "<option value=''>Selecciona un Puesto</option>";
		while( $depto = $deptos->fetch_assoc()){
			$opciones .= "<option value='". $depto['id'] ."'>". $depto['text'] ."</option>";

		}
		echo $opciones;
	}
	//print_r($_POST);
?>