<?php
require_once("conexion.php");

$query_search = "SELECT U.Nombre AS NombreUsuario, U.Id AS IdUsuario, T.*, g.Id AS IdGusto, g.Nombre AS NombreGusto FROM tour T 
INNER JOIN usuario U ON T.Idusuario = U.Id inner join gustoxtour gxt on t.Id = gxt.Idtour 
INNER JOIN gusto g on g.Id = gxt.Idgusto";
						
$query_exec = mysqli_query($GLOBALS["CONN"], $query_search);
$tours = Array();
$ultimoId = -1;
	if(mysqli_num_rows($query_exec)){
		while($row=mysqli_fetch_assoc($query_exec)){
			if($ultimoId != $row["Id"]){
				$nombre=$row["Nombre"];
				$ubicacion=$row["Ubicacion"];
				$desc=$row["Descripcion"];
				$id = $row["Id"];
				$tur=generarURL("/detalletour.php?id=" . $id);
				$foto=generarURL("/foto.php?id=".$id."&tabla=tour");
				
				$fotousu=generarURL("/foto.php?id=".$row['IdUsuario']."&tabla=usuario");
				
				$usuario = Array(
							"Id" => $row["IdUsuario"],
							"Nombre" =>  $row["NombreUsuario"],
							"FotoURL"=>$fotousu
				);
				
				$gustos = Array();
				$query_exec2 = mysqli_query($GLOBALS["CONN"], $query_search);
				while($row2=mysqli_fetch_assoc($query_exec2)){
					if($row2["Id"] == $id){
						$gusto = Array(
									"Id" => $row2["IdGusto"],
									"Nombre" =>  $row2["NombreGusto"]
						);
						array_push($gustos, $gusto);
					}
				}
				
				$tour = Array(
				"Id" => $id,
				"Nombre" =>$nombre, 
				"Ubicacion"=>$ubicacion,
				"FotoURL" => $foto,
				"Likes" => $row["Likes"], 
				"Descripcion"=>$desc,
				"DetalleURL" => $tur,
				"Usuario"=>$usuario,
				"Gusto"=>$gustos
				);
				array_push($tours, $tour);
				$ultimoId = $id;
			}
		}
	}
	header("Content-Type: application/json; charset=UTF-8");
	$json = json_encode($tours, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	echo($json);

mysqli_close($GLOBALS["CONN"]);
?>