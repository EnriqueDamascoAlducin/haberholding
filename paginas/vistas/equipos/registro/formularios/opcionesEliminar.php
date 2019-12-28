<?php

	include_once '../../../../controladores/finsession.php';
	include_once '../../../../controladores/conexion.php';
	
	

?>
<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" role="alert"  id="alerta" style="text-align: center;">
  <button class="btn btn-warning" onclick="eliminar(<?php echo $_POST['id'] ?>,'<?php echo $_POST['nombre'] ?>',3)">Enviar a Reparación</button>
  <button class="btn btn-info" onclick="eliminar(<?php echo $_POST['id'] ?>,'<?php echo $_POST['nombre'] ?>',4)">Enviar a Garantía</button>
  <button class="btn btn-danger" onclick="eliminar(<?php echo $_POST['id'] ?>,'<?php echo $_POST['nombre'] ?>',0)">Eliminar</button>
</div>
