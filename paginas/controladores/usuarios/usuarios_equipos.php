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
			//Poner como equipo asignado en tabla equipos
			$QueryCambiarStatusEquipo = "UPDATE equipos SET status = 2 WHERE id = ".$equipo;
			$con->query($QueryCambiarStatusEquipo);

			//Guardar En Bitacora

			$nombreUsr = getUsuarioInfo($id);
			$valores = "'Asignar Equipo',".$equipo.",".$_SESSION['usuario'].", 'No. Empleado(". $_SESSION['noempleado_usu'] .") asigno el equipo a ".$nombreUsr."'";
			$insertarBitacora = "INSERT INTO bitacora_movimientos_equipo (movimiento,id_equipo,id_usu,comentario) VALUES ($valores)";
			$con->query($insertarBitacora);
		}
		echo json_encode($errores);
	}elseif(isset($_POST['opc']) && $_POST['opc']=="eliminar"){
		
		$id = $_POST['id'];
		$idusuario = $con->query("SELECT id_usuario FROM usuarios_equipo WHERE status = 1 AND id_equipo =".$id)->fetch_assoc(); 
		$nombreUsr = getUsuarioInfo($idusuario['id_usuario']);
		$query = "UPDATE usuarios_equipo set status = 0 where id_equipo =".$id;
		$eliminar = $con->query($query);
		if($eliminar>0){
			echo "Correctamente";
			$QueryCambiarStatusEquipo = "UPDATE equipos SET status = 1 WHERE id = ".$id;
			$con->query($QueryCambiarStatusEquipo);
			$valores = "'Desasignar Equipo',".$id.",".$_SESSION['usuario'].", 'No. Empleado(". $_SESSION['noempleado_usu'] .") desasigno el equipo a ".$nombreUsr."'";
			$insertarBitacora = "INSERT INTO bitacora_movimientos_equipo (movimiento,id_equipo,id_usu,comentario) VALUES ($valores)";
			$con->query($insertarBitacora);
		}else{
			echo "Error";
		}
	}elseif(isset($_POST['opc']) && $_POST['opc']=="infoequipo"){
		
		$equipo = $_POST['equipo'];
		$query = "SELECT e.serie, e.comentarios, e.id as eid, mo.nombre as modelo, ma.nombre as marca, c.nombre as cnombre FROM equipos e INNER JOIN clasificaciones c ON c.id = e.clasificacion INNER JOIN marcas ma ON e.id_marca = ma.id INNER JOIN modelos mo ON e.id_modelo = mo.id WHERE e.id =".$equipo;
		$equipoGral = $con->query($query)->fetch_assoc();

		$querySoftware  = "SELECT s.nombre FROM equipos_software es INNER JOIN software s ON s.id = es.id_componente WHERE s.status<>0 AND es.status<>0 AND id_equipo = " .$equipo;
		$softwares = $con->query($querySoftware);
		$queryHardware  = "SELECT s.nombre FROM equipos_componente es INNER JOIN componentes s ON s.id = es.id_componente WHERE s.status<>0 AND es.status<>0 AND id_equipo = " .$equipo;
		
		$hardwares = $con->query($queryHardware);
		//var_dump($softwares);

		$respuesta = "<table class='table'>";
			$respuesta .= "<thead>";
				$respuesta .= "<tr>";
					$respuesta .= "<th colspan='2' style='text-align:center'> <b>".$equipoGral['serie']."</b> (". $equipoGral['cnombre'].") -> ".$equipoGral['marca']. " - ".$equipoGral['modelo']  ."</th>";
				$respuesta .= "</tr>";
				$respuesta .= "<tr>";
					$respuesta .= "<th colspan='2' style='text-align:center'>".$equipoGral['comentarios']."</th>";
				$respuesta .= "</tr>";
			$respuesta .= "</thead>";
			$respuesta .= "<tbody>";
				$respuesta .= "<tr>";
					$respuesta .= "<th>Software</th>";
					$respuesta .= "<th>Hardware</th>";
				$respuesta .= "</tr>";
				$respuesta .= "<tr>";
					$respuesta .= "<td>";
						$respuesta .= "<ul>";
							while($software = $softwares->fetch_assoc()){
								$respuesta .= "<li>".$software['nombre']."</li>";
							}
						$respuesta .= "</ul>";
					$respuesta .="</td>";

					$respuesta .= "<td>";
						$respuesta .= "<ul>";
							while($hardware = $hardwares->fetch_assoc()){
								$respuesta .= "<li>".$hardware['nombre']."</li>";
							}
						$respuesta .= "</ul>";
					$respuesta .="</td>";
				$respuesta .= "</tr>";


			$respuesta .= "</tbody>";
		$respuesta .= "</table>";

		echo $respuesta;
	}elseif(isset($_POST['opc']) && $_POST['opc']=="infoequipoAsignado"){
		
		$equipo = $_POST['equipo'];
		$query = "SELECT e.serie, e.comentarios, e.id as eid, mo.nombre as modelo, ma.nombre as marca, c.nombre as cnombre FROM equipos e INNER JOIN clasificaciones c ON c.id = e.clasificacion INNER JOIN marcas ma ON e.id_marca = ma.id INNER JOIN modelos mo ON e.id_modelo = mo.id WHERE e.id =".$equipo;
		$equipoGral = $con->query($query)->fetch_assoc();

		$querySoftware  = "SELECT s.nombre FROM equipos_software es INNER JOIN software s ON s.id = es.id_componente WHERE s.status<>0 AND es.status<>0 AND id_equipo = " .$equipo;
		$softwares = $con->query($querySoftware);
		$queryHardware  = "SELECT s.nombre FROM equipos_componente es INNER JOIN componentes s ON s.id = es.id_componente WHERE s.status<>0 AND es.status<>0 AND id_equipo = " .$equipo;
		
		$hardwares = $con->query($queryHardware);
		//var_dump($softwares);

		$respuesta = "<table class='table'>";
			$respuesta .= "<thead>";
				$respuesta .= "<tr>";
					$respuesta .= "<th colspan='2' style='text-align:center'> <b>".$equipoGral['serie']."</b> (". $equipoGral['cnombre'].") -> ".$equipoGral['marca']. " - ".$equipoGral['modelo']  ."</th>";
					$respuesta .= "<th><button class='btn btn-danger' onclick='desasignarEquipo(".$equipoGral['eid'].")' ><i class='fa fa-trash'></i></button></th>";
				$respuesta .= "</tr>";
				$respuesta .= "<tr>";
					$respuesta .= "<th colspan='3' style='text-align:center'>".$equipoGral['comentarios']."</th>";
				$respuesta .= "</tr>";
			$respuesta .= "</thead>";
			$respuesta .= "<tbody>";
				$respuesta .= "<tr>";
					$respuesta .= "<th>Software</th>";
					$respuesta .= "<th>Hardware</th>";
				$respuesta .= "</tr>";
				$respuesta .= "<tr>";
					$respuesta .= "<td>";
						$respuesta .= "<ul>";
							while($software = $softwares->fetch_assoc()){
								$respuesta .= "<li>".$software['nombre']."</li>";
							}
						$respuesta .= "</ul>";
					$respuesta .="</td>";

					$respuesta .= "<td>";
						$respuesta .= "<ul>";
							while($hardware = $hardwares->fetch_assoc()){
								$respuesta .= "<li>".$hardware['nombre']."</li>";
							}
						$respuesta .= "</ul>";
					$respuesta .="</td>";
				$respuesta .= "</tr>";


			$respuesta .= "</tbody>";
		$respuesta .= "</table>";

		echo $respuesta;
	}

	function validateForm(){
		$errores = array();
		if(!isset($_POST['equipo']) || empty(trim($_POST['equipo']))){
			$errores['campos'][] = "equipo";
		}
		return $errores;
	}
	function getUsuarioInfo($id){
		global $con;

		$infoUsr = $con->query("SELECT CONCAT(IFNULL(nombre_usu,''),' ',IFNULL(apellidop_usu,''),'(',noempleado_usu,')') as usuario FROM usuarios WHERE id_usu= ".$id)->fetch_assoc();
		return $infoUsr['usuario'];
	}
?>