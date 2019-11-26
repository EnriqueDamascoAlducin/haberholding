<?php

	include_once '../../../controladores/finsession.php';
	include_once '../../../controladores/conexion.php';
	if(isset($_POST['id'])){
		$usuario = $con->query("Select * from usuarios where id_usu=".$_POST['id'])->fetch_assoc();

	}

?>
<div class="row">
	<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
		<div class="form-group">
			<label for="noempleado" class="form-label">No Empleado</label>
			<input type="number" name="noempleado" id="noempleado" class="form-control" value="<?php if(isset($usuario['noempleado_usu'])){echo $usuario['noempleado_usu']; } ?>">
		</div>
	</div>
	<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
		<div class="form-group">
			<label for="nombre" class="form-label">Nombre</label>
			<input type="text" name="nombre" id="nombre" class="form-control" value="<?php if(isset($usuario['noempleado_usu'])){echo $usuario['nombre_usu']; } ?>"> 
		</div>
	</div>
	<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
		<div class="form-group">
			<label for="apelllidop" class="form-label">Apellido Paterno</label>
			<input type="text" name="apelllidop" id="apelllidop" class="form-control" value="<?php if(isset($usuario['noempleado_usu'])){echo $usuario['apellidop_usu']; } ?>">
		</div>
	</div>
	<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
		<div class="form-group">
			<label for="apellidom" class="form-label">Apellido Materno</label>
			<input type="text" name="apellidom" id="apellidom" class="form-control" value="<?php if(isset($usuario['noempleado_usu'])){echo $usuario['apellidom_usu']; } ?>">
		</div>
	</div>
	<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
		<div class="form-group">
			<label for="apellidom" class="form-label">Sexo</label>
			<input type="text" name="apellidom" id="apellidom" class="form-control">
		</div>
	</div>
	<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
		<div class="form-group">
			<label for="correo" class="form-label">Correo</label>
			<input type="text" name="correo" id="correo" class="form-control">
		</div>
	</div>
	<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
		<div class="form-group">
			<label for="extension" class="form-label">Extensión</label>
			<input type="text" name="extension" id="extension" class="form-control">
		</div>
	</div>
</div>