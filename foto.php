<?php
require_once("conexion.php");
header("Content-Type: image/jpeg");
$_GET["id"];
$query_search = "SELECT Foto FROM Tour WHERE id=".$_GET["id"];
$query_exec = mysqli_query($localhost, $query_search);
if(mysqli_num_rows($query_exec)){
		while($row=mysqli_fetch_assoc($query_exec)){
			$foto = $row["Foto"];
		}
	}
	echo $foto;
mysqli_close($localhost);

?>