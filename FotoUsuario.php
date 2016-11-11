<?php

require_once("conexion.php");

$Foto = json_decode(file_get_contents('php://input'), true);

$consulta = "UPDATE usuario SET Foto = ?  WHERE Id = ?";
$variable = base64_decode($Foto["Foto"]);
$stmt = $GLOBALS["CONN"]->prepare($consulta);
$stmt->bind_param(
	"ss",
	$variable,
	$Foto["Id"]
	
);

$res = ejecutar($stmt);

if($res){
	
	json(array("Mensaje" => "OK"));
}else{
	json(array("Mensaje" => "NO"));
}
?>
