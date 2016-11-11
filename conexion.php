<?php 

if (getenv("MYSQL_HOSTNAME") === false) {
	$GLOBALS["MYSQL_HOSTNAME"] = "localhost";
	$GLOBALS["MYSQL_USERNAME"] = "root";
	$GLOBALS["MYSQL_PASSWORD"] = "";
	$GLOBALS["MYSQL_DATABASE"] = "basenueva";
}
else {
	$GLOBALS["MYSQL_HOSTNAME"] = getenv("MYSQL_HOSTNAME");
	$GLOBALS["MYSQL_USERNAME"] = getenv("MYSQL_USERNAME");
	$GLOBALS["MYSQL_PASSWORD"] = getenv("MYSQL_PASSWORD");
	$GLOBALS["MYSQL_DATABASE"] = getenv("MYSQL_DATABASE");
}

if (array_key_exists("HTTP_HOST", $_ENV)) {
	$GLOBALS["URL_BASE"] = "http://" . $_ENV["HTTP_HOST"];
}

if (getenv("HTTP_HOST") === false) {
	$GLOBALS["URL_BASE"] = "http://localhost/Proyecto2";
}
else {
	$GLOBALS["URL_BASE"] = "http://" . getenv("HTTP_HOST");
}

function json($objeto) {
	header("Content-Type: application/json; charset=UTF-8");
	$json = json_encode($objeto, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	echo($json);
	echo("\n");
}

function listarTours(){
	
/*$TAMANO_PAGINA = 5;

if (!$pagina) {
   $inicio = 0;
   $pagina = 1;
}else {
   $inicio = ($pagina - 1) * $TAMANO_PAGINA;
}*/
	
$consulta = "SELECT U.Nombre AS NombreUsuario, U.Id AS IdUsuario, U.Foto AS FotoUsuario, T.Id AS Id, T.Nombre, T.Ubicacion,T.Foto, T.Descripcion, T.Likes, T.Idusuario 
FROM tour T 
INNER JOIN usuario U ON T.Idusuario = U.Id ORDER BY T.Id DESC ";/*LIMIT ".$inicio."," . $TAMANO_PAGINA;*/

$query_exec = mysqli_query($GLOBALS["CONN"], $consulta);
$tours = LeerTours($query_exec);
return $tours;
}

function gustosPorTour($id) {
				
	$gustos_query = "SELECT g.Id, g.Nombre FROM tour T 
		inner join gustoxtour gxt on T.Id = gxt.Idtour 
		INNER JOIN gusto g on g.Id = gxt.Idgusto
		WHERE T.Id = " . $id;
		
	$gustos_resultado = mysqli_query($GLOBALS["CONN"], $gustos_query);
	
	$gustos = array();
	
	if (mysqli_num_rows($gustos_resultado)){
		while($row = mysqli_fetch_assoc($gustos_resultado)){
			array_push($gustos, $row);
		}
	}
	
	return $gustos;
}



function LeerTours($resultado){
	$tours = Array();
	$ultimoId = -1;
	if (mysqli_num_rows($resultado)){
		while($row = mysqli_fetch_assoc($resultado)){

			$id = $row["Id"];

			$nombre=$row["Nombre"];
			$ubicacion=$row["Ubicacion"];
			$desc=$row["Descripcion"];
			
			$tur=generarURL("/detalletour.php?id=" . $id);
			$foto=generarURL("/foto.php?id=".$id."&tabla=tour");
			if(is_null($row["FotoUsuario"]) || $row["FotoUsuario"] == "" || $row["FotoUsuario"] == "hola" ){
				$fotousu = "";
			}
			else{
				$fotousu = generarURL("/foto.php?id=".$row['IdUsuario']."&tabla=usuario");
			}
			
			$usuario = Array(
				"Id" => $row["IdUsuario"],
				"Nombre" =>  $row["NombreUsuario"],
				"FotoURL"=>$fotousu
			);
						
			$tour = Array(
				"Id" => $id,
				"Nombre" =>$nombre, 
				"Ubicacion"=>$ubicacion,
				"FotoURL" => $foto,
				"Likes" => $row["Likes"], 
				"Descripcion"=>$desc,
				"DetalleURL" => $tur,
				"Usuario"=>$usuario,
				"Gustos"=>gustosPorTour($id)
			);
					
			array_push($tours, $tour);				
		}
	}
	return $tours;
}

function ListarDetalleTourAgregado($id){
	
	$detalletour = "SELECT * FROM tour WHERE id=".$id;

	$detallegusto = "SELECT G.Nombre AS NombreGusto, G.Id AS IdGusto FROM gustoxtour GT INNER JOIN gusto G ON G.Id = GT.Idgusto WHERE GT.Idtour=".$id;
	$detalleusuario = "SELECT U.Nombre AS NombreUsuario, U.Id AS IdUsuario, U.Foto AS Foto
					FROM tour T 
					INNER JOIN usuario U 
					ON T.Idusuario = U.Id WHERE T.id=".$id;
	$detallepunto = "SELECT P.Nombre AS NombrePunto, P.Dia AS DiaPunto, P.Id AS IdPunto, P.Descripcion AS DescripcionPunto, P.Direccion AS DireccionPunto, P.Latitud, P.Longitud
					FROM punto P 
					INNER JOIN tour T 
					ON P.Idtour = T.Id WHERE P.Idtour=".$id." ORDER BY P.Dia";

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
			if($row["Foto"] == ""){
				$fotousu = "";
			}
			else{
				$fotousu = generarURL("/foto.php?id=".$row['IdUsuario']."&tabla=usuario");
			}
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
		return $tour;
	}else{
		return null;
	}
	
}

function ejecutar($stmt) {
	$res = $stmt->execute();
	
	if ($res) {
		$cant = $stmt->affected_rows;
		if($cant > 0){
			
			$res = 1;
		}else{
			
			$res = 0
;		}
		return $res;
	} else {
		http_response_code(500);
		json(array("Error" => $stmt->error));
		die();
	}
}

function generarURL($relativo) {
	return $GLOBALS["URL_BASE"] . $relativo;
}

$GLOBALS["CONN"] = mysqli_connect(
	$GLOBALS["MYSQL_HOSTNAME"],
	$GLOBALS["MYSQL_USERNAME"],
	$GLOBALS["MYSQL_PASSWORD"],
	$GLOBALS["MYSQL_DATABASE"]
);

mysqli_query($GLOBALS["CONN"], "set names 'utf8'");

function shutdown() {
	mysqli_close($GLOBALS["CONN"]);
}

register_shutdown_function("shutdown");

//mysqli_select_db($database_localhost, $localhost);
?>