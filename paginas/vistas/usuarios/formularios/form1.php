<?php

	include_once '../../../controladores/finsession.php';
	include_once '../../../controladores/conexion.php';
	if(isset($_POST['id'])){
		$usuario = $con->query("Select * from usuarios where id_usu=".$_POST['id'])->fetch_assoc();
	}
	$departamentos = $con->query("Select nombre_depto as text, id_depto as value from departamentos where status_depto<>0");
?>
<form>
	<div class="row">
		<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
			<div class="form-group">
				<label for="noempleado" class="form-label">No Empleado</label>
				<input type="number" name="noempleado" id="noempleado" class="form-control" value="<?php if(isset($usuario['noempleado_usu'])){echo $usuario['noempleado_usu']; } ?>" placeholder="No. Empleado">
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
			<div class="form-group">
				<label for="nombre" class="form-label">Nombre</label>
				<input type="text" name="nombre" id="nombre" class="form-control" value="<?php if(isset($usuario['noempleado_usu'])){echo $usuario['nombre_usu']; } ?>" placeholder="Nombre"> 
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
			<div class="form-group">
				<label for="apelllidop" class="form-label">Apellido Paterno</label>
				<input type="text" name="apelllidop" id="apelllidop" class="form-control" value="<?php if(isset($usuario['noempleado_usu'])){echo $usuario['apellidop_usu']; } ?>" placeholder="Apellido Paterno">
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
			<div class="form-group">
				<label for="apellidom" class="form-label">Apellido Materno</label>
				<input type="text" name="apellidom" id="apellidom" class="form-control" value="<?php if(isset($usuario['noempleado_usu'])){echo $usuario['apellidom_usu']; } ?>" placeholder="Apellido Materno" >
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
			<div class="form-group">
				<label for="sexo" class="form-label">Sexo</label>
				<select id="sexo" name="sexo" class="form-control">
					<option value="">Selecciona un Sexo</option>
					<option value="1">Hombre</option>
					<option value="2">Mujer</option>
				</select>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
			<div class="form-group">
				<label for="correo" class="form-label">Correo</label>
				<input type="email" name="correo" id="correo" class="form-control" placeholder="ejemplo@ejemplo.com">
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
			<div class="form-group">
				<label for="extension" class="form-label">Extensión</label>
				<input type="number" name="extension" id="extension" class="form-control" placeholder="Extensión">
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
			<div class="form-group required">
				<label for="apellidom" class="form-label">Departamento</label>
				<select id="departamento" name="departamento" class="form-control">
					<option value="">Selecciona un Departamento</option>
					<?php while ($departamento = $departamentos->fetch_assoc()){ ?>
						<option value="<?php echo $departamento['value']; ?>"><?php echo $departamento['text']; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
			<div class="form-group">
				<label for="puesto" class="form-label">Puesto</label>
				<select id="puesto" name="puesto" class="form-control">
					<option value="">Selecciona un Puesto</option>
				</select>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
			<div class="form-group">
				<label for="ingreso" class="form-label">Fecha de Ingreso</label>
				<input type="date" name="ingreso" id="ingreso" class="form-control" placeholder="Fecha de Ingreso">
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
			<div class="form-group">
				<label for="contrasena" class="form-label">Contraseña</label>
				<input type="password" name="contrasena" id="contrasena" class="form-control" placeholder="Contraseña">
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
			<div class="form-group required">
				<label for="confirmarcontrasena" class="form-label">Confirmar Contraseña</label>
				<input type="password" name="confirmarcontrasena" id="confirmarcontrasena" class="form-control" placeholder="Confirmar Contraseña">
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
</script>