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
	
	$query_search = "SELECT U.Nombre AS NombreUsuario, U.Id AS IdUsuario, T.* FROM tour T 
	INNER JOIN usuario U ON T.Idusuario = U.Id";

	$query_exec = mysqli_query($GLOBALS["CONN"], $query_search);
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
			$fotousu=generarURL("/foto.php?id=".$row['IdUsuario']."&tabla=usuario");
			
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

//mysqli_select_db($database_localhost, $localhost);
?>