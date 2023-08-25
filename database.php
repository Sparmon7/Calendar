<?php
// Connect to a database using the MySQL Improved interface
$mysqli = new mysqli('localhost', 'adamius', 'passy', 'calendar');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>