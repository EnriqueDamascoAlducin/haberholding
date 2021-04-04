<?php

	include_once '../../../../controladores/finsession.php';
	include_once '../../../../controladores/conexion.php';
	if(isset($_POST['id'])){
		$software = $con->query("SELECT * from software where id=".$_POST['id'])->fetch_assoc();
	
	}
	$clasificaciones = $con->query("SELECT  id, nombre from clasificaciones WHERE status<>0 AND tipo = 1 ORDER BY nombre");
?>
<div class="alert alert-warning" role="alert" style="display: none" id="alerta">
  
</div>
<form id="formSoftware" onsubmit="">
	<?php if(!isset($_POST['id'])){ ?>
		<input type="hidden" name="opc" id="opc" value="agregar">
	<?php }else{ ?>
		<input type="hidden" name="opc" id="opc" value="editar">
		<input type="hidden" name="id" id="id" value="<?php echo $_POST['id'] ?>">
	<?php } ?>
	<div class="row">
		<div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
			<div class="form-group">
				<label for="nombre" class="form-label"><span style="color:red">*</span>Nombre</label>
				<input type="text" name="nombre" id="nombre" class="form-control" value="<?php if(isset($software['nombre'])){echo $software['nombre']; }?>" placeholder="Nombre" required> 
				<small id="small_nombre"></small>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
			<div class="form-group">
				<label for="clasificacion" class="form-label"><span style="color:red">*</span>Clasificación</label>
				<select class="form-control" id="clasificacion" name="clasificacion" placeholder="clasificación">
					<option value="" >Seleccione una</option>
					<?php while($clasificacion = $clasificaciones->fetch_assoc()){ ?>
						<?php  if(isset($software['id_clasificacion']) && $software['id_clasificacion'] == $clasificacion['id'] ){ $sel = "selected"; } else{ $sel = "";}  ?>
						<option value = "<?php  echo $clasificacion['id'] ; ?>" <?php echo $sel ?> > <?php echo $clasificacion['nombre'] ; ?></option>
					<?php } ?>
				</select>
				<small id="small_clasificacion"></small>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
			<div class="form-group">
				<label for="fecha_max_licencia" class="form-label">Vencimiento de Licencia</label>
				<input type="date" name="fecha_max_licencia" id="fecha_max_licencia" class="form-control" value="<?php if(isset($software['fecha_max_licencia'])){echo $software['fecha_max_licencia']; }?>" placeholder="Nombre" required> 
				<small id="small_fecha_max_licencia"></small>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
			<div class="form-group">
				<label for="version" class="form-label"><span style="color:red">*</span>Versión</label>
				<input type="text" id="version" name="version" class="form-control" placeholder="Versión" value="<?php if(isset($software['version'])){echo $software['version']; }?>">
				
				<small id="small_version"></small>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">
	
	function enviarForm(){
		datos = $("#formSoftware").serialize();
		url="controladores/equipos/software.php";
		$("#formSoftware").children().find("small").removeAttr("style").html("");
		$("#formSoftware").children().find("input,select").removeAttr("style");
		$("#alerta").html("").hide();
		$.ajax({
			url:url,
			data:datos,
			dataType:'json',
			type:"POST",
			success:function(errores){
					console.log(errores);
				if(errores['campos']){
					$.each(errores['campos'],function(indice,campo){
						$("#small_"+campo).css("color","red").html("Es necesario que capture esta información correctamente");
						$("#"+campo).css("border-color","red").focus();
					});
				}else{
					$("#modal").modal('hide');
					console.log(errores);
				    swal({
				      title: "Registro Agregado",
				      text: "errores",
				      icon: "success",
				    });
				    setTimeout(function(){
				      $(".swal-button").trigger("click");
				    	recargarPagina();
				    },1500);
				}
			},
			error:function(stat,text,text2){
				alert(text2);
			}
		});
	}
</script>