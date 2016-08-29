<?php
require_once("conexion.php");

$texto = "%" . $_GET["q"] . "%";

$consulta = "SELECT U.Nombre AS NombreUsuario, U.Id AS IdUsuario, T.* FROM tour T 
	INNER JOIN usuario U ON T.Idusuario = U.Id 
 WHERE T.Nombre LIKE ? OR T.Descripcion LIKE ? OR T.Ubicacion LIKE ?";
	
$stmt = $GLOBALS["CONN"]->prepare($consulta);
$stmt->bind_param(
	"sss",
	$texto,
	$texto,
	$texto
);
$stmt->execute();
$resultado = $stmt->get_result();
$tours = LeerTours($resultado);
json($tours);


mysqli_close($GLOBALS["CONN"]);

?>