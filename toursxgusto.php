<?php
require_once("conexion.php");
$recibidos = $_GET["Idgusto"];

$consulta = "SELECT T.Id, T.Nombre,T.Ubicacion,T.Foto, T.Descripcion, T.Likes, U.Nombre AS NombreUsuario, U.Id AS IdUsuario From tour T 
INNER JOIN gustoxtour GT ON T.Id = GT.Idtour
INNER JOIN gusto G ON G.Id = GT.Idgusto 
INNER JOIN usuario U ON T.Idusuario = U.Id 
Where GT.Idgusto IN (".$recibidos.") GROUP BY GT.Idtour";
$stmt = $GLOBALS["CONN"]->prepare($consulta);
$res=$stmt->execute();
$resultado = $stmt->get_result();

/*$cant = mysqli_num_rows($resultado);
var_dump($cant);*/

if($resultado){
	$tours = LeerTours($resultado);
	json($tours);	
}
?>