<?php
require_once("conexion.php");

$info = json_decode(file_get_contents('php://input'), true);

$consulta = "Select idtour FROM likexusuario WHERE idtour = ? AND idusuario = ?";
$stmt = $GLOBALS["CONN"]->prepare($consulta);
$stmt->bind_param(
	"ss",
	$info["idtour"],
	$info["idusuario"]
);
$mandar = Array();
$res = $stmt->execute();
if($stmt->fetch()){
	$mensaje = "true";
}
else{
	$mensaje = "false";
}
$mandar["respuesta"] = $mensaje;
json($mandar);
mysqli_close($GLOBALS["CONN"]);
?>
