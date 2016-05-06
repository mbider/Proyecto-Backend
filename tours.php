<?php
require_once("conexion.php");

$query_search = "SELECT * FROM Tour";

$query_exec = mysqli_query($localhost, $query_search);

$tours = Array();

	if(mysqli_num_rows($query_exec)){
		while($row=mysqli_fetch_assoc($query_exec)){
			$id = $row["Id"];
			$tur="http://localhost/detalletour.php?id=$id";
			$foto="http://localhost/foto.php?id=$id";
			$tour = Array("Id" => $row["Id"], "Nombre" => $row["Nombre"], 
			"Usuario" => $row["Usuario"], 
			"Ubicacion" => $row["Ubicacion"], 
			"Coordenadas" => $row["Coordenadas"], 
			"FotoURL" => $foto, 
			"Likes" => $row["Likes"], 
			"Descripcion" => $row["Descripcion"],
			"DetalleURL" => $tur
			);
			array_push($tours, $tour);
		}
	}
	
	header("Content-Type: application/json");
	$json = json_encode($tours, JSON_PRETTY_PRINT);
	echo($json);
	

mysqli_close($localhost);

?>