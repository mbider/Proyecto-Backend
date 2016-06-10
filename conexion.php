<?php 

if (array_key_exists("HTTP_HOST", $_ENV)) {
	$GLOBALS["URL_BASE"] = "http://" . $_ENV["HTTP_HOST"];
}
else {
	$GLOBALS["URL_BASE"] = "http://localhost/Proyecto2";
}

function json($objeto) {
	header("Content-Type: application/json; charset=UTF-8");
	$json = json_encode($objeto, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	echo($json);
}

function generarURL($relativo) {
	return $GLOBALS["URL_BASE"] . $relativo;
}

$hostname_localhost = "localhost";
$database_localhost = "basenueva";
$username_localhost = "root";
$password_localhost = "";


$GLOBALS["CONN"] = mysqli_connect($hostname_localhost, $username_localhost, $password_localhost, $database_localhost);

mysqli_query($GLOBALS["CONN"], "set names 'utf8'");

//mysqli_select_db($database_localhost, $localhost);
?>