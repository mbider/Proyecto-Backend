<?php
require_once("conexion.php");
$id = $_GET["id"];
$detalle = ListarDetalleTourAgregado($id);
json($detalle);	

mysqli_close($GLOBALS["CONN"]);
?>