<?php
include_once '../conexion.php';
include_once '../finsession.php';
	if(isset($_POST['opc']) && $_POST['opc'] == "agregar"){
		
		$errores = validateForm();

		if(sizeof($errores)==0){

			$nombre = "'".trim($_POST['nombre'])."'";

			$query = "INSERT INTO departamentos (nombre_depto) VALUES (".$nombre.")";
			$errores['success'][]= $con->query($query);
			$errores['success'][]=$query;
			
		}
		echo json_encode($errores);
	}elseif(isset($_POST['opc']) && $_POST['opc']=="editar"){
		$id = $_POST['id'];
		$errores = validateForm();
		if(sizeof($errores)==0){
			$nombre = "'".trim($_POST['nombre'])."'";
			$query = "UPDATE departamentos set nombre_depto =".$nombre ." WHERE id_Depto = ".$id;
			$errores['success'][]= $con->query($query);
			$errores['success'][]=$query;
		}
		echo json_encode($errores);
	}elseif(isset($_POST['opc']) && $_POST['opc']=="eliminar"){
		
		$id = $_POST['id'];
		$query = "UPDATE puestos set status_puesto = 0 where iddepto_puesto =".$id;
		$eliminar = $con->query($query);
		$query = "UPDATE departamentos set status_depto = 0 where id_depto =".$id;
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