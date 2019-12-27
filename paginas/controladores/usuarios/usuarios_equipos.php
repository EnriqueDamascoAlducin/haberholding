<?php
include_once '../conexion.php';
include_once '../finsession.php';
	if(isset($_POST['opc']) && $_POST['opc'] == "agregar"){
		
		$errores = validateForm();

		if(sizeof($errores)==0){

			$equipo = "'".trim($_POST['equipo'])."'";
			$id = trim($_POST['id']);
			$query = "INSERT INTO usuarios_equipo (id_equipo,id_usuario) VALUES (".$equipo.",".$id.")";
			$errores['success'][]= $con->query($query);
			$errores['success'][]=$query;
		}
		echo json_encode($errores);
	}elseif(isset($_POST['opc']) && $_POST['opc']=="eliminar"){
		
		$id = $_POST['id'];
		$query = "UPDATE usuarios_equipo set status = 0 where id =".$id;
		$eliminar = $con->query($query);
		if($eliminar>0){
			echo " Correctamente";
		}else{
			echo "Error";
		}
	}

	function validateForm(){
		$errores = array();
		if(!isset($_POST['equipo']) || empty(trim($_POST['equipo']))){
			$errores['campos'][] = "equipo";
		}
		return $errores;
	}
?>