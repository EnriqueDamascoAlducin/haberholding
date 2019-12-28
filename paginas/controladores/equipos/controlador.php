<?php
include_once '../conexion.php';
include_once '../finsession.php';
	if(isset($_POST['opc']) && $_POST['opc'] == "agregar"){
		
		$errores = validateForm();

		if(sizeof($errores)==0){

			$serie = "'".trim($_POST['serie'])."'";
			$clasificacion = "'".trim($_POST['clasificacion'])."'";
			$id_marca = "'".trim($_POST['id_marca'])."'";
			$id_modelo = trim($_POST['id_modelo']);
			if($_POST['fecha_max_garantia'] == ""){
				$garantia = "null";
			}else{
				$garantia = "'".$_POST['fecha_max_garantia']."'";
			}
			$comentarios = "'".trim($_POST['comentarios'])."'";


			$valores = $serie.",".$clasificacion.",".$id_marca.",".$id_modelo.",".$garantia.",".$comentarios;
			$query = "INSERT INTO equipos (serie,clasificacion,id_marca,id_modelo,fecha_max_garantia,comentarios) VALUES (".$valores.")";
			$errores['success'][]= $con->query($query);
			$errores['success'][]=$query;
			
		}
		echo json_encode($errores);
	}elseif(isset($_POST['opc']) && $_POST['opc']=="editar"){
		

		$errores =validateForm();
		if(sizeof($errores)==0){
			$id = $_POST['id'];
			$serie = "'".trim($_POST['serie'])."'";
			$clasificacion = "'".trim($_POST['clasificacion'])."'";
			$id_marca = "'".trim($_POST['id_marca'])."'";
			$id_modelo = trim($_POST['id_modelo']);
			if($_POST['fecha_max_garantia'] == ""){
				$garantia = "null";
			}else{
				$garantia = "'".$_POST['fecha_max_garantia']."'";
			}
			$comentarios = "'".trim($_POST['comentarios'])."'";



			$query = "UPDATE equipos set serie =$serie, clasificacion =$clasificacion, id_marca = $id_marca, id_modelo = $id_modelo, fecha_max_garantia = $garantia, comentarios = $comentarios  WHERE id = $id";
			$errores['success'][]= $con->query($query);
			$errores['success'][]=$query;
		}
		echo json_encode($errores);
	}elseif(isset($_POST['opc']) && $_POST['opc']=="eliminar"){
		$id = $_POST['id'];
		$status = $_POST['status'];
		$query = "UPDATE equipos set status = ".$status." where id =".$id;
		$eliminar = $con->query($query);
		if($eliminar>0){
			echo " Correctamente";
			///Registrar en BITACORA
			$Nomequipo=$_POST['nombre'];
			if($status == 0){
				$valores = "'Elimino Equipo',".$id.",".$_SESSION['usuario'].", 'No. Empleado(". $_SESSION['noempleado_usu'] .") Elimino el Equipo ".$Nomequipo."'";
			}elseif($status == 4){
				$valores = "'Envio a Garantía',".$id.",".$_SESSION['usuario'].", 'No. Empleado(". $_SESSION['noempleado_usu'] .") Envió a Garantía el Equipo ".$Nomequipo."'";
			}elseif($status == 3){
				$valores = "'Envio a Reparación',".$id.",".$_SESSION['usuario'].", 'No. Empleado(". $_SESSION['noempleado_usu'] .") Envió a Reparación el Equipo ".$Nomequipo."'";
			}
			$insertarBitacora = "INSERT INTO bitacora_movimientos_equipo (movimiento,id_equipo,id_usu,comentario) VALUES ($valores)";
			$con->query($insertarBitacora);
		}else{
			echo "Error";
		}
	}
	function validateForm(){
		$errores = array();
		if(!isset($_POST['serie']) || empty(trim($_POST['serie']))){
			$errores['campos'][] = "serie";
		}
		if(!isset($_POST['clasificacion']) || empty(trim($_POST['clasificacion'])))	{
			$errores['campos'][] = "clasificacion";
		}
		if(!isset($_POST['id_marca']) || empty(trim($_POST['id_marca']))) {
			$errores['campos'][] = "id_marca";
		}
		if(!isset($_POST['id_modelo']) || empty($_POST['id_modelo'])){
			$errores['campos'][] = "id_modelo";
		}
		if(!isset($_POST['comentarios']) || empty($_POST['comentarios'])){
			$errores['campos'][] = "comentarios";
		}
		return $errores;
	}
	//print_r($_POST);
?>