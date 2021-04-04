<?php

	include_once '../../../../controladores/finsession.php';
	include_once '../../../../controladores/conexion.php';
	$opc1 = ""; $opc2 ="";
	if(isset($_POST['id'])){
		$clasificacion = $con->query("Select * from clasificaciones where id=".$_POST['id'])->fetch_assoc();
		if($clasificacion['tipo']==1){
			$opc1 = "selected";
		}elseif($clasificacion['tipo']==2){
			$opc2 = "selected";
		}
	}
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
				<label for="nombre" class="form-label"><span style="color:red">*</span>Nombre</label>
				<input type="text" name="nombre" id="nombre" class="form-control" value="<?php if(isset($clasificacion['nombre'])){echo $clasificacion['nombre']; }?>" placeholder="Nombre" required> 
				<small id="small_nombre"></small>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
			<div class="form-group">
				<label for="tipo" class="form-label"><span style="color:red">*</span>Tipo</label>
				<select class="form-control" id="tipo" name="tipo">
					<option value="1" <?php echo $opc1; ?>>Software</option>
					<option value="2" <?php echo $opc2; ?>>Hardware</option>
				</select>
				<small id="small_tipo"></small>
			</div>
		</div>
      <!-- Sidebar user (optional) -->
	</div>
</form>
<script type="text/javascript">
	
	function enviarForm(){
		datos = $("#formClasificacion").serialize();
		url="controladores/equipos/clasificaciones.php";
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