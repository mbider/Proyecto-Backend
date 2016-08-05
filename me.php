<?php
require_once("conexion.php");
session_start();
$consulta = "SELECT Nombre FROM usuario WHERE Id=".$_SESSION["User"];
$ejecutar = mysqli_query($GLOBALS["CONN"], $consulta);
if(mysqli_num_rows($ejecutar)){
	while($row=mysqli_fetch_assoc($ejecutar)){
		$nombre = $row["Nombre"];
	}
}
json(Array("Mensaje" => "Bienvenido ".$nombre));
mysqli_close($GLOBALS["CONN"]);
?>