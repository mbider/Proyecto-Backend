<?php
require_once("conexion.php");}

	$Tour = json_decode($string, true);
	$consulta = "INSERT INTO tour (Id,Nombre,Ubicacion,Foto,Likes,Descripcion,Idusuario) values (?, ?, ?, ?, ?, ?, ?)";
	$stmt = $GLOBALS["CONN"]->prepare($consulta);
	$stmt->bind_param(
	
	"ssssss",
	$Tour["Id"],
	$Tour["Nombre"],
	$Tour["Fecha"],
	$Tour["Foto"],
	$Tour["Descripcion"],
	$Tour["Likes"],
	$Tour["Idusuario"]
);
	$stmt->execute();
	$res = $stmt->get_result();
	
mysqli_close($GLOBALS["CONN"]);
?>
	