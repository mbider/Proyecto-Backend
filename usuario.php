<?php
require_once("conexion.php");
$usuarios = Array();
function cargarUsuario($id) {
	$query_search ="SELECT Nombre AS NombreUsuario, Id AS IdUsuario FROM usuario WHERE Id=".$id;
	$query_exec = mysqli_query($GLOBALS["CONN"], $query_search);
	if(mysqli_num_rows($query_exec)) {
		$row = mysqli_fetch_assoc($query_exec);
		$id = $row['IdUsuario'];
		$fotousu="http://localhost/Proyecto2/foto.php?id=".$id."&tabla=usuario";
		$usuario = Array(
			"Id" => $id,
			"Nombre" =>  $row['NombreUsuario'],
			"FotoURL" => $fotousu
		);
		
		return $usuario;
	}
}

function cargarToursPorUsuario($id) {
	$query_search2 ="SELECT Nombre AS NombreTour , Id AS IdTour FROM tour WHERE Idusuario=".$id;
	$query_exec2 = mysqli_query($GLOBALS["CONN"], $query_search2);	
	$tours= Array();
	if(mysqli_num_rows($query_exec2)) {
		while($row=mysqli_fetch_assoc($query_exec2)){
			$id = $row['IdTour'];
			$fototour="http://localhost/Proyecto2/foto.php?id=".$id."&tabla=tour";
			$tour = Array(
				"Id" => $id,
				"Nombre" =>  $row['NombreTour'],
				"FotoURL" => $fototour
			);
			
			Array_push($tours, $tour);
		}
		return $tours;
	}
}


// ---

$idusu = $_GET["id"];

$usuario = CargarUsuario($idusu);
$tours   = CargarToursPorUsuario($idusu);

$usuario["Tours"] = $tours;

json($usuario);
?>