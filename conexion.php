<?php 

if (getenv("MYSQL_HOSTNAME") === false) {
	$GLOBALS["MYSQL_HOSTNAME"] = "localhost";
	$GLOBALS["MYSQL_USERNAME"] = "root";
	$GLOBALS["MYSQL_PASSWORD"] = "";
	$GLOBALS["MYSQL_DATABASE"] = "base";
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