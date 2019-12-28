<?php

	include_once '../../../../controladores/finsession.php';
	include_once '../../../../controladores/conexion.php';
	$movimientos =$con->query("SELECT movimiento, CONCAT(IFNULL(nombre_usu,''),' ',IFNULL(apellidop_usu,''),'(',noempleado_usu,')') as usuario,comentario,bme.registro FROM bitacora_movimientos_equipo bme INNER JOIN usuarios u ON bme.id_usu = u.id_usu  WHERE status<>0 and id_equipo = ".$_POST['id']);
	

?>
<div class="table-responsive-md">
  <table class="table">
   	<thead>
   		<tr>
   			<th>Movimiento</th>
   			<th>Usuario</th>
   			<th>Comentario</th>
   			<th>Fecha</th>
   		</tr>
   	</thead>
   	<tbody>
   		<?php while ($movimiento = $movimientos->fetch_assoc()){ ?>
   			<tr>
   				<td><?php echo $movimiento['movimiento']; ?> </td>
   				<td><?php echo $movimiento['usuario']; ?> </td>
   				<td><?php echo $movimiento['comentario']; ?> </td>
   				<td><?php echo explode(" ",$movimiento['registro'])[0]; ?> </td>
   			</tr>
   		<?php } ?>
   	</tbody>
  </table>
</div>