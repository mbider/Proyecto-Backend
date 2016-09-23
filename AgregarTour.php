<?php
require_once("conexion.php");

$Tour = json_decode(file_get_contents('php://input'), true);

mysqli_begin_transaction($GLOBALS["CONN"]);

//CONSULTA PARA INSERTAR TOURS
$consulta1 = "INSERT INTO tour (Nombre,Ubicacion,foto,Descripcion,Likes,Idusuario) values (?, ?, ?, ?, ?, ?)";
$stmt = $GLOBALS["CONN"]->prepare($consulta1);
$stmt->bind_param(
	"ssssss",
	$Tour["Nombre"],
	$Tour["Ubicacion"],
	$Tour["Foto"],
	$Tour["Descripcion"],
	$Tour["Likes"],
	$Tour["Idusuario"]
);

$res = $stmt->execute();
$id = $stmt->insert_id;
$puntos = $Tour["Puntos"];
//CONSULTA PARA INSERTAR TOURS
foreach ($puntos as $punto) {
	$consulta2 = "INSERT INTO punto (Longitud,Latitud,Foto,Direccion,Nombre,Idtour,Descripcion,Dia) 
	values (?, ?, ?, ?, ?, ?, ?, ?)";
	$stmt = $GLOBALS["CONN"]->prepare($consulta2);
	$stmt->bind_param(
		"ssssssss",
		$punto["Longitud"], $punto["Latitud"],$punto["Foto"],$punto["Direccion"],$punto["Nombre"],$id,
		$punto["Descripcion"], $punto["Dia"]
	);
	$res = $stmt->execute();
}

//CONSULTA PARA INSERTAR GUSTOS

$gustos = $Tour["Gustos"];

foreach ($gustos as $gusto) {
	$consulta3 = "INSERT INTO gustoxtour (Idtour,Idgusto) values (?,?)";
	$stmt = $GLOBALS["CONN"]->prepare($consulta3);
	
	$stmt->bind_param(
		"ss",
		$id, $gusto["Idgusto"]
	);
	$res = $stmt->execute();
}

mysqli_commit($GLOBALS["CONN"]);

$errores = $stmt->error;
if($res){
	json(Array("id" => $id));
} else {
	json(Array("Error" => "No se agrego correctamente"));
}

	
mysqli_close($GLOBALS["CONN"]);
?>
	