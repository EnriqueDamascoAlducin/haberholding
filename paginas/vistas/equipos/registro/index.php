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
	$_SESSION['idsubmodulo'] = $idsubmodulo;

	$permisosXUsuarioLoggeado = $con->query("Select ps.nombre from submodulos sub INNER JOIN permisos_submodulos ps ON ps.idsubmodulo = sub.id INNER JOIN permisos_submodulos_usuarios psu on psu.idpermiso = ps.id where psu.status <>0 and sub.status<>0 and sub.id=". $idsubmodulo." and idusuario = " . $usuario);

	$permisosActuales = array();
	while ($permiso = $permisosXUsuarioLoggeado->fetch_assoc()) {
		$permisosActuales[] = $permiso['nombre'];
	}
	include_once 'header.php';
?>
<div id="tabla" >

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
	function cargarTabla() {
		let depto = $("#filtro_deptos").val();
		let marca = $("#filtro_marca").val();
		let modelos = $("#filtro_modelos").val();
		let garantia = $("#filtro_garantia").val();
		$("#tabla").load("vistas/<?php echo $rutaModulo ?>/tabla.php",{depto:depto,marca:marca,modelos:modelos,garantia:garantia});
	}
	cargarTabla();
	$("#report-excel").on("click",function(){
		let depto = $("#filtro_deptos").val();
		let marca = $("#filtro_marca").val();
		let modelos = $("#filtro_modelos").val();
		let garantia = $("#filtro_garantia").val();
		window.open("vistas/equipos/registro/excel/general-report.php?depto="+depto+"&marca="+marca+"&modelo"+modelos+"&garantia="+garantia, '_blank');
	});

	$("#report-pdf").on("click",function(){
		let depto = $("#filtro_deptos").val();
		let marca = $("#filtro_marca").val();
		let modelos = $("#filtro_modelos").val();
		let garantia = $("#filtro_garantia").val();
		window.open("vistas/equipos/registro/pdfs/general-report.php?depto="+depto+"&marca="+marca+"&modelo"+modelos+"&garantia="+garantia , '_blank');
	});

</script>
