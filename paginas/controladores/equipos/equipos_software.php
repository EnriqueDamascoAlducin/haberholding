<?php
include_once '../conexion.php';
include_once '../finsession.php';
	if(isset($_POST['opc']) && $_POST['opc'] == "agregar"){
		
		$errores = validateForm();

		if(sizeof($errores)==0){

			$clasificacion = "'".trim($_POST['clasificacion'])."'";
			$id = ($_POST['id']);
			$query = "INSERT INTO equipos_software (id_componente,id_equipo) VALUES (".$clasificacion.",".$id.")";
			$errores['success'][]= $con->query($query);
			$errores['success'][]=$query;
			///Registrar en BITACORA
			$software=getSoftwareInfo($clasificacion);
			$valores = "'Añadir Software',".$id.",".$_SESSION['usuario'].", 'No. Empleado(". $_SESSION['noempleado_usu'] .") le añadio el software ".$software."'";
			$insertarBitacora = "INSERT INTO bitacora_movimientos_equipo (movimiento,id_equipo,id_usu,comentario) VALUES ($valores)";
			$con->query($insertarBitacora);
		}
		echo json_encode($errores);
	}elseif(isset($_POST['opc']) && $_POST['opc']=="eliminar"){
		
		$id = $_POST['id'];
		$id_componente = $con->query("SELECT id_componente,id_equipo FROM equipos_software WHERE id=".$id)->fetch_assoc();
		$query = "UPDATE equipos_software set status = 0 where id =".$id;
		$eliminar = $con->query($query);
		if($eliminar>0){
			echo " Correctamente";
			///Registrar en BITACORA
			$componente=getSoftwareInfo($id_componente['id_componente']);
			$valores = "'Quitar Software',".$id_componente['id_equipo'].",".$_SESSION['usuario'].", 'No. Empleado(". $_SESSION['noempleado_usu'] .") le desinstaló ".$componente."'";
			$insertarBitacora = "INSERT INTO bitacora_movimientos_equipo (movimiento,id_equipo,id_usu,comentario) VALUES ($valores)";
			$con->query($insertarBitacora);
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

	function getSoftwareInfo($id){
		global $con;
		$software = $con->query("SELECT nombre FROM software WHERE id= ".$id)->fetch_assoc();
		return $software['nombre'];
	}
?>