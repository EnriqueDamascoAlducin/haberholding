<?php 
	include_once '../../../controladores/finsession.php';
	include_once '../../../controladores/conexion.php';
?>

<?php
$query = "SELECT nombre_modulo,icono_modulo,id_modulo FROM modulos where status_modulo=1";
$modulos =$con->query($query);


$queryPermisos = "Select nombre_permiso,id_permiso FROM permisos_modulos WHERE status_permiso = 1 AND modulo_permiso = ? ";
$preparePermisos = $con->prepare($queryPermisos);



$queryPermisosActuales = "SELECT COUNT(id_pu) AS asignados FROM permisos_usuarios WHERE status_pu = 1 AND  usuario_pu = ? AND permiso_pu = ?";
$preparePermisosActuales = $con->prepare($queryPermisosActuales);
?>
<div class="alert alert-info" style="text-align: center;">
  Permisos para <strong><?php echo $_POST['nombre'] ?></strong>.
</div>
<input type="hidden" name="usuario" id="usuario" value="<?php echo $_POST['usuario']; ?>">
<input type="hidden" name="modulo" id="modulo" >
<div class="container-fluid pt-3">
	<?php foreach ($modulos as $modulo) { ?>
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pb-2" style="text-align: center">
			<button type="button" class="btn btn-primary btn-lg" data-toggle="collapse" data-target="#modulo<?php echo $modulo['id_modulo'] ?>" style="width:100%" ><i class="<?php echo $modulo['icono_modulo'] ?>" ></i> <?php echo $modulo['nombre_modulo']; ?> </button>
			<div id="modulo<?php echo $modulo['id_modulo'] ?>" class="collapse">
				<div class="row pt-2">
					<?php 
						 $preparePermisos->bind_param('i',$modulo['id_modulo']);
						 $preparePermisos->execute();
						 $permisos = $preparePermisos->get_result(); 
					?>
					<?php foreach ($permisos as $permiso) { $checked = "" ;?>
						<?php 
							$preparePermisosActuales->bind_param('ii',$_POST['usuario'],$permiso['id_permiso']); 
							$preparePermisosActuales->execute();
							$asignados = $preparePermisosActuales->get_result();
							foreach ($asignados->fetch_assoc() as $isAsignado) {
								if($isAsignado>0){
									$checked = "checked";
								}

							}
						?>	
				    	<div class="form-group pl-1">
				        	<label for="permiso<?php echo $permiso['id_permiso']; ?>"><?php  echo $permiso['nombre_permiso'] ?></label>
				        	<input type="checkbox" <?php echo $checked; ?> name="permiso_<?php echo $modulo['id_modulo'] ?>[]" data-toggle="toggle" data-size="md" id="permiso_<?php echo $modulo['id_modulo']; ?>_<?php echo $permiso['id_permiso']; ?>" value="<?php echo $permiso['id_permiso']; ?>">
				      	</div>
					<?php } ?>
			    </div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 " style="text-align: center">
					<button class="btn btn-secondary" id="permisos_<?php echo $modulo['id_modulo'] ?>" onclick="guardarPermisos(<?php echo $_POST['usuario'] ?>,<?php echo $modulo['id_modulo'] ?>)">Guardar</button>
				</div>
			</div>
		</div>
	<?php } ?>
</div>

<script type="text/javascript">	
	$('input[type=checkbox][data-toggle^=toggle]').bootstrapToggle();

	function guardarPermisos(usuario,modulo) {
		$("#modulo").val(modulo);
		permisos = $("input[id^='permiso_"+modulo+"_']:checked , #usuario,#modulo");
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