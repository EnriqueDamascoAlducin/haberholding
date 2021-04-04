<?php

	include_once '../../../../controladores/finsession.php';
	include_once '../../../../controladores/conexion.php';
	
	$componentesAsignados = $con->query("SELECT s.nombre,es.id from equipos_software es INNER JOIN software s ON id_componente = s.id where es.status<>0 AND id_equipo=".$_POST['id']);//->fetch_assoc();
	
	$softwares = $con->query("SELECT nombre as text, id as value from software where status<>0 ");

?>
<div class="alert alert-warning" role="alert" style="display: none" id="alerta">
  
</div>
<form id="formSoftware" onsubmit="">
		<input type="hidden" name="opc" id="opc" value="agregar">
		<input type="hidden" name="id" id="id" value="<?php echo $_POST['id'] ?>">
		<input type="hidden" name="id_componente" id="id_componente" >
	
	<div class="row">
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<div class="form-group required">
				<label for="clasificacion" class="form-label"><span style="color:red">*</span>Software</label>
				<select id="clasificacion" name="clasificacion" class="form-control" >
					<option value="">Selecciona una</option>
					<?php while ($software = $softwares->fetch_assoc()){ ?>
						<option value="<?php echo $software['value']; ?>" ><?php echo $software['text']; ?></option>
					<?php } ?>
				</select>
				<small id="small_clasificacion"></small>
			</div>
		</div>
	</div>
</form>
<table class="table">
	<thead>
		<tr>
			<th>Componente</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php while ($componentesAsignado = $componentesAsignados->fetch_assoc()) { ?>
			<tr>
				<td><?php echo $componentesAsignado['nombre'] ?></td>
				<td> <i class="fa fa-trash" onclick="eliminarComponente(<?php echo $componentesAsignado['id'] ?>)"></i> </td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script type="text/javascript">
	function eliminarComponente(id){
		url="controladores/equipos/equipos_software.php";
		datos ={ opc:'eliminar',id:id};
		$.ajax({
			url:url,
			data:datos,
			type:"POST",
			success:function(errores){
				$(".modal").modal("hide");
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
			},
			error:function(stat,text,text2){
				alert(stat);
			}
		});
	}	
	function enviarForm(){
		datos = $("#formSoftware").serialize();
		url="controladores/equipos/equipos_software.php";
		$("#formSoftware").children().find("small").removeAttr("style").html("");
		$("#formSoftware").children().find("input,select").removeAttr("style");
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
					$(".modal").modal("hide");
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
				console.log(stat);
			}
		});
	}
</script>