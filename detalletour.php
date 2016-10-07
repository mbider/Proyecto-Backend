<?php
require_once("conexion.php");
$id = $_GET["id"];
$detalle = ListarDetalleTourAgregado($id);
if($detalle){
	json($detalle);	
	
}else{
	http_response_code(404);
	json(array("Error" => "no encontrado"));
}


mysqli_close($GLOBALS["CONN"]);
?>