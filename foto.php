<?php
require_once("conexion.php");
$id=$_GET["id"];
$tabla=$_GET["tabla"];
$query = "SELECT Foto FROM ".$tabla." WHERE id=".$_GET["id"];
$query_exec = mysqli_query($localhost, $query);
if(mysqli_num_rows($query_exec)){
	$row=mysqli_fetch_assoc($query_exec);
	$foto = $row["Foto"];
}

header("Content-Type: image/jpeg");
echo $foto;
mysqli_close($localhost);

?>