<?php
include_once '../conexion.php';
include_once '../finsession.php';
	if(isset($_POST['opc']) && $_POST['opc'] == "agregar"){
		
		$errores = validateForm();

		if(sizeof($errores)==0){

			$clasificacion = "'".trim($_POST['clasificacion'])."'";
			$id = trim($_POST['id']);
			$query = "INSERT INTO equipos_componente (id_equipo,id_componente) VALUES (".$id.",".$clasificacion.")";
			$errores['success'][]= $con->query($query);
			$errores['success'][]=$query;
		}
		echo json_encode($errores);
	}elseif(isset($_POST['opc']) && $_POST['opc']=="eliminar"){
		
		$id = $_POST['id'];
		$query = "UPDATE equipos_componente set status = 0 where id =".$id;
		$eliminar = $con->query($query);
		if($eliminar>0){
			echo " Correctamente";
		}else{
			echo "Error";
		}
	}

	function validateForm(){
		$errores = array();
		if(!isset($_POST['clasificacion']) || empty(trim($_POST['clasificacion']))){
			$errores['campos'][] = "clasificacion";
		}
		return $errores;
	}
?>