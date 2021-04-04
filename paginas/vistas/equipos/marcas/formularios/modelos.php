<?php

	include_once '../../../../controladores/finsession.php';
	include_once '../../../../controladores/conexion.php';
	$modelos = $con->query("SELECT * from modelos where status<>0 and  id_marca=".$_POST['id']);
?>
<div class="alert alert-warning" role="alert" style="display: none" id="alerta">
  
</div>
<form id="formModelo" onsubmit="">
		<input type="hidden" name="opc" id="opc" value="agregar">
		<input type="hidden" name="id" id="id" value="<?php echo $_POST['id'] ?>">
		<input type="hidden" name="id_modelo" id="id_modelo" >
	<div class="row">
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<div class="form-group">
				<label for="nombre" class="form-label"><span style="color:red">*</span>Nombre</label>
				<input type="text" name="nombre" id="nombre" class="form-control" value="<?php if(isset($marcas['nombre'])){echo $marcas['nombre']; }?>" placeholder="Nombre" required> 
				<small id="small_nombre"></small>
			</div>
		</div>
      <!-- Sidebar user (optional) -->
	</div>
</form>
<table class="table">
	<thead>
		<th>Modelo</th>
		<th>Acciones</th>
	</thead>
	<tbody>
		<?php while($modelo = $modelos->fetch_assoc()){ ?>
			<tr>
				<td><?php echo $modelo['nombre'] ?></td>
				<td><i class="fa fa-edit" onclick="editarModelo(<?php echo $modelo['id'] ?>,'<?php echo $modelo["nombre"] ?>')"></i>&nbsp;&nbsp; <i class="fa fa-trash" onclick="eliminarModelo(<?php echo $modelo['id'] ?>)"></i></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script type="text/javascript">
	function editarModelo(id,nombre){
		$("#id_modelo").val(id);
		$("#nombre").val(nombre);
		$("#opc").val("editar");
		$("#enviarForm").html("Actualizar").removeClass("btn-primary").addClass("btn-info");
	}
	function eliminarModelo(id){
		url="controladores/equipos/modelos.php";
		$.ajax({
			url:url,
			data:{opc:'eliminar',id:id},
			type:"POST",
			success:function(res){
				$("#modal").modal('hide');
				console.log(res);
			    swal({
			      title: "Eliminado " + res,
			      text: "...",
			      icon: "success",
			    });
			    setTimeout(function(){
			      $(".swal-button").trigger("click");
			    	recargarPagina();
			    },1500);
			
			},
			error:function(stat,text,text2){
				alert(text2);
			}
		});
	}
	function enviarForm(){
		datos = $("#formModelo").serialize();
		url="controladores/equipos/modelos.php";
		$("#formModelo").children().find("small").removeAttr("style").html("");
		$("#formModelo").children().find("input,select").removeAttr("style");
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
				      text: "...",
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