<?php 
	include_once '../../../../controladores/finsession.php';
	include_once '../../../../controladores/conexion.php';
	$query = "SELECT nombre_puesto as nombre, id_puesto as id FROM puestos WHERE status_puesto<>0 and iddepto_puesto =".$_POST['id'];
	$puestos = $con->query($query);
?>

<form id="formPuesto" onsubmit="">
	<input type="hidden" name="opc" id="opc" value="agregar">
	<input type="hidden" name="id" id="id" value="<?php echo $_POST['id'] ?>">
	<input type="hidden" name="id_puesto" id="id_puesto">
	<div class="row">
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<div class="form-group">
				<label for="nombre" class="form-label"><span style="color:red">*</span>Nombre</label>
				<input type="text" name="nombre" id="nombre" class="form-control" value="" placeholder="Nombre" required> 
				<small id="small_nombre"></small>
			</div>
		</div>
      <!-- Sidebar user (optional) -->
	</div>
</form>
<table class="table">
	<thead>
		<th>Nombre</th>
		<th>Acciones</th>
	</thead>
	<tbody>
		<?php while ($puesto = $puestos->fetch_assoc()) {
			echo "<tr>";
				echo "<td>".$puesto['nombre']."</td>";
				echo "<td><i class='fa fa-trash' onclick='eliminarPuesto(".$puesto['id'].")'>&nbsp;&nbsp;</i><i class='fa fa-edit' onclick='editarPuesto(".$puesto['id'].",\"".trim($puesto['nombre']) ."\" )'></i></td>";
			echo "</tr>";
		} ?>
	</tbody>
</table>
<script type="text/javascript">
	function eliminarPuesto(id){

		url="controladores/usuarios/puestos.php";
		datos = {id:id,opc:'eliminar'};
		$.ajax({
			url:url,
			data:datos,
			type:"POST",
			success:function(errores){
				$("#modal").modal('hide');
				console.log(errores);
			    swal({
			      title: "Registro Eliminado",
			      text: "...",
			      icon: "error",
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
	function editarPuesto(id,nombre){
		$("#id_puesto").val(id);
		$("#nombre").val(nombre);
		$("#opc").val("editar");
		$("#enviarForm").html("Actualizar").removeClass('btn-primary').addClass('btn-success');
	}

	function enviarForm(){
		datos = $("#formPuesto").serialize();
		url="controladores/usuarios/puestos.php";
		$("#formPuesto").children().find("small").removeAttr("style").html("");
		$("#formPuesto").children().find("input,select").removeAttr("style");
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