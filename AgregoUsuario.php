<?php
require_once("conexion.php");}

	$Tour = json_decode($string, true);
	$consulta = "INSERT INTO usuario (Id,Nombre,Foto,Likes,Lugar_residencia,Email,Contraseña) values (?, ?, ?, ?, ?, ?, ?)";
	$stmt = $GLOBALS["CONN"]->prepare($consulta);
	$stmt->bind_param(
	
	"sssssss",
	$Tour["Id"],
	$Tour["Nombre"],
	$Tour["Foto"],
	$Tour["Likes"],
	$Tour["Lugar_residencia"],
	$Tour["Email"],
	$Tour["Contraseña"]
);
	$stmt->execute();
	$res = $stmt->get_result();
	
?>
	