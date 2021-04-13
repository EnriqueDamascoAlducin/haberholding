<?php
include_once '../conexion.php';
include_once '../finsession.php';

$query = "UPDATE permisos_submodulos_usuarios set status = 0 where idusuario = ".$_POST['usuario'] ." AND idpermiso in(Select id from permisos_submodulos WHERE idsubmodulo=".$_POST['submodulo'].")" ;
$eliminarPermisos = $con->query($query);
$queryPermisosExistentes = "SELECT COUNT(id) as total FROM permisos_submodulos_usuarios where idusuario= " .$_POST['usuario']. " AND idpermiso = ? ";
$preparePermisosExistentes = $con->prepare($queryPermisosExistentes);
foreach ($_POST as $campo => $valor) {
	if($campo!="usuario" && $campo!="submodulo"){
		foreach ($valor as $val) {
			$preparePermisosExistentes->bind_param('i',$val);
			$preparePermisosExistentes->execute();
			$respuesta = $preparePermisosExistentes->get_result();
			foreach ($respuesta as $resp) {
				if( $resp['total'] > 0 ) {
					$query = "UPDATE permisos_submodulos_usuarios set status = 1 WHERE idusuario= ".$_POST['usuario'] . " AND idpermiso = ".$val;
				}else{
					$query = "INSERT INTO permisos_submodulos_usuarios(idusuario,idpermiso) VALUES (".$_POST['usuario'].",".$val.")";
				}
			}
			$res = $con->query($query);
			if($res==0){
				echo "Fallo al registrar los permisos";
				die();
			}
		}
	}
}
echo "Permisos Registrados";
?>