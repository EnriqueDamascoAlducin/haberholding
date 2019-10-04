<?php
  $host = "localhost";
  $bd = "curso";
  $usr = "root";
  $pass = "enr9996.";

    $conexion = mysqli_connect($host,$usr,$pass,$bd);
    if(!$conexion){
     $conexion = "";
     echo " no conectado";
    }
?>
