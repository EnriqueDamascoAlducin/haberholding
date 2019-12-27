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
	$usuarios = $con->query("Select id_usu as id, CONCAT(IFNULL(nombre_usu,''),' ',IFNULL(apellidop_usu,''), ' ',IFNULL(apellidom_usu,'')) as nombre, nombre_depto, nombre_puesto,ingreso_usu,noempleado_usu as noempleado FROM usuarios u Inner join departamentos on u.depto_usu = id_depto INNER JOIN puestos on u.puesto_usu = id_puesto WHERE status_usu<>0");
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
				<th>No. Empleado</th>
				<th>Nombre</th>
				<th>Departamento</th>
				<th>Puesto</th>
				<th>Antigüedad</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php while ($usuario = $usuarios->fetch_assoc()) { ?>
				<tr>
					<td><?php echo $usuario['noempleado']; ?></td>
					<td><?php echo $usuario['nombre']; ?></td>
					<td><?php echo $usuario['nombre_depto']; ?></td>
					<td><?php echo $usuario['nombre_puesto']; ?></td>
					<td><?php 
 						$date1 = strtotime($usuario['ingreso_usu']);  // convierte a segundos
						$date2 = strtotime(date("d-m-Y H:i:00",time())); // convierte a segundos
						$diff = abs($date2 - $date1);  
						$años = floor($diff / (365*60*60*24));  //redonde a un numero entetero mas bajo 4.3 años lo redonde a 4
						$meses = floor(($diff - $años * 365*60*60*24) 
                               / (30*60*60*24));  
						$dias = floor(($diff - $años * 365*60*60*24 -  
					             $meses*30*60*60*24)/ (60*60*24));
						if($años>0){
							if($años==1){
								if($meses>1){
									printf("%d año, %d meses, %d dias ", $años, $meses, $dias);
								}elseif($meses==1){
									printf("%d año, %d mes, %d dias ", $años, $meses, $dias);
								}else{
									printf("%d año,  %d dias ", $años, $dias);
								}
							}else{
								printf("%d años, %d meses, %d dias ", $años, $meses, $dias);
							}
						}elseif($meses>0){
							printf("%d meses, %d dias ", $meses, $dias);
						}else{
							printf(" %d dias ", $dias);
						
						}
					 ?></td>
					<td>
						<?php if(in_array("EDITAR", $permisosActuales)){ ?>
							<i class="fas fa-edit"  data-toggle="modal" data-target="#modal" onclick="editarUsuario(<?php echo $usuario['id']; ?>)"></i>
						<?php } ?>
						<?php if(in_array("EQUIPOS", $permisosActuales)){ ?>
							<i class="fas fa-desktop"></i>
						<?php } ?>
						<?php if(in_array("ELIMINAR", $permisosActuales)){ ?>
							<i class="fa fa-trash" onclick="eliminarUsuario(<?php echo $usuario['id']; ?>,'<?php echo $usuario["nombre"] ?>')"></i>
						<?php } ?>
						<?php if(in_array("PERMISOS", $permisosActuales)){ ?>
							<i class="fa fa-cog" onclick="asignarPermiso(<?php echo $usuario['id']; ?>,'<?php echo $usuario["nombre"] ?>')"></i>
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
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="enviarForm();">Enviar</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	function agregarUsuario(){
		$("#modaltitulo").html("Agregar Usuario");
		$("#modalContenido").load("vistas/<?php echo $rutaModulo; ?>/formularios/form1.php");
	}
	function asignarPermiso(usuario,nombre){
		$("#contenidoPrincipal").load("vistas/<?php echo $rutaModulo; ?>/formularios/permisos.php",{usuario:usuario,nombre:nombre});
	}
	function editarUsuario(id){
		$("#modaltitulo").html("Editar Usuario");
		$("#modalContenido").load("vistas/<?php echo $rutaModulo; ?>/formularios/form1.php",{id:id});
	}

	function eliminarUsuario(idusu,nombreusu){
		datos={
			opc:"eliminar",
			usuario:idusu
		};
		url="controladores/usuarios/controlador.php";
		$.ajax({
			data:datos,
			url:url,
			type:'POST',
			beforeSend:function(){
				swal({
			      title: "Eliminando",
			      text: "Eliminando "+ nombreusu,
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
				      text:  nombreusu + " no se pudo eliminar " ,
				      icon: "error",
			    	});
				}else{
					swal({
				      title: "Eliminado",
				      text:  nombreusu + " fue Eliminado " + respuesta,
				      icon: "success",
				    });
				}
				
				recargarPagina();
				$(".swal-button").trigger("click");
			},
			error:function(text,codigo,otro){
				console.error(codigo);
			}
		});
	}
	function recargarPagina(){
		$(".modal").modal("hide");
		cargarVista("<?php echo $rutaModulo ?>","<?php echo $nombreModulo ?>",<?php echo $idsubmodulo ?>);
	}
</script>


