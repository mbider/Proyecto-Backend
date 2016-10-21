<?php
require_once("conexion.php");

$Idtour = json_decode(file_get_contents('php://input'), true);

$consulta = "DELETE FROM tour WHERE Id = ?";

$stmt = $GLOBALS["CONN"]->prepare($consulta);
$id = $Idtour["Id"];
$stmt->bind_param(
	"s",
	$id
);

$res = ejecutar($stmt);

if($res){
	json(array("Id" => $id));
}else{
	
	json(array("mensaje" => "NO"));
}

mysqli_close($GLOBALS["CONN"]);
?>