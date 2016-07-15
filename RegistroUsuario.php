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
$res = $stmt->execute();

if ($res) {		
	$Registro = array("Id" => $GLOBALS["CONN"]->insert_id);
	json($Registro);
}
else {
	$codigo = mysqli_errno($GLOBALS["CONN"]);
	
	if ($codigo == 1062) {
		$mensaje = "El email ya existe.";
	}
	else {
		$mensaje = mysqli_error($GLOBALS["CONN"]);
	}
	http_response_code(500);
	json(Array("Error" => $mensaje));
}

mysqli_close($GLOBALS["CONN"]);
?>