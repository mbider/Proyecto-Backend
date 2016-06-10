<?php
require_once("conexion.php");

$detalletour = "SELECT * FROM tour WHERE id=".$_GET["id"];

$detallegusto = "SELECT G.Nombre AS NombreGusto, G.Id AS IdGusto FROM gustoxtour GT INNER JOIN gusto G ON G.Id = GT.Idgusto WHERE GT.Idtour =".$_GET["id"];
$detalleusuario = "SELECT U.Nombre AS NombreUsuario, U.Id AS IdUsuario
				FROM tour T 
				INNER JOIN usuario U 
				ON T.Idusuario = U.Id WHERE T.id=".$_GET["id"];
$detallepunto = "SELECT P.Nombre AS NombrePunto, P.Dia AS DiaPunto, P.Id AS IdPunto, P.Descripcion AS DescripcionPunto, P.Direccion AS DireccionPunto, P.Latitud, P.Longitud
				FROM punto P 
				INNER JOIN tour T 
				ON P.Idtour = T.Id WHERE P.Idtour=".$_GET["id"];

$ejecucionpunto = mysqli_query($GLOBALS["CONN"], $detallepunto);				
$ejecucionusuario = mysqli_query($GLOBALS["CONN"], $detalleusuario);
$ejecuciondetalle = mysqli_query($GLOBALS["CONN"], $detalletour);
$ejecuciongusto = mysqli_query($GLOBALS["CONN"], $detallegusto);
$puntos = Array();
	if(mysqli_num_rows($ejecucionpunto)){
		while($row=mysqli_fetch_assoc($ejecucionpunto)){
		$id = $row['IdPunto'];
		$fotopunto = generarURL("/foto.php?id=".$row['IdPunto']."&tabla=punto");
		$punto = Array(
			"Id" => $id, 
			"Direccion" => $row['DireccionPunto'], 
			"Nombre" => $row['NombrePunto'], 
			"Descripcion" => $row['DescripcionPunto'],
			"FotoURL" => $fotopunto,
			"Latitud" => $row['Latitud'],
			"Longitud" => $row['Longitud'],
			"Dia" => $row['DiaPunto']
			);
			array_push($puntos,$punto);
		}	
}
$gustos = Array();
if(mysqli_num_rows($ejecuciongusto)){
	while($row = mysqli_fetch_array($ejecuciongusto)){
		$id = $row['IdGusto'];
		$gusto = Array(
			"Id" => $id,
			"Gustos" =>  $row["NombreGusto"]
		);
		array_push($gustos,$gusto);
	}
}
$usuarios = Array();
if(mysqli_num_rows($ejecucionusuario)){
	while($row = mysqli_fetch_array($ejecucionusuario)){
		$id = $row['IdUsuario'];
		$fotousu = generarURL("/foto.php?id=".$row['IdUsuario']."&tabla=usuario");
		$usuario = Array(
			"Id" => $id,
			"Nombre" => $row["NombreUsuario"],
			"FotoURL"=>$fotousu
		);
		array_push($usuarios,$usuario);
	}
}

if(mysqli_num_rows($ejecuciondetalle)){
	$row=mysqli_fetch_assoc($ejecuciondetalle);
	$id = $row["Id"];
	$foto = generarURL("/foto.php?id=".$row['Id']."&tabla=tour");
	$tour = Array(
		"Id" => $id, 
		"Nombre" => $row["Nombre"], 
		"Ubicacion" => $row["Ubicacion"], 
		"Foto" => $foto,
		"Likes" => $row["Likes"], 
		"Descripcion" => $row["Descripcion"],
		"Gustos" => $gustos,
		"Usuario" => $usuario,
		"Puntos" => $puntos
	);
	json($tour);
}

?>