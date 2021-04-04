<?php

	include_once '../../../../controladores/finsession.php';
	include_once '../../../../controladores/conexion.php';
	if(isset($_POST['id'])){
		$componentes = $con->query("Select * from componentes where id=".$_POST['id'])->fetch_assoc();
	
	}
	$clasificaciones = $con->query("SELECT  id, nombre from clasificaciones WHERE status<>0 AND tipo = 2 ORDER BY nombre");
	$marcas = $con->query("SELECT nombre,id FROM marcas where status<>0");
?>
<div class="alert alert-warning" role="alert" style="display: none" id="alerta">
  
</div>
<form id="formClasificacion" onsubmit="">
	<?php if(!isset($_POST['id'])){ ?>
		<input type="hidden" name="opc" id="opc" value="agregar">
	<?php }else{ ?>
		<input type="hidden" name="opc" id="opc" value="editar">
		<input type="hidden" name="id" id="id" value="<?php echo $_POST['id'] ?>">
	<?php } ?>
	<div class="row">
		<div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
			<div class="form-group">
				<label for="nombre" class="form-label"><span style="color:red">*</span>Serie</label>
				<input type="text" name="nombre" id="nombre" class="form-control" value="<?php if(isset($componentes['nombre'])){echo $componentes['nombre']; }?>" placeholder="Serie" required> 
				<small id="small_nombre"></small>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
			<div class="form-group">
				<label for="clasificacion" class="form-label"><span style="color:red">*</span>Clasificación</label>
				<select class="form-control" id="clasificacion" name="clasificacion" placeholder="clasificación">
					<option value="" >Seleccione una</option>
					<?php while($clasificacion = $clasificaciones->fetch_assoc()){ ?>
						<?php  if(isset($componentes['id_clasificacion']) && $componentes['id_clasificacion'] == $clasificacion['id'] ){ $sel = "selected"; } else{ $sel = "";}  ?>
						<option value = "<?php  echo $clasificacion['id'] ; ?>" <?php echo $sel ?> > <?php echo $clasificacion['nombre'] ; ?></option>
					<?php } ?>
				</select>
				<small id="small_clasificacion"></small>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
			<div class="form-group">
				<label for="fecha_max_garantia" class="form-label">Fecha de Garantia</label>
				<input type="date" name="fecha_max_garantia" id="fecha_max_garantia" class="form-control" value="<?php if(isset($componentes['fecha_max_garantia'])){echo $componentes['fecha_max_garantia']; }?>" placeholder="Nombre" required> 
				<small id="small_fecha_max_garantia"></small>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
			<div class="form-group">
				<label for="id_marca" class="form-label"><span style="color:red">*</span>Marca</label>
				<select class="form-control" id="id_marca" name="id_marca" placeholder="Marca">
					<option value="" >Seleccione una</option>
					<?php while($marca = $marcas->fetch_assoc()){ ?>
						<?php  if(isset($componentes['id_marca']) && $componentes['id_marca'] == $marca['id'] ){ $sel = "selected"; } else{ $sel = "";}  ?>
						<option value = "<?php  echo $marca['id'] ; ?>" <?php echo $sel ?> > <?php echo $marca['nombre'] ; ?></option>
					<?php } ?>
				</select>
				<small id="small_id_marca"></small>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
			<div class="form-group">
				<label for="id_modelo" class="form-label"><span style="color:red">*</span>Modelo</label>
				<select class="form-control" id="id_modelo" name="id_modelo" placeholder="Modelo">
					<option value="" >Seleccione una</option>
				</select>
				<small id="small_id_modelo"></small>
			</div>
		</div>
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<div class="form-group">
				<label for="descripcion" class="form-label"><span style="color:red">*</span>Descripicón</label>
				<textarea id="descripcion" name="descripcion" class="form-control" placeholder="Descripción"><?php if(isset($componentes['descripcion'])){echo $componentes['descripcion']; }?></textarea>
				
				<small id="small_descripcion"></small>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">
	$("#id_marca").on("change",function(){
		consultarModelos();
	});
	<?php if(isset($componentes['id_modelo'])){ ?>
		consultarModelos();
	<?php } ?>
	function consultarModelos(){
		marca = $("#id_marca").val();
		$("#id_modelo").html("<option value=''>Seleccione una </option>");
		if(marca!=""){
			url="controladores/equipos/componentes.php";
			datos = {
				opc : 'modelos',
				marca:marca
			}
			$.ajax({
				url:url,
				data:datos,
				type:"POST",
				success:function(modelos){
					$("#id_modelo").append(modelos);
					<?php if(isset($componentes['id_modelo']) && !empty($componentes['id_modelo'])){ ?>
						opc = "<?php echo $componentes['id_modelo'] ?>";
						$("#id_modelo option[value='"+opc+"']").prop("selected","selected");
					<?php } ?>
				},
				error:function(stat,text,text2){
					alert(text2);
				}
			});
		}
	}
	function enviarForm(){
		datos = $("#formClasificacion").serialize();
		url="controladores/equipos/componentes.php";
		$("#formClasificacion").children().find("small").removeAttr("style").html("");
		$("#formClasificacion").children().find("input,select").removeAttr("style");
		$("#alerta").html("").hide();
		$.ajax({
			url:url,
			data:datos,
			dataType:'json',
			type:"POST",
			success:function(errores){
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