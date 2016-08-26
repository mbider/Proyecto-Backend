<?php
require_once("conexion.php");

$idgustorecibidos = $_GET["Idgusto"]; 

$consulta = "select Idtour From gustoxtour Where Idgusto IN (".$idgustorecibidos.")";
$ejecutar = mysqli_query($GLOBALS["CONN"], $consulta);

if(mysqli_num_rows($ejecutar)){
	while($row=mysqli_fetch_assoc($ejecutar)){
		$ides = Array($row['Idtour']);
	}
}

var_dump($ides);



mysqli_close($GLOBALS["CONN"]);
?>