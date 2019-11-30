<?php

	include_once '../../../controladores/finsession.php';
	include_once '../../../controladores/conexion.php';
	if(isset($_POST['id'])){
		$usuario = $con->query("Select * from usuarios where id_usu=".$_POST['id'])->fetch_assoc();
	}
	$departamentos = $con->query("Select nombre_depto as text, id_depto as value from departamentos where status_depto<>0");
?>
<div class="alert alert-warning" role="alert" style="display: none" id="alerta">
  
</div>
<form id="formUsuario" onsubmit="">
	<?php if(!isset($_POST['id'])){ ?>
		<input type="hidden" name="opc" id="opc" value="agregar">
	<?php }else{ ?>
		<input type="hidden" name="opc" id="opc" value="actualizar">
		<input type="hidden" name="id" id="id" value="<?php echo $_POST['id'] ?>">
	<?php } ?>
	<div class="row">
		<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
			<div class="form-group">
				<label for="noempleado" class="form-label"><span style="color:red">*</span> No Empleado</label>
				<input type="number" name="noempleado" id="noempleado" class="form-control" value="<?php if(isset($usuario['noempleado_usu'])){echo $usuario['noempleado_usu']; } ?>" placeholder="No. Empleado">
				<small id="small_noempleado"></small>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
			<div class="form-group">
				<label for="nombre" class="form-label"><span style="color:red">*</span>Nombre</label>
				<input type="text" name="nombre" id="nombre" class="form-control" value="<?php if(isset($usuario['noempleado_usu'])){echo $usuario['nombre_usu']; } ?>" placeholder="Nombre" required> 
				<small id="small_nombre"></small>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
			<div class="form-group">
				<label for="apellidop" class="form-label"><span style="color:red">*</span>Apellido Paterno</label>
				<input type="text" name="apellidop" id="apellidop" class="form-control" value="<?php if(isset($usuario['noempleado_usu'])){echo $usuario['apellidop_usu']; } ?>" placeholder="Apellido Paterno">
				<small id="small_apellidop"></small>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
			<div class="form-group">
				<label for="apellidom" class="form-label">Apellido Materno</label>
				<input type="text" name="apellidom" id="apellidom" class="form-control" value="<?php if(isset($usuario['noempleado_usu'])){echo $usuario['apellidom_usu']; } ?>" placeholder="Apellido Materno" >
				<small id="small_apellidom"></small>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
			<div class="form-group">
				<label for="sexo" class="form-label"><span style="color:red">*</span>Sexo</label>
				<select id="sexo" name="sexo" class="form-control">
					<option value="">Selecciona un Sexo</option>
					<option value="1">Hombre</option>
					<option value="2">Mujer</option>
				</select>
				<small id="small_sexo"></small>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
			<div class="form-group">
				<label for="correo" class="form-label"><span style="color:red">*</span>Correo</label>
				<input type="email" name="correo" id="correo" class="form-control" placeholder="ejemplo@ejemplo.com">
				<small id="small_correo"></small>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
			<div class="form-group">
				<label for="extension" class="form-label">Extensión</label>
				<input type="number" name="extension" id="extension" class="form-control" placeholder="Extensión">
				<small id="small_extension"></small>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
			<div class="form-group required">
				<label for="departamento" class="form-label"><span style="color:red">*</span>Departamento</label>
				<select id="departamento" name="departamento" class="form-control" onchange="cargarPuestos()">
					<option value="">Selecciona un Departamento</option>
					<?php while ($departamento = $departamentos->fetch_assoc()){ ?>
						<option value="<?php echo $departamento['value']; ?>"><?php echo $departamento['text']; ?></option>
					<?php } ?>
				</select>
				<small id="small_departamento"></small>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
			<div class="form-group">
				<label for="puesto" class="form-label"><span style="color:red">*</span>Puesto</label>
				<select id="puesto" name="puesto" class="form-control">
					<option value="">Selecciona un Puesto</option>
				</select>
				<small id="small_puesto"></small>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
			<div class="form-group">
				<label for="ingreso" class="form-label"><span style="color:red">*</span>Fecha de Ingreso</label>
				<input type="date" name="ingreso" id="ingreso" class="form-control" placeholder="Fecha de Ingreso">
				<small id="small_ingreso"></small>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
			<div class="form-group">
				<label for="contrasena" class="form-label"><span style="color:red">*</span>Contraseña</label>
				<input type="password" name="contrasena" id="contrasena" class="form-control" placeholder="Contraseña">
				<small id="small_contrasena"></small>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
			<div class="form-group required">
				<label for="confirmarcontrasena" class="form-label"><span style="color:red">*</span>Confirmar Contraseña</label>
				<input type="password" name="confirmarcontrasena" id="confirmarcontrasena" class="form-control" placeholder="Confirmar Contraseña">
				<small id="small_confirmarcontrasena"></small>
			</div>
		</div>

      <!-- Sidebar user (optional) -->
	</div>
	<center>
        <div class="image">
            <img src="../dist/img/noimage.jpg" id="imgIcon" class="img-circle elevation-2" alt="Mujer" style="max-width: 150px">
        </div>
    </center>
</form>
<script type="text/javascript">
	$("#sexo").on("change",function(){
		if(this.value==1)
			$("#imgIcon").attr("src","../dist/img/userM.jpg");
		else if(this.value==2)
			$("#imgIcon").attr("src","../dist/img/userW.jpg");
		else			
			$("#imgIcon").attr("src","../dist/img/noimage.jpg");
	});
	function cargarPuestos(){
		depto= $("#departamento").val();
		url="controladores/usuarios/controlador.php";
		datos={
			depto:depto,
			opc:'departamentos'
		};
		$.ajax({
			url:url,
			data:datos,
			type:"POST",
			success:function(puestos){
				$("#puesto").html(puestos);
			},
			error:function(stat,text,text2){
				alert(text2);
			}
		});
	}
	function enviarForm(){
		datos = $("#formUsuario").serialize();
		url="controladores/usuarios/controlador.php";
		$("#formUsuario").children().find("small").removeAttr("style").html("");
		$("#formUsuario").children().find("input,select").removeAttr("style");
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
					console.log(errores);
				    swal({
				      title: "Registro Agregado",
				      text: "errores",
				      icon: "success",
				      button: "Iniciar Sesión",
				    });
				    setTimeout(function(){
				      $(".swal-button").trigger("click");
				    },1500);

				}
			},
			error:function(stat,text,text2){
				alert(text2);
			}
		});
	}
</script>