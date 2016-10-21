<?php
require_once("conexion.php");

$Idtour = json_decode(file_get_contents('php://input'), true);

$consulta = "DELETE  FROM tour WHERE Id = ?";

$stmt = $GLOBALS["CONN"]->prepare($consulta);
	var_dump($stmt);
$id = $Idtour["Id"];
$stmt->bind_param(
	"s",
	$id
);
 
$res = ejecutar($stmt);
$puntos = $Idtour["Puntos"];

//CONSULTA PARA Eliminar PUNTOS
foreach ($puntos as $punto) {
	$consulta2 = "DELETE FROM punto WHERE Idtour = ?";
	$res = ejecutar($stmt);
	$stmt = $GLOBALS["CONN"]->prepare($consulta2);
	$stmt->bind_param(
		"s",
		$id
	);
	
	$res = ejecutar($stmt);

}

//CONSULTA PARA Elimianar GUSTOS

$gustos = $Idtour["Gustos"];

foreach ($gustos as $gusto) {
	$consulta3 = "DELETE FROM gustoxtour WHERE Idtour = ?";
	$stmt = $GLOBALS["CONN"]->prepare($consulta3);
	$stmt->bind_param(
		"s",
		$id
	);
	$res = ejecutar($stmt);
}


if($res){
	json(array("Id" => $id));
}else{
	
	json(array("mensaje" => "NO"));
}

mysqli_close($GLOBALS["CONN"]);
?>