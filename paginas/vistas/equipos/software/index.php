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
	$softwares = $con->query("SELECT s.id,s.nombre as snombre,clas.nombre as clasnombre,s.fecha_max_licencia,s.version FROM software s INNER JOIN clasificaciones clas ON id_clasificacion = clas.id WHERE s.status<>0");
	

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
				<th>Clasifiación</th>
				<th>Fecha de Licencia</th>
				<th>Versión</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php while ($software = $softwares->fetch_assoc()) { ?>
				<tr>
					<td><?php echo $software['snombre']; ?></td>
					<td><?php echo $software['clasnombre']; ?></td>
					<td><?php echo $software['fecha_max_licencia']; ?></td>
					<td><?php echo $software['version']; ?></td>
					<td>
						<?php if(in_array("EDITAR", $permisosActuales)){ ?>
							<i class="fas fa-edit"  data-toggle="modal" data-target="#modal" onclick="editar(<?php echo $software['id']; ?>)"></i>
						<?php } ?>
						<?php if(in_array("ELIMINAR", $permisosActuales)){ ?>
							<i class="fa fa-trash" onclick="eliminar(<?php echo $software['id']; ?>,'<?php echo $software["snombre"] ?>')"></i>
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
		$("#modaltitulo").html("Registrar Software");
		$("#modalContenido").load("vistas/<?php echo $rutaModulo; ?>/formularios/form1.php");
	}
	function editar(id){

		$("#enviarForm").html("Enviar").removeClass('btn-success').addClass('btn-primary');
		$("#modaltitulo").html("Editar Software");
		$("#modalContenido").load("vistas/<?php echo $rutaModulo; ?>/formularios/form1.php",{id:id});
	}

	function eliminar(id,nombre){

		$("#enviarForm").html("Enviar").removeClass('btn-success').addClass('btn-primary');
		datos={
			opc:"eliminar",
			id:id
		};
		url="controladores/equipos/software.php";
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


