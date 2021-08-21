<?php

	include_once '../../../../controladores/finsession.php';
	include_once '../../../../controladores/conexion.php';
	
	$usuario = $_POST['id'];
	$equipoAsignado = array();
	$equipos = $con->query("SELECT serie as text, id as value from equipos where status = 1  ");

	$equiposAsignado = $con->query("SELECT id_equipo FROM usuarios_equipo WHERE status =1  and id_usuario = $usuario");


?>
<div class="alert alert-warning" role="alert" style="display: none" id="alerta">
  
</div>
	<form id="FormComponentes" onsubmit="">
		<input type="hidden" name="opc" id="opc" value="agregar">
		<input type="hidden" name="id" id="id" value="<?php echo $_POST['id'] ?>">
		
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<div class="form-group required">
					<label for="equipo" class="form-label"><span style="color:red">*</span>Equipos Disponbles</label>
					<select id="equipo" name="equipo" class="form-control" >
						<option value="">Selecciona uno</option>
						<?php while ($equipo = $equipos->fetch_assoc()){ ?>
							<option value="<?php echo $equipo['value']; ?>" ><?php echo $equipo['text']; ?></option>
						<?php } ?>
					</select>
					<small id="small_equipo"></small>
				</div>
			</div>
		</div>
	</form>
<div class="table-responsive-sm" id="equipoInfo">
</div>
<script type="text/javascript">


<?php while ($equipoAsignado = $equiposAsignado->fetch_assoc()){ ?>
	getEquipoInfoAsginado(<?php echo $equipoAsignado['id_equipo'] ?>);
<?php } ?>
	$("#equipo").on("change",function(){
		if(this.value != ""){
			getEquipoInfo(this.value);
		}else{
			$("#equipoInfo").html("");
		}
		
	});
	function getEquipoInfo(equipo){
		url="controladores/clientes/usuarios_equipos.php";
		datos ={ opc:'infoequipo',equipo:equipo};
		$.ajax({
			url:url,
			data:datos,
			type:"POST",
			success:function(tabla){
				$("#equipoInfo").html(tabla);
			},
			error:function(stat,text,text2){
				alert(stat);
			}
		});
	}
	function getEquipoInfoAsginado(equipo){
		url="controladores/clientes/usuarios_equipos.php";
		datos ={ opc:'infoequipoAsignado',equipo:equipo};
		$.ajax({
			url:url,
			data:datos,
			type:"POST",
			success:function(tabla){
				$("#equipoInfo").html(tabla);
			},
			error:function(stat,text,text2){
				alert(stat);
			}
		});
	}
	function desasignarEquipo(id){
		url="controladores/clientes/usuarios_equipos.php";
		datos ={ opc:'eliminar',id:id};
		$.ajax({
			url:url,
			data:datos,
			type:"POST",
			success:function(errores){
				$(".modal").modal("hide");
				console.log(errores);
			    swal({
			      title: "Equipo Desasignado",
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
		datos = $("#FormComponentes").serialize();
		url="controladores/clientes/usuarios_equipos.php";
		$("#FormComponentes").children().find("small").removeAttr("style").html("");
		$("#FormComponentes").children().find("input,select").removeAttr("style");
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
				alert(stat);
			}
		});
	}
</script>
