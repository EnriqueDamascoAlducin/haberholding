<?php
include_once '../conexion.php';
include_once '../finsession.php';
	if(isset($_POST['opc']) && $_POST['opc'] == "agregar"){
		
		$errores = validateForm();

		if(sizeof($errores)==0){

			$nombre = "'".trim($_POST['nombre'])."'";
			$clasificacion = "'".trim($_POST['clasificacion'])."'";
			$fecha_max_garantia =trim($_POST['fecha_max_garantia']);
			if($fecha_max_garantia==""){
				$fecha_max_garantia = "null";
			}else{
				$fecha_max_garantia ="'".trim($_POST['fecha_max_garantia'])."'";
			}
			$id_marca = "'".trim($_POST['id_marca'])."'";
			$id_modelo = "'".trim($_POST['id_modelo'])."'";
			$descripcion = "'".trim($_POST['descripcion'])."'";
			$valores = $nombre.",".$clasificacion.",".$descripcion.",".$fecha_max_garantia.",".$id_marca.",".$id_modelo;
			$query = "INSERT INTO componentes (nombre,id_clasificacion,descripcion,fecha_max_garantia,id_marca,id_modelo) VALUES (".$valores.")";
			$errores['success'][]= $con->query($query);
			$errores['success'][]=$query;
			
		}
		echo json_encode($errores);
	}elseif(isset($_POST['opc']) && $_POST['opc']=="editar"){
		$errores = validateForm();
		if(sizeof($errores)==0){
			$nombre = "'".trim($_POST['nombre'])."'";
			$clasificacion = "'".trim($_POST['clasificacion'])."'";
			$fecha_max_garantia =trim($_POST['fecha_max_garantia']);
			if($fecha_max_garantia==""){
				$fecha_max_garantia = "null";
			}else{
				$fecha_max_garantia ="'".trim($_POST['fecha_max_garantia'])."'";
			}
			$id_marca = "'".trim($_POST['id_marca'])."'";
			$id_modelo = "'".trim($_POST['id_modelo'])."'";
			$descripcion = "'".trim($_POST['descripcion'])."'";
			$id = $_POST['id'];
			$query = "UPDATE componentes set nombre =".$nombre ." , id_clasificacion=".$clasificacion.", descripcion=".$descripcion.", fecha_max_garantia=".$fecha_max_garantia.", id_marca=".$id_marca.", id_modelo = ".$id_modelo." WHERE id = ".$id;
			$errores['success'][]= $con->query($query);
			$errores['success'][]=$query;
		}
		echo json_encode($errores);
	}elseif(isset($_POST['opc']) && $_POST['opc']=="eliminar"){
		
		$id = $_POST['id'];
		$query = "UPDATE componentes set status = 0 where id =".$id;
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
		if(!isset($_POST['clasificacion']) || empty(trim($_POST['clasificacion']))){
			$errores['campos'][] = "clasificacion";
		}
		if(!isset($_POST['id_marca']) || empty(trim($_POST['id_marca']))){
			$errores['campos'][] = "id_marca";
		}
		if(!isset($_POST['id_modelo']) || empty(trim($_POST['id_modelo']))){
			$errores['campos'][] = "id_modelo";
		}
		if(!isset($_POST['descripcion']) || empty(trim($_POST['descripcion']))){
			$errores['campos'][] = "descripcion";
		}
		return $errores;
	}
?>