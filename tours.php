<?php

require_once("conexion.php");
$pagina = $_GET["Pagina"];
$tours = listarTours($pagina);
json($tours);
	
mysqli_close($GLOBALS["CONN"]);
?>

