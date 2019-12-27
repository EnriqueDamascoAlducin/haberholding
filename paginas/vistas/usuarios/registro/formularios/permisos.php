<?php 
	include_once '../../../../controladores/finsession.php';
	include_once '../../../../controladores/conexion.php';
?>

<?php
$query = "SELECT nombre_modulo,icono_modulo,id_modulo FROM modulos where status_modulo=1";
$modulos =$con->query($query);

$querySubmodulos = "SELECT nombre,icono,id FROM submodulos where status<>0 AND modulo = ? ";
$prepareSubmodulos = $con->prepare($querySubmodulos);

$queryPermisos = "SELECT nombre, id FROM permisos_submodulos WHERE idsubmodulo = ? ";
$preparePermisos = $con->prepare($queryPermisos);



$queryPermisosActuales = "SELECT COUNT(id) AS asignados FROM permisos_submodulos_usuarios WHERE status = 1 AND  idusuario = ? AND idpermiso = ?";
$preparePermisosActuales = $con->prepare($queryPermisosActuales);
?>
<div class="alert alert-info" style="text-align: center;">
  Permisos para <strong><?php echo $_POST['nombre'] ?></strong>.
</div>
<input type="hidden" name="usuario" id="usuario" value="<?php echo $_POST['usuario']; ?>">
<input type="hidden" name="submodulo" id="submodulo" >
<div class="container-fluid pt-3">
	<?php foreach ($modulos as $modulo) { ?>
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pb-2" style="text-align: center">
			<button type="button" class="btn btn-primary btn-lg" data-toggle="collapse" data-target="#modulo<?php echo $modulo['id_modulo'] ?>" style="width:100%" ><i class="<?php echo $modulo['icono_modulo'] ?>" ></i> <?php echo $modulo['nombre_modulo']; ?> </button>
			<div id="modulo<?php echo $modulo['id_modulo'] ?>" class="collapse">
				<div class="row pt-2">
					<?php 
						$prepareSubmodulos->bind_param('i',$modulo['id_modulo']);
						$prepareSubmodulos->execute();
						$submodulos = $prepareSubmodulos->get_result(); 
					?>
					<?php foreach ($submodulos as $submodulo) { ?>
						<div class="col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10 pb-2" style="text-align: center">
							<button type="button" class="btn btn-info btn-lg" data-toggle="collapse" data-target="#modulo<?php echo $modulo['id_modulo'] ?>_submodulo<?php echo $submodulo['id'] ?>" style="width:100%" ><i class="<?php echo $submodulo['icono'] ?>" ></i> <?php echo $submodulo['nombre']; ?> </button>

							<div id="modulo<?php echo $modulo['id_modulo'] ?>_submodulo<?php echo $submodulo['id'] ?>" class="collapse">
								<div class="row pt-2">
									<?php 
									$preparePermisos->bind_param('i',$submodulo['id']);
									$preparePermisos->execute();
									$permisos = $preparePermisos->get_result();
									foreach ($permisos as $permiso) {
										$checked = "" ;
										$preparePermisosActuales->bind_param('ii',$_POST['usuario'],$permiso['id']); 
										$preparePermisosActuales->execute();
										$asignados = $preparePermisosActuales->get_result();
										foreach ($asignados->fetch_assoc() as $isAsignado) {
											if($isAsignado>0){
												$checked = "checked";
											}
										} 
									?>
								    	<div class="form-group pl-1">
								        	<label for="permiso_<?php echo $submodulo['id']; ?>_<?php echo $permiso['id']; ?>"><?php  echo $permiso['nombre'] ?></label>
								        	<input type="checkbox" <?php echo $checked; ?> name="permiso_<?php echo $submodulo['id'] ?>[]" data-toggle="toggle" data-size="md" id="permiso_<?php echo $submodulo['id']; ?>_<?php echo $permiso['id']; ?>" value="<?php echo $permiso['id']; ?>">
								      	</div>
										
									<?php } ?>
								
								</div>

								<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 " style="text-align: center">
									<button class="btn btn-secondary" id="permisos_<?php echo $submodulo['id'] ?>" onclick="guardarPermisos(<?php echo $_POST['usuario'] ?>,<?php echo $submodulo['id'] ?>)">Guardar</button>
								</div>
							</div>
				      	</div>
					<?php } ?>
			    </div>
			</div>
		</div>
	<?php } ?>
</div>

<script type="text/javascript">	
	$('input[type=checkbox][data-toggle^=toggle]').bootstrapToggle();

	function guardarPermisos(usuario,submodulo) {
		$("#submodulo").val(submodulo);
		permisos = $("input[id^='permiso_"+submodulo+"_']:checked , #usuario,#submodulo");
		$.ajax({
			url:'controladores/usuarios/permisos.php',
			data:permisos,
			type:'POST',
			success:function(respuesta){
				alert(respuesta);
			}
		});
	}
</script>