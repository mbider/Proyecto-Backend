<?php
require_once("conexion.php");
session_start();
$consulta = "SELECT * FROM usuario WHERE Id=".$_SESSION["User"];
$ejecutar = mysqli_query($GLOBALS["CONN"], $consulta);
$array = Array();
if(mysqli_num_rows($ejecutar)){
	while($row=mysqli_fetch_assoc($ejecutar)){
		$id = $row["Id"];
		if($row["Foto"] == ""){
				$fotousu = "";
			}
			else{
				
				$fotousu=generarURL("/foto.php?id=".$id."&tabla=usuario");
				
			}
		$nombre = $row["Nombre"];
		$residencia = $row["Lugar_residencia"];
		
		$yo = array(
		"Id" => $id,
		"Nombre" => $nombre,
		"Residencia" => $residencia,
		"FotoURL" => $fotousu
		);
		
		array_push($array, $yo);
	}
}
		
json($array);

mysqli_close($GLOBALS["CONN"]);
?>