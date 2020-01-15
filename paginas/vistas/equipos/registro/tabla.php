<?php

	// Zona horaria
		date_default_timezone_set('America/Mexico_City');
	//
	include_once '../../../controladores/finsession.php';
	include_once '../../../controladores/conexion.php';
  $usuario = $_SESSION['usuario'];
  $idsubmodulo = $_SESSION['idsubmodulo'];
	$permisosXUsuarioLoggeado = $con->query("Select ps.nombre from submodulos sub INNER JOIN permisos_submodulos ps ON ps.idsubmodulo = sub.id INNER JOIN permisos_submodulos_usuarios psu on psu.idpermiso = ps.id where psu.status <>0 and sub.status<>0 and sub.id=". $idsubmodulo." and idusuario = " . $usuario);
	$permisosActuales = array();
	while ($permiso = $permisosXUsuarioLoggeado->fetch_assoc()) {
		$permisosActuales[] = $permiso['nombre'];
	}
  $select = "SELECT e.status, e.id as id ,clas.nombre as clasificacion,e.serie, modelos.nombre as mod_nombre ,marcas.nombre as mar_nombre, fecha_max_garantia as garantia ";
  $from = " FROM equipos e INNER JOIN marcas ON marcas.id = e.id_marca INNER JOIN modelos ON modelos.id = e.id_modelo INNER JOIN clasificaciones clas on e.clasificacion = clas.id ";
  $where = " WHERE e.status<>0 ";
  if(isset($_POST['depto']) && !empty($_POST['depto']) ){
    $from = "  FROM equipos e INNER JOIN usuarios_equipo ue ON e.id = ue.id_equipo INNER JOIN usuarios usu ON usu.id_usu=ue.id_usuario  INNER JOIN marcas ON marcas.id = e.id_marca INNER JOIN modelos ON modelos.id = e.id_modelo INNER JOIN clasificaciones clas on e.clasificacion = clas.id ";
    $where .= "  AND ue.status<>0 AND depto_usu = ".$_POST['depto'];
  }
  if(isset($_POST['marca']) && !empty($_POST['marca']) ){
    $where .= " AND e.id_marca=".$_POST['marca'];
  }
  if(isset($_POST['modelos']) && !empty($_POST['modelos']) ){
    $where .= " AND e.id_modelo=".$_POST['modelos'];
  }
  if(isset($_POST['garantia']) && !empty($_POST['garantia']) ){
    $where .= " AND fecha_max_garantia is not null AND fecha_max_garantia<='".$_POST['garantia']."'";
  }
  $where.="  ORDER BY e.serie asc, e.id   ";
//  echo $select.$from.$where;
	$equipos = $con->query($select.$from.$where);
?>
<table class="table DataTable">
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Serie</th>
      <th>Modelo</th>
      <th>Marca</th>
      <th>Estatus</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php   while ($equipo = $equipos->fetch_assoc()) { ?>
      <tr>
        <td><?php echo $equipo['clasificacion']; ?></td>
        <td><?php echo $equipo['serie']; ?></td>
        <td><?php echo $equipo['mod_nombre']; ?></td>
        <td><?php echo $equipo['mar_nombre']; ?></td>
        <td>
          <?php
            if($equipo['status']==1){
              echo "Sin Asignar";
            }elseif($equipo['status']==2){
              echo "Asignado";
            }elseif($equipo['status']==3){
              echo "En reparación";
            }elseif($equipo['status']==4){
              echo "En Garantía";
            }elseif($equipo['status']==5){
              echo "Deshabilitado";
            }
          ?>
        </td>
        <td>
          <?php if(in_array("EDITAR", $permisosActuales)){ ?>
            <i class="fas fa-edit"  data-toggle="modal" data-target="#modal" onclick="editar(<?php echo $equipo['id']; ?>)"></i>
          <?php } ?>
          <?php if(in_array("ELIMINAR", $permisosActuales)){ ?>
            <i class="fa fa-trash" data-toggle="modal" data-target="#modal" onclick="opcionesEliminar(<?php echo $equipo['id']; ?>,'<?php echo $equipo["serie"] ?>')"></i>
          <?php } ?>
          <?php if(in_array("COMPONENTES", $permisosActuales)){ ?>
            <i class="fas fa-print" data-toggle="modal" data-target="#modal" onclick="componentes(<?php echo $equipo['id']; ?>)" ></i>
          <?php } ?>
          <?php if(in_array("SOFTWARE", $permisosActuales)){ ?>
            <i class="fas fa-code" data-toggle="modal" data-target="#modal" onclick="software(<?php echo $equipo['id']; ?>)" ></i>
          <?php } ?>
          <?php if(in_array("BITACORA", $permisosActuales)){ ?>
            <i class="fas fa-book-open" data-toggle="modal" data-target="#modal" onclick="bitacora(<?php echo $equipo['id']; ?>)" ></i>
          <?php } ?>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>
