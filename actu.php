<?php
require_once("conexion.php");

$actualizacion = json_decode(file_get_contents('php://input'), true);

$consulta = "UPDATE tour SET Likes = ? WHERE Id= ?";
$stmt = $GLOBALS["CONN"]->prepare($consulta);
$stmt->bind_param(
	"ss",
	$actualizacion["Likes"],
	$actualizacion["Id"]
);
$res = $stmt->execute();
if ($res) {
	json(Array("Actualizacion" => "Se actualizo el like correctamente"));
} else {
	
	json(Array("Actualizacion" => "No se pudo actualizar el like"));
}
	
?>