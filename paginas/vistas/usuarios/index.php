<?php  

	// Zona horaria
		date_default_timezone_set('America/Mexico_City');
	//
	include_once '../../controladores/finsession.php';
	include_once '../../controladores/conexion.php';
	$nombreModulo = $_POST['nombre'];
	$rutaModulo = $_POST['ruta'];
	$idModulo = $_POST['id'];
	$usuario = $_SESSION['usuario'];
	$usuarios = $con->query("Select id_usu as id, CONCAT(IFNULL(nombre_usu,''),' ',IFNULL(apellidop_usu,''), ' ',IFNULL(apellidom_usu,'')) as nombre, nombre_depto, nombre_puesto,ingreso_usu,noempleado_usu as noempleado FROM usuarios u Inner join departamentos on u.depto_usu = id_depto INNER JOIN puestos on u.puesto_usu = id_puesto WHERE status_usu<>0");
	$permisosXUsuarioLoggeado = $con->query("Select nombre_permiso from permisos_modulos pm INNER JOIN permisos_usuarios pu on pu.permiso_pu = pm.id_permiso where pu.status_pu <>0 and pm.status_permiso<>0 and modulo_permiso=".$idModulo. " and usuario_pu = " . $usuario);
	$permisosActuales = array();
	while ($permiso = $permisosXUsuarioLoggeado->fetch_assoc()) {
		$permisosActuales[] = $permiso['nombre_permiso'];
	}
	include_once 'header.php';
?>
<div id="tabla" >
	<table class="table DataTable">
		<thead>
			<tr>
				<th>No. Empleado</th>
				<th>Nombre</th>
				<th>Departamento</th>
				<th>Puesto</th>
				<th>Antigüedad</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php while ($usuario = $usuarios->fetch_assoc()) { ?>
				<tr>
					<td><?php echo $usuario['noempleado']; ?></td>
					<td><?php echo $usuario['nombre']; ?></td>
					<td><?php echo $usuario['nombre_depto']; ?></td>
					<td><?php echo $usuario['nombre_puesto']; ?></td>
					<td><?php 
 						$date1 = strtotime($usuario['ingreso_usu']);  // convierte a segundos
						$date2 = strtotime(date("d-m-Y H:i:00",time())); // convierte a segundos
						$diff = abs($date2 - $date1);  
						$años = floor($diff / (365*60*60*24));  //redonde a un numero entetero mas bajo 4.3 años lo redonde a 4
						$meses = floor(($diff - $años * 365*60*60*24) 
                               / (30*60*60*24));  
						$dias = floor(($diff - $años * 365*60*60*24 -  
					             $meses*30*60*60*24)/ (60*60*24));
						if($años>0){
							if($años==1){
								if($meses>1){
									printf("%d año, %d meses, %d dias ", $años, $meses, $dias);
								}elseif($meses==1){
									printf("%d año, %d mes, %d dias ", $años, $meses, $dias);
								}else{
									printf("%d año,  %d dias ", $años, $dias);
								}
							}else{
								printf("%d años, %d meses, %d dias ", $años, $meses, $dias);
							}
						}elseif($meses>0){
							printf("%d meses, %d dias ", $meses, $dias);
						}else{
							printf(" %d dias ", $dias);
						
						}
					 ?></td>
					<td>
						<?php if(in_array("EDITAR", $permisosActuales)){ ?>
							<i class="fas fa-edit"  data-toggle="modal" data-target="#modal" onclick="editarUsuario(<?php echo $usuario['id']; ?>)"></i>
						<?php } ?>
						<?php if(in_array("EQUIPOS", $permisosActuales)){ ?>
							<i class="fas fa-desktop"></i>
						<?php } ?>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitulo"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalContenido">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="enviarForm();">Enviar</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	function agregarUsuario(){
		$("#modaltitulo").html("Agregar Usuario");
		$("#modalContenido").load("vistas/usuarios/formularios/form1.php");
	}
	function editarUsuario(id){
		$("#modaltitulo").html("Editar Usuario");
		$("#modalContenido").load("vistas/usuarios/formularios/form1.php",{id:id});
	}
</script>

