<?php
require_once("conexion.php");

$texto = "%" . $_GET["q"] . "%";
$gusto = $_GET["gusto"];


$consulta = "SELECT U.Nombre AS NombreUsuario, U.Id AS IdUsuario, U.Foto AS FotoUsuario, T.* FROM tour T 
	INNER JOIN usuario U ON T.Idusuario = U.Id
	INNER JOIN gustoxtour GT ON T.Id = GT.Idtour
	INNER JOIN gusto G ON G.Id = GT.Idgusto 
	WHERE (T.Nombre LIKE ? OR T.Descripcion LIKE ? OR T.Ubicacion LIKE ?) AND (GT.Idgusto IN ($gusto)) GROUP BY T.Id";
	
if($gusto == ""){
$consulta = "SELECT U.Nombre AS NombreUsuario, U.Id AS IdUsuario, U.Foto AS FotoUsuario, T.* FROM tour T 
	INNER JOIN usuario U ON T.Idusuario = U.Id
	WHERE T.Nombre LIKE ? OR T.Descripcion LIKE ? OR T.Ubicacion LIKE ? GROUP BY T.Id";
	
$stmt = $GLOBALS["CONN"]->prepare($consulta);
$stmt->bind_param(
	"sss",
	$texto,
	$texto,
	$texto
);

$stmt->execute();
$resultado = $stmt->get_result();
	if($resultado){
		$tours = LeerTours($resultado);
		json($tours);	
	}
}else{
$stmt = $GLOBALS["CONN"]->prepare($consulta);
$stmt->bind_param(
	"sss",
	$texto,
	$texto,
	$texto
);
$stmt->execute();
$resultado = $stmt->get_result();
	if($resultado){
		$tours = LeerTours($resultado);
		json($tours);	
	}
}

mysqli_close($GLOBALS["CONN"]);

?>