<?php

	include_once '../../../../controladores/finsession.php';
	include_once '../../../../controladores/conexion.php';
	if(isset($_POST['id'])){
		$departamento = $con->query("Select * from departamentos where id_depto=".$_POST['id'])->fetch_assoc();
	}
?>
<div class="alert alert-warning" role="alert" style="display: none" id="alerta">
  
</div>
<form id="formDepto" onsubmit="">
	<?php if(!isset($_POST['id'])){ ?>
		<input type="hidden" name="opc" id="opc" value="agregar">
	<?php }else{ ?>
		<input type="hidden" name="opc" id="opc" value="editar">
		<input type="hidden" name="id" id="id" value="<?php echo $_POST['id'] ?>">
	<?php } ?>
	<div class="row">
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<div class="form-group">
				<label for="nombre" class="form-label"><span style="color:red">*</span>Nombre</label>
				<input type="text" name="nombre" id="nombre" class="form-control" value="<?php if(isset($departamento['nombre_depto'])){echo $departamento['nombre_depto']; }?>" placeholder="Nombre" required> 
				<small id="small_nombre"></small>
			</div>
		</div>
      <!-- Sidebar user (optional) -->
	</div>
</form>
<script type="text/javascript">
	
	function enviarForm(){
		datos = $("#formDepto").serialize();
		url="controladores/usuarios/departamentos.php";
		$("#formDepto").children().find("small").removeAttr("style").html("");
		$("#formDepto").children().find("input,select").removeAttr("style");
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
				}else if(errores['contrasena']){
				    $("#alerta").html("Las contraseñas no Coinciden").show();
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