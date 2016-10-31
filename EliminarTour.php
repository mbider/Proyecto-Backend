<?php
require_once("conexion.php");

$Idtour = json_decode(file_get_contents('php://input'), true);

$consulta = "DELETE  FROM tour WHERE Id = ?";

$stmt = $GLOBALS["CONN"]->prepare($consulta);
$id = $Idtour["id"];
$stmt->bind_param(
	"s",
	$id
);
 
$res = ejecutar($stmt);
$puntoid = $id;

//CONSULTA PARA Eliminar PUNTOS
	$consulta2 = "DELETE FROM punto WHERE Idtour = ?";
	$res = ejecutar($stmt);
	$stmt = $GLOBALS["CONN"]->prepare($consulta2);
	$stmt->bind_param(
		"s",
		$puntoid
	);
	
	$res = ejecutar($stmt);
//CONSULTA PARA Elimianar GUSTOS

	$gustos = $id;

	$consulta3 = "DELETE FROM gustoxtour WHERE Idtour = ?";
	$stmt = $GLOBALS["CONN"]->prepare($consulta3);
	$stmt->bind_param(
		"s",
		$gustos
	);
	$res = ejecutar($stmt);



if($res){
	json(array("Id" => $id));
}else{
	
	json(array("mensaje" => "NO"));
}

mysqli_close($GLOBALS["CONN"]);
?>