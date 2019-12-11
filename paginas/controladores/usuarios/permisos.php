<?php
include_once '../conexion.php';
include_once '../finsession.php';

$query = "UPDATE permisos_usuarios set status_pu = 0 where usuario_pu = ".$_POST['usuario'] ." AND permiso_pu in(Select id_permiso from permisos_modulos WHERE modulo_permiso=".$_POST['modulo'].")" ;

$eliminarPermisos = $con->query($query);
$queryPermisosExistentes = "SELECT COUNT(id_pu) as total FROM permisos_usuarios where usuario_pu= " .$_POST['usuario']. " AND permiso_pu = ?";
$preparePermisosExistentes = $con->prepare($queryPermisosExistentes);
foreach ($_POST as $campo => $valor) {
	if($campo!="usuario" && $campo!="modulo"){
		foreach ($valor as $val) {
			echo $val;
			$preparePermisosExistentes->bind_param('i',$val);
			$preparePermisosExistentes->execute();
			$respuesta = $preparePermisosExistentes->get_result();
			foreach ($respuesta as $resp) {
				if( $resp['total'] > 0 ) {
					$query = "UPDATE permisos_usuarios set status_pu = 1 WHERE usuario_pu= ".$_POST['usuario'] . " AND permiso_pu = ".$val;
				}else{
					$query = "INSERT INTO permisos_usuarios(usuario_pu,permiso_pu) VALUES (".$_POST['usuario'].",".$val.")";
				}
			}
			echo $con->query($query);
		}
	}
}

?>