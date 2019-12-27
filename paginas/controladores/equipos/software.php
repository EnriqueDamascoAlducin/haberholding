<?php
include_once '../conexion.php';
include_once '../finsession.php';
	if(isset($_POST['opc']) && $_POST['opc'] == "agregar"){
		
		$errores = validateForm();

		if(sizeof($errores)==0){

			$nombre = "'".trim($_POST['nombre'])."'";
			$clasificacion = "'".trim($_POST['clasificacion'])."'";
			$fecha_max_licencia =trim($_POST['fecha_max_licencia']);
			if($fecha_max_licencia==""){
				$fecha_max_licencia = "null";
			}else{
				$fecha_max_licencia ="'".trim($_POST['fecha_max_licencia'])."'";
			}
			$version = "'".trim($_POST['version'])."'";
			$valores = $nombre.",".$clasificacion.",".$fecha_max_licencia.",".$version;
			$query = "INSERT INTO software (nombre,id_clasificacion,fecha_max_licencia,version) VALUES (".$valores.")";
			$errores['success'][]= $con->query($query);
			$errores['success'][]=$query;
			
		}
		echo json_encode($errores);
	}elseif(isset($_POST['opc']) && $_POST['opc']=="editar"){
		$errores = validateForm();
		if(sizeof($errores)==0){
			
			$nombre = "'".trim($_POST['nombre'])."'";
			$clasificacion = "'".trim($_POST['clasificacion'])."'";
			$fecha_max_licencia =trim($_POST['fecha_max_licencia']);
			if($fecha_max_licencia==""){
				$fecha_max_licencia = "null";
			}else{
				$fecha_max_licencia ="'".trim($_POST['fecha_max_licencia'])."'";
			}
			$version = "'".trim($_POST['version'])."'";



			$id = $_POST['id'];
			$query = "UPDATE software set nombre =".$nombre ." , id_clasificacion=".$clasificacion.", version=".$version.", fecha_max_licencia=".$fecha_max_licencia." WHERE id = ".$id;
			$errores['success'][]= $con->query($query);
			$errores['success'][]=$query;
		}
		echo json_encode($errores);
	}elseif(isset($_POST['opc']) && $_POST['opc']=="eliminar"){
		
		$id = $_POST['id'];
		$query = "UPDATE software set status = 0 where id =".$id;
		$eliminar = $con->query($query);
		if($eliminar>0){
			echo " Correctamente";
		}else{
			echo "Error";
		}
	
	}
	function validateForm(){
		$errores = array();
		if(!isset($_POST['nombre']) || empty(trim($_POST['nombre']))){
			$errores['campos'][] = "nombre";
		}
		if(!isset($_POST['clasificacion']) || empty(trim($_POST['clasificacion']))){
			$errores['campos'][] = "clasificacion";
		}
		if(!isset($_POST['version']) || empty(trim($_POST['version']))){
			$errores['campos'][] = "version";
		}
		return $errores;
	}
?>