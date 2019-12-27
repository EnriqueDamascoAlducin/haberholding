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
	$componentes = $con->query("SELECT comp.id, comp.nombre as serie, clas.nombre as clasificacion, descripcion, m.nombre as marca, mo.nombre as modelo FROM componentes comp INNER JOIN clasificaciones clas ON comp.id_clasificacion = clas.id INNER JOIN marcas m ON m.id = comp.id_marca INNER JOIN modelos mo ON mo.id = comp.id_modelo WHERE mo.status <> 0 AND m.status <> 0 AND comp.status <> 0 AND clas.status <> 0 ORDER BY comp.nombre asc, clas.nombre asc");
	

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
				<th>Serie</th>
				<th>Descripción</th>
				<th>Clasificación</th>
				<th>Marca</th>
				<th>Modelo</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php while ($componente = $componentes->fetch_assoc()) { ?>
				<tr>
					<td><?php echo $componente['serie']; ?></td>
					<td><?php echo $componente['descripcion']; ?></td>
					<td><?php echo $componente['clasificacion']; ?></td>
					<td><?php echo $componente['marca']; ?></td>
					<td><?php echo $componente['modelo']; ?></td>
					<td>
						<?php if(in_array("EDITAR", $permisosActuales)){ ?>
							<i class="fas fa-edit"  data-toggle="modal" data-target="#modal" onclick="editar(<?php echo $componente['id']; ?>)"></i>
						<?php } ?>
						<?php if(in_array("ELIMINAR", $permisosActuales)){ ?>
							<i class="fa fa-trash" onclick="eliminar(<?php echo $componente['id']; ?>,'<?php echo $componente["serie"] ?>')"></i>
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
        <button type="button" class="btn btn-primary"  id="enviarForm" onclick="enviarForm();">Enviar</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	function agregar(){

		$("#enviarForm").html("Enviar").removeClass('btn-success').addClass('btn-primary');
		$("#modaltitulo").html("Registrar Departamento");
		$("#modalContenido").load("vistas/<?php echo $rutaModulo; ?>/formularios/form1.php");
	}
	function editar(id){

		$("#enviarForm").html("Enviar").removeClass('btn-success').addClass('btn-primary');
		$("#modaltitulo").html("Editar Departamento");
		$("#modalContenido").load("vistas/<?php echo $rutaModulo; ?>/formularios/form1.php",{id:id});
	}

	function eliminar(id,nombre){

		$("#enviarForm").html("Enviar").removeClass('btn-success').addClass('btn-primary');
		datos={
			opc:"eliminar",
			id:id
		};
		url="controladores/equipos/componentes.php";
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
				    setTimeout(function(){
				      $(".swal-button").trigger("click");
				    	recargarPagina();
				    },1500);
				}
				
				
			},
			error:function(text,codigo,otro){
				console.error(codigo);
			}
		});
	}

	function puestos(id,nombre){

		$("#enviarForm").html("Enviar").removeClass('btn-success').addClass('btn-primary');

		$("#modaltitulo").html("Registrar Puesto para " + nombre );
		$("#modalContenido").load("vistas/<?php echo $rutaModulo; ?>/formularios/puestos.php",{id:id,nombre:nombre});
	}
	function recargarPagina(){
		cargarVista("<?php echo $rutaModulo ?>","<?php echo $nombreModulo ?>",<?php echo $idsubmodulo ?>);
	}
</script>


