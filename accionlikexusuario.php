<?php
require_once("conexion.php");
$informacion = json_decode(file_get_contents('php://input'), true);

if($informacion["accion"]== "eliminar"){
	$consulta = "DELETE FROM likexusuario WHERE idtour = ? AND idusuario = ?";
	$stmt = $GLOBALS["CONN"]->prepare($consulta);
	$stmt->bind_param(
		"ss",
		$informacion["idtour"],
		$informacion["idusuario"]
	);
	$accion = Array();
	$res = $stmt->execute();
	if($stmt->affected_rows > 0){
		$mensaje = "eliminado";
	}
	else{
		$mensaje = "hubo un error";
	}
	$accion["accion"] = $mensaje;
	json($accion);
}
if($informacion["accion"]== "insertar"){
	$consulta = "INSERT INTO likexusuario (idtour,idusuario) VALUES (?,?)";
	$stmt = $GLOBALS["CONN"]->prepare($consulta);
	$stmt->bind_param(
		"ss",
		$informacion["idtour"],
		$informacion["idusuario"]
	);
	$accion = Array();
	$res = $stmt->execute();
	if($stmt->affected_rows > 0){
	$mensaje = "insertado";
	}
	else{
		$mensaje = "hubo un error";
	}
	$accion["accion"] = $mensaje;
	json($accion);
}
	
mysqli_close($GLOBALS["CONN"]);	
	
?>