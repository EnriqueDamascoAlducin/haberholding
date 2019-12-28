<?php  

	// Zona horaria
		date_default_timezone_set('America/Mexico_City');
	//
	include_once '../../../controladores/finsession.php';
	include_once '../../../controladores/conexion.php';
	$nombreModulo = $_POST['nombre'];
	$rutaModulo = $_POST['ruta'];
	$idsubmodulo = $_POST['id'];
	$usuario = $_SESSION['usuario'];
	$equipos = $con->query("SELECT e.status, e.id as id ,clas.nombre as clasificacion,e.serie, modelos.nombre as mod_nombre ,marcas.nombre as mar_nombre, fecha_max_garantia as garantia FROM equipos e INNER JOIN marcas ON marcas.id = e.id_marca INNER JOIN modelos ON modelos.id = e.id_modelo INNER JOIN clasificaciones clas on e.clasificacion = clas.id WHERE e.status<>0 ORDER BY e.serie asc, e.id  ");

	$permisosXUsuarioLoggeado = $con->query("Select ps.nombre from submodulos sub INNER JOIN permisos_submodulos ps ON ps.idsubmodulo = sub.id INNER JOIN permisos_submodulos_usuarios psu on psu.idpermiso = ps.id where psu.status <>0 and sub.status<>0 and sub.id=". $idsubmodulo." and idusuario = " . $usuario);
	
	$permisosActuales = array();
	while ($permiso = $permisosXUsuarioLoggeado->fetch_assoc()) {
		$permisosActuales[] = $permiso['nombre'];
	}
	include_once 'header.php';
?>
<div id="tabla" >
	<table class="table DataTable">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Serie</th>
				<th>Modelo</th>
				<th>Marca</th>
				<th>Estatus</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php while ($equipo = $equipos->fetch_assoc()) { ?>
				<tr>
					<td><?php echo $equipo['clasificacion']; ?></td>
					<td><?php echo $equipo['serie']; ?></td>
					<td><?php echo $equipo['mod_nombre']; ?></td>
					<td><?php echo $equipo['mar_nombre']; ?></td>
					<td>
						<?php 
							if($equipo['status']==1){
								echo "Sin Asignar";
							}elseif($equipo['status']==2){
								echo "Asignado";
							}elseif($equipo['status']==3){
								echo "En reparación";
							}elseif($equipo['status']==4){
								echo "En Garantía";
							}elseif($equipo['status']==5){
								echo "Deshabilitado";
							}
						?>
							
					</td>
					
					<td>
						<?php if(in_array("EDITAR", $permisosActuales)){ ?>
							<i class="fas fa-edit"  data-toggle="modal" data-target="#modal" onclick="editar(<?php echo $equipo['id']; ?>)"></i>
						<?php } ?>
						<?php if(in_array("ELIMINAR", $permisosActuales)){ ?>
							<i class="fa fa-trash" data-toggle="modal" data-target="#modal" onclick="opcionesEliminar(<?php echo $equipo['id']; ?>,'<?php echo $equipo["serie"] ?>')"></i>
						<?php } ?>
						<?php if(in_array("COMPONENTES", $permisosActuales)){ ?>
							<i class="fas fa-print" data-toggle="modal" data-target="#modal" onclick="componentes(<?php echo $equipo['id']; ?>)" ></i>
						<?php } ?>
						<?php if(in_array("SOFTWARE", $permisosActuales)){ ?>
							<i class="fas fa-code" data-toggle="modal" data-target="#modal" onclick="software(<?php echo $equipo['id']; ?>)" ></i>
						<?php } ?>
						<?php if(in_array("BITACORA", $permisosActuales)){ ?>
							<i class="fas fa-book-open" data-toggle="modal" data-target="#modal" onclick="bitacora(<?php echo $equipo['id']; ?>)" ></i>
						<?php } ?>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitulo"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalContenido">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary"  onclick="enviarForm();">Enviar</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	function agregar(){
		$("#modaltitulo").html("Registrar Equipo");
		$("#modalContenido").load("vistas/<?php echo $rutaModulo; ?>/formularios/form1.php");
	}
	function editar(id){
		$("#modaltitulo").html("Editar Equipo");
		$("#modalContenido").load("vistas/<?php echo $rutaModulo; ?>/formularios/form1.php",{id:id});
	}
	function componentes(id){
		$("#modaltitulo").html("Añadir Componentes");
		$("#modalContenido").load("vistas/<?php echo $rutaModulo; ?>/formularios/componentes.php",{id:id});
	}
	function software(id){
		$("#modaltitulo").html("Añadir Software");
		$("#modalContenido").load("vistas/<?php echo $rutaModulo; ?>/formularios/software.php",{id:id});
	}
	function bitacora(id){
		$("#modaltitulo").html("Bitácora ");
		$("#modalContenido").load("vistas/<?php echo $rutaModulo; ?>/formularios/bitacora.php",{id:id});
	}
	function opcionesEliminar(id,nombre){

		$("#modaltitulo").html("Eliminar " + nombre);
		$("#modalContenido").load("vistas/<?php echo $rutaModulo; ?>/formularios/opcionesEliminar.php",{id:id,nombre:nombre});
	}
	function eliminar(id,nombre,status){
		datos={
			opc:"eliminar",
			id:id,
			status:status,
			nombre:nombre
		};
		url="controladores/equipos/controlador.php";
		$.ajax({
			data:datos,
			url:url,
			type:'POST',
			beforeSend:function(){
				swal({
			      title: "Eliminando",
			      text: "Eliminando "+ nombre,
			      icon: "success",
			    });
				$("body").prop("disabled","disabled");
			},
			success:function(respuesta){
					$(".modal").modal("hide");
				$("body").prop("disabled",false);
				$(".swal-button").trigger("click");
				if(respuesta == "Error"){
					swal({
				      title: respuesta,
				      text:  nombre + " no se pudo eliminar " ,
				      icon: "error",
			    	});
				}else{
					swal({
				      title: "Eliminado",
				      text:  nombre + " fue Eliminado " + respuesta,
				      icon: "success",
				    });
				}
			    setTimeout(function(){
			     // $(".swal-button").trigger("click");
			    	recargarPagina();
			    },1500);
			},
			error:function(text,codigo,otro){
				console.error(codigo);
			}
		});
	}
	function recargarPagina(){
		cargarVista("<?php echo $rutaModulo ?>","<?php echo $nombreModulo ?>",<?php echo $idsubmodulo ?>);
	}
</script>