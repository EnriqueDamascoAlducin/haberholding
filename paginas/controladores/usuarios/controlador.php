<?php
include_once '../conexion.php';
include_once '../finsession.php';
	if(isset($_POST['opc']) && $_POST['opc'] == "agregar"){
		
		$errores = validateForm();

		if(!isset($_POST['contrasena']) || empty(trim($_POST['contrasena']))){
			$errores['campos'][] = "contrasena";
		}
		if(!isset($_POST['confirmarcontrasena']) || empty($_POST['confirmarcontrasena'])){
			$errores['campos'][] = "confirmarcontrasena";
		}
		if(($_POST['contrasena']) != ($_POST['confirmarcontrasena'])) {
			$errores['contrasena'][] = "true";
		}
		if(sizeof($errores)==0){

			if(empty(trim($_POST['apellidom']))){
				$apellidom = "null";
			}else{
				$apellidom = "'".trim($_POST['apellidom'])."'"; 
			}
			if(empty(trim($_POST['extension']))){
				$extension = "null";
			}else{
				$extension = "'".$_POST['extension']."'"; 
			}
			$noEmpleado = trim($_POST['noempleado']);
			$nombre = "'".trim($_POST['nombre'])."'";
			$apellidop = "'".trim($_POST['apellidop'])."'";
			$sexo = trim($_POST['sexo']);
			$correo = "'".trim($_POST['correo'])."'";
			$departamento = trim($_POST['departamento']);
			$puesto = trim($_POST['puesto']);
			$ingreso = "'".trim($_POST['ingreso'])."'";
			$contrasena = "'".md5($_POST['contrasena'])."'";


			$valores = $nombre.",".$apellidop.",".$apellidom.",".$sexo.",".$correo.",".$noEmpleado.",".$departamento.",".$puesto.",".$extension.",".$contrasena.",".$ingreso;
			$query = "INSERT INTO usuarios (nombre_usu,apellidop_usu,apellidom_usu,sexo_usu,correo_usu,noempleado_usu,depto_usu,puesto_usu,extension_usu,contrasena_usu,ingreso_usu) VALUES (".$valores.")";
			$errores['success'][]= $con->query($query);
			$errores['success'][]=$query;
			
		}
		echo json_encode($errores);
	}elseif(isset($_POST['opc']) && $_POST['opc']=="editar"){
		$idusu = $_POST['id'];
		$errores = validateForm();
		if(isset($_POST['contrasena']) && !empty(trim($_POST['contrasena']))){

			if(!isset($_POST['contrasena']) || empty(trim($_POST['contrasena']))){
				$errores['campos'][] = "contrasena";
			}
			if(!isset($_POST['confirmarcontrasena']) || empty($_POST['confirmarcontrasena'])){
				$errores['campos'][] = "confirmarcontrasena";
			}
			if(($_POST['contrasena']) != ($_POST['confirmarcontrasena'])) {
				$errores['contrasena'][] = "true";
			}
			if(sizeof($errores)==0){
				if(empty(trim($_POST['apellidom']))){
					$apellidom = "null";
				}else{
					$apellidom = "'".trim($_POST['apellidom'])."'"; 
				}
				if(empty(trim($_POST['extension']))){
					$extension = "null";
				}else{
					$extension = "'".$_POST['extension']."'"; 
				}
				$noEmpleado = trim($_POST['noempleado']);
				$nombre = "'".trim($_POST['nombre'])."'";
				$apellidop = "'".trim($_POST['apellidop'])."'";
				$sexo = trim($_POST['sexo']);
				$correo = "'".trim($_POST['correo'])."'";
				$departamento = trim($_POST['departamento']);
				$puesto = trim($_POST['puesto']);
				$ingreso = "'".trim($_POST['ingreso'])."'";
				$contrasena = "'".md5($_POST['contrasena'])."'";
				$query = "UPDATE usuarios SET noempleado_usu = ". $noEmpleado.", nombre_usu=".$nombre.",apellidop_usu=".$apellidop.",apellidom_usu=".$apellidom.",sexo_usu=".$sexo.",correo_usu=".$correo.",depto_usu=".$departamento.",puesto_usu=".$puesto.",extension_usu=".$extension.",contrasena_usu=".$contrasena.",ingreso_usu=".$ingreso." WHERE id_usu = ".$idusu;
			}
		}else{
			if(sizeof($errores)==0){
				if(empty(trim($_POST['apellidom']))){
					$apellidom = "null";
				}else{
					$apellidom = "'".trim($_POST['apellidom'])."'"; 
				}
				if(empty(trim($_POST['extension']))){
					$extension = "null";
				}else{
					$extension = "'".$_POST['extension']."'"; 
				}
				$noEmpleado = trim($_POST['noempleado']);
				$nombre = "'".trim($_POST['nombre'])."'";
				$apellidop = "'".trim($_POST['apellidop'])."'";
				$sexo = trim($_POST['sexo']);
				$correo = "'".trim($_POST['correo'])."'";
				$departamento = trim($_POST['departamento']);
				$puesto = trim($_POST['puesto']);
				$ingreso = "'".trim($_POST['ingreso'])."'";
				$query = "UPDATE usuarios SET noempleado_usu = ". $noEmpleado.", nombre_usu=".$nombre.",apellidop_usu=".$apellidop.",apellidom_usu=".$apellidom.",sexo_usu=".$sexo.",correo_usu=".$correo.",depto_usu=".$departamento.",puesto_usu=".$puesto.",extension_usu=".$extension.",ingreso_usu=".$ingreso." WHERE id_usu = ".$idusu;
			}

		}
		if(sizeof($errores)==0){
			$errores['success'][]= $con->query($query);
			$errores['success'][]=$query;
		}
		echo json_encode($errores);
	}elseif(isset($_POST['opc']) && $_POST['opc']=="eliminar"){
		$id = $_POST['usuario'];
		$query = "UPDATE usuarios set status_usu = 0 where id_usu =".$id;
		$eliminar = $con->query($query);
		if($eliminar>0){
			echo " Correctamente";
		}else{
			echo "Error";
		}
	}elseif(isset($_POST['opc']) && $_POST['opc'] == "departamentos"){
		$query = "Select id_puesto as id, nombre_puesto as text from puestos where status_puesto and  iddepto_puesto = ".$_POST['depto'];
		//echo $query;
		$deptos = $con->query($query );
		$opciones = "<option value=''>Selecciona un Puesto</option>";
		while( $depto = $deptos->fetch_assoc()){
			$opciones .= "<option value='". $depto['id'] ."' id='option_".$depto['id']."'>". $depto['text'] ."</option>";

		}
		echo $opciones;
	}

	function validateForm(){
		$errores = array();
		if(!isset($_POST['noempleado']) || empty(trim($_POST['noempleado']))){
			$errores['campos'][] = "noempleado";
		}
		if(!isset($_POST['nombre']) || empty(trim($_POST['nombre'])))	{
			$errores['campos'][] = "nombre";
		}
		if(!isset($_POST['apellidop']) || empty(trim($_POST['apellidop']))) {
			$errores['campos'][] = "apellidop";
		}
		if(!isset($_POST['sexo']) || empty($_POST['sexo'])){
			$errores['campos'][] = "sexo";
		}
		if(!isset($_POST['correo']) || empty(trim($_POST['correo'])) || !filter_var($_POST['correo'],FILTER_VALIDATE_EMAIL)){
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
		return $errores;
	}
	//print_r($_POST);
?>