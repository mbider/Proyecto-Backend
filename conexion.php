<?php 

if (file_exists("env.php")) {
	require_once("env.php");
}
else {/*
	$GLOBALS["MYSQL_USERNAME"] = "root";
	$GLOBALS["MYSQL_DATABASE"] = "basenueva";
	$GLOBALS["MYSQL_HOST"]     = "localhost";
	$GLOBALS["MYSQL_PASSWORD"] = "";*/
	$GLOBALS["MYSQL_USERNAME"] = "b606f22f4191d5";
	$GLOBALS["MYSQL_DATABASE"] = "viajar";
	$GLOBALS["MYSQL_HOST"]     = "us-cdbr-azure-central-a.cloudapp.net";
	$GLOBALS["MYSQL_PASSWORD"] = "66d80d73";*/
}

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

$GLOBALS["CONN"] = mysqli_connect(
	$GLOBALS["MYSQL_HOST"],
	$GLOBALS["MYSQL_USERNAME"],
	$GLOBALS["MYSQL_PASSWORD"],
	$GLOBALS["MYSQL_DATABASE"]
);

mysqli_query($GLOBALS["CONN"], "set names 'utf8'");

//mysqli_select_db($database_localhost, $localhost);
?>