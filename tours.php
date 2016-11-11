<?php
require_once("conexion.php");
/*$pagina = $_GET["Pagina"];
$pagina adentro de la funcion ListarTours*/ 
$tours = listarTours();
json($tours);
?>

