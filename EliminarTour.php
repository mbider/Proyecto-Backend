<?php
require_once("conexion.php");

$array = json_decode(file_get_contents('php://input'), true);

$Idtour = $array["id"];

if($Idtour > 0){
$consulta = "DELETE  FROM tour WHERE Id = ?";

$stmt = $GLOBALS["CONN"]->prepare($consulta);
$stmt->bind_param(
	"s",
	$Idtour
);
 
$res = ejecutar($stmt);

//CONSULTA PARA Eliminar PUNTOS
	$consulta2 = "DELETE FROM punto WHERE Idtour = ?";
	$res = ejecutar($stmt);
	$stmt = $GLOBALS["CONN"]->prepare($consulta2);
	$stmt->bind_param(
		"s",
		$Idtour
	);
	
	$res = ejecutar($stmt);
//CONSULTA PARA Elimianar GUSTOS

	$consulta3 = "DELETE FROM gustoxtour WHERE Idtour = ?";
	$stmt = $GLOBALS["CONN"]->prepare($consulta3);
	$stmt->bind_param(
		"s",
		$Idtour
	);
	$res = ejecutar($stmt);
	if($res){
		json(array("Id" => $Idtour));
	}else{
		json(array("mensaje" => "NO"));
		
	}
}else{
		json(array("mensaje" => "NO"));
	
}
?>