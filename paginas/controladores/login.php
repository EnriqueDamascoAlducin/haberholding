<?php
	include_once 'conexion.php';
	$noEmpleado = $_POST['empleado'];
	$contrasena = $_POST['contrasena'];
	$usuario = $con->query("Select * from usuarios where noempleado_usu =" . $noEmpleado. " AND contrasena_usu ='".md5($contrasena)."' AND status_usu<>0");
	if($usuario->num_rows>0){
		while ($usu = $usuario->fetch_assoc()){
			echo "Bienvenido ". $usu['nombre_usu'];
		}
	}else{
		echo "Error";
	}
?>