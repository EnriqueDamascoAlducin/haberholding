<?php
	$servidor = "172.17.0.1";
	$usuario  = "root";
	$pass	  = "mysql";
	$db		  = "haberholding";
	$con = mysqli_connect($servidor,$usuario,$pass,$db,'3310') or die("Error de bd");

?>
