<?php

require_once("conexion.php");

$tours = listarTours();
json($tours);	
	
mysqli_close($GLOBALS["CONN"]);
?>

