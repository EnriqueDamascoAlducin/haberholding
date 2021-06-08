<?php
	@session_start();
	if(isset($_SESSION['usuario']) && isset($_SESSION['max-tiempo']) && isset($_SESSION['ULTIMA_ACTIVIDAD']) && (time() - $_SESSION[ 'ULTIMA_ACTIVIDAD' ] < $_SESSION['max-tiempo'])){
		$_SESSION[ 'ULTIMA_ACTIVIDAD' ] = time();
	}else{

?>
	<script type="text/javascript">
  		<?php if($_SESSION['tipo_usuario'] == 'externo'){ ?>
			location.replace("/haberholding/clientes.php");
		<?php }else{ ?>
			location.replace("/haberholding/?out");
		<?php } ?>
	</script>
<?php
	exit();
	}
?>
