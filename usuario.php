<?php
require_once("conexion.php");
$usuarios = Array();
function cargarUsuario($id) {
	$query_search ="SELECT Nombre AS NombreUsuario, Id AS IdUsuario, Foto, Lugar_residencia AS Residencia FROM usuario WHERE Id=".$id;
	$query_exec = mysqli_query($GLOBALS["CONN"], $query_search);
	if(mysqli_num_rows($query_exec)) {
		$row = mysqli_fetch_assoc($query_exec);
		$id = $row['IdUsuario'];
		
		if($row['Foto'] == ""){
				$fotousu = "";
			}
			else{
				
				$fotousu=generarURL("/foto.php?id=".$id."&tabla=usuario");
				
			}
		$usuario = Array(
			"Id" => $id,
			"Nombre" =>  $row['NombreUsuario'],
			"Residencia" =>  $row['Residencia'],
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
			$fototour=generarURL("/foto.php?id=".$id."&tabla=tour");
			
			$tour = Array(
				"Id" => $id,
				"Nombre" =>  $row['NombreTour'],
				"FotoURL" => $fototour
				
			);
			
			Array_push($tours, $tour);
		}
		return $tours;
	}else
		return array();
}

function CargarToursLikeados($id){
	$consulta ="SELECT T.Id AS IdTour, T.Nombre AS NombreTour, T.Foto 
	FROM tour T INNER JOIN likexusuario lu ON T.Id = lu.idtour WHERE lu.idusuario=".$id;
	$ejecutar = mysqli_query($GLOBALS["CONN"], $consulta);	
	$likeados = Array();
	if(mysqli_num_rows($ejecutar)) {
		while($row=mysqli_fetch_assoc($ejecutar)){
			$id = $row['IdTour'];
			$fototour=generarURL("/foto.php?id=".$id."&tabla=tour");
			$likeado = Array(
				"Id" => $id,
				"Nombre" =>  $row['NombreTour'],
				"FotoURL" => $fototour
				
			);
			
			Array_push($likeados, $likeado);
		}
		return $likeados;
	}else
		return array();
	
}


$idusu = $_GET["id"];

$usuario = CargarUsuario($idusu);
$tours = CargarToursPorUsuario($idusu);
$likeados = CargarToursLikeados($idusu);

$usuario["ToursCreados"] = $tours;
$usuario["ToursLikeados"] = $likeados;
json($usuario);
?>
