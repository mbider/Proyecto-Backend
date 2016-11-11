<?php
require_once("conexion.php");

$detallegusto = "SELECT * FROM gusto";

$ejecuciongusto = mysqli_query($GLOBALS["CONN"], $detallegusto);

$gustos = Array();
if(mysqli_num_rows($ejecuciongusto)){
	while($row = mysqli_fetch_array($ejecuciongusto)){
		$id = $row["Id"];
		$gusto = Array(
			"Id" => $id,
			"Gustos" =>  $row["Nombre"]
		);
		array_push($gustos,$gusto);
	}
}
json($gustos);

?>