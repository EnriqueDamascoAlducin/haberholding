<?php

	include_once 'conexion.php';
	$noEmpleado = $_POST['empleado'];
	$contrasena = $_POST['contrasena'];
	$usuario = $con->query("Select * from usuarios where noempleado_usu =" . $noEmpleado. " AND contrasena_usu ='".md5($contrasena)."' AND status_usu<>0");
	if($usuario->num_rows>0){
		while ($usu = $usuario->fetch_assoc()){
			echo "Bienvenido ". $usu['nombre_usu'];
			/*
				Variables de Sessión con datos del usuario loggeado
			*/
			session_start();
			$_SESSION['usuario'] = $usu['id_usu'];
			$_SESSION['nombre_usu'] = $usu['nombre_usu'];
			$_SESSION['apellidop_usu'] = $usu['apellidop_usu'];
			$_SESSION['apellidom_usu'] = $usu['apellidom_usu'];
			$_SESSION['sexo_usu'] = $usu['sexo_usu'];
			$_SESSION['correo_usu'] = $usu['correo_usu'];
			$_SESSION['noempleado_usu'] = $usu['noempleado_usu'];
			$_SESSION['depto_usu'] = $usu['depto_usu'];
			$_SESSION['puesto_usu'] = $usu['puesto_usu'];
			$_SESSION['extension_usu'] = $usu['extension_usu'];
			$_SESSION['contrasena_usu'] = $usu['contrasena_usu'];
			$_SESSION['ingreso_usu'] = $usu['ingreso_usu'];
			/*Limite de tiempo 60 segundos x 15 que son los minutos que durara la sessión*/
			$_SESSION['max-tiempo']=60*15;
			$_SESSION[ 'ULTIMA_ACTIVIDAD' ] = time();
		}
	}else{
		echo "Error";
	}
?>
