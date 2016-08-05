<?php
require_once("conexion.php");
session_start();
json(Array("Mensaje" => "Bienvenido ".$_SESSION["User"]));
?>