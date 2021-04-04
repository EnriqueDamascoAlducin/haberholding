<?php
include_once '../conexion.php';
include_once '../finsession.php';
	if(isset($_POST['opc']) && $_POST['opc'] == "agregar"){
		
		$errores = validateForm();

		if(sizeof($errores)==0){

			$nombre = "'".trim($_POST['nombre'])."'";
			$id = $_POST['id'];
			$query = "INSERT INTO puestos (nombre_puesto,iddepto_puesto) VALUES (".$nombre.",".$id.")";
			$errores['success'][]= $con->query($query);
			$errores['success'][]=$query;
			
		}
		echo json_encode($errores);
	}elseif(isset($_POST['opc']) && $_POST['opc']=="editar"){
		$errores = validateForm();
		if(sizeof($errores)==0){
			$nombre = "'".trim($_POST['nombre'])."'";
			$id = $_POST['id'];
			$id_puesto = $_POST['id_puesto'];
			$query = "UPDATE puestos set nombre_puesto =".$nombre ." WHERE id_puesto = ".$id_puesto;
			$errores['success'][]= $con->query($query);
			$errores['success'][]=$query;
		}
		echo json_encode($errores);
	}elseif(isset($_POST['opc']) && $_POST['opc']=="eliminar"){
		
		$id = $_POST['id'];
		$query = "UPDATE puestos set status_puesto = 0 where id_puesto =".$id;
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