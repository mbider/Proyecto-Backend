<?php
require_once("conexion.php");

$Tour = json_decode(file_get_contents('php://input'), true);

$consulta = "SELECT Id FROM usuario WHERE Contraseña = ? AND Email = ?";
$stmt = $GLOBALS["CONN"]->prepare($consulta);
$stmt->bind_param(
"ss",
$Tour["Contraseña"],
$Tour["Email"]
);
$stmt->execute();
$stmt->bind_result($id);

if ($stmt->fetch()) {
	json(Array("Id" => strval($id)));
	session_start();
	$_SESSION["User"] = $id;
	
} else {
	json(Array("Error" => "No existe el usuario"));
}
$res = $stmt->get_result();
	
	

?>
	