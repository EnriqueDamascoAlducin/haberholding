<?php
include_once '../conexion.php';
include_once '../finsession.php';
	if(isset($_POST['opc']) && $_POST['opc'] == "agregar"){
		
		$errores = validateForm();

		if(sizeof($errores)==0){

			$nombre = "'".trim($_POST['nombre'])."'";
			$id = trim($_POST['id']);
			
			$query = "INSERT INTO modelos (nombre,id_marca) VALUES (".$nombre.",".$id.")";
			$errores['success'][]= $con->query($query);
			$errores['success'][]=$query;
			
		}
		echo json_encode($errores);
	}elseif(isset($_POST['opc']) && $_POST['opc']=="editar"){
		$errores = validateForm();
		if(sizeof($errores)==0){
			$nombre = "'".trim($_POST['nombre'])."'";
			$id_modelo = $_POST['id_modelo'];
			$query = "UPDATE modelos set nombre =".$nombre." WHERE id = ".$id_modelo;
			$errores['success'][]= $con->query($query);
			$errores['success'][]=$query;
		}
		echo json_encode($errores);
	}elseif(isset($_POST['opc']) && $_POST['opc']=="eliminar"){
		
		$id = $_POST['id'];
		$query = "UPDATE modelos set status = 0 where id =".$id;
		$eliminar = $con->query($query);
		if($eliminar>0){
			echo " Correctamente";
		}else{
			echo "Error";
		}
	}elseif(isset($_POST['opc']) && $_POST['opc']=="modelos"){
		
		$marca = $_POST['marca'];
		$query = "SELECT nombre,id FROM modelos where status<>0 and  id_marca = " .$marca;
		$modelos = $con->query($query);
		while ($modelo = $modelos->fetch_assoc()) {
			echo "<option value='".$modelo['id']."'>".$modelo['nombre']."</option>";
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