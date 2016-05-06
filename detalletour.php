<?php
require_once("conexion.php");
$_GET["id"];
$query_search = "SELECT * FROM Tour WHERE id=".$_GET["id"];
$query_exec = mysqli_query($localhost, $query_search);


if(mysqli_num_rows($query_exec)){
	$row=mysqli_fetch_assoc($query_exec);
	$id = $row["Id"];
	$foto = "http://localhost/foto.php?id=$id";
	$tour = Array(
		"Id" => $id, 
		"Nombre" => $row["Nombre"], 
		"Usuario" => $row["Usuario"], 
		"Ubicacion" => $row["Ubicacion"], 
		"Foto" => $foto, 
		"Coordenadas" => $row["Coordenadas"], 
		"Likes" => $row["Likes"], 
		"Descripcion" => $row["Descripcion"]
	);	
}

header("Content-Type: application/json");
$json = json_encode($tour, JSON_PRETTY_PRINT);
echo($json);

mysqli_close($localhost);

?>