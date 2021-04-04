<?php
include_once '../conexion.php';
include_once '../finsession.php';
	if(isset($_POST['opc']) && $_POST['opc'] == "agregar"){
		
		$errores = validateForm();

		if(sizeof($errores)==0){

			$nombre = "'".trim($_POST['nombre'])."'";
			$tipo = $_POST['tipo'];
			$query = "INSERT INTO clasificaciones (nombre,tipo) VALUES (".$nombre.",".$tipo.")";
			$errores['success'][]= $con->query($query);
			$errores['success'][]=$query;
			
		}
		echo json_encode($errores);
	}elseif(isset($_POST['opc']) && $_POST['opc']=="editar"){
		$id = $_POST['id'];
		$errores = validateForm();
		if(sizeof($errores)==0){
			$nombre = "'".trim($_POST['nombre'])."'";
			$tipo = $_POST['tipo'];
			$query = "UPDATE clasificaciones set nombre =".$nombre .", tipo = ".$tipo." WHERE id = ".$id;
			$errores['success'][]= $con->query($query);
			$errores['success'][]=$query;
		}
		echo json_encode($errores);
	}elseif(isset($_POST['opc']) && $_POST['opc']=="eliminar"){
		
		$id = $_POST['id'];
		$query = "UPDATE clasificaciones set status = 0 where id =".$id;
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
		
		return $errores;
	}
?>