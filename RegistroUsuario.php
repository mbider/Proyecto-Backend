<?php
require_once("conexion.php");

$Usuario = json_decode(file_get_contents('php://input'), true);

$consulta = "INSERT INTO usuario (Nombre,Lugar_residencia,Email,Contraseña) VALUES (?, ?, ?, ?)";
$stmt = $GLOBALS["CONN"]->prepare($consulta);
$stmt->bind_param(

	"ssss",
	$Usuario["Nombre"],
	$Usuario["Lugar_residencia"],
	$Usuario["Email"],
	$Usuario["Contraseña"]
);
$stmt->execute();
$res = $stmt->get_result();
$Registro = array("Id" => $GLOBALS["CONN"]->insert_id);
header("Content-Type: application/json; charset=UTF-8");
$json = json_encode($Registro, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo($json);
mysqli_close($GLOBALS["CONN"]);
?>
	