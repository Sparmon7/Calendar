<?php

ini_set("session.cookie_httponly", 1);
session_start();

header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

//checking csrf
if(isset($_SESSION['username']) && isset($_COOKIE["token"]) && $_COOKIE["token"] == $_SESSION["token"]){
    $username = $_SESSION['username'];
}else{
    echo json_encode(array(
		"success" => false,
		"message" => "Verification failed"
	));
	$_SESSION['username'] = '';
	$_SESSION['token'] = '';
	unset($_COOKIE['token']); 
	session_destroy();
	exit;
}

$eventName = $json_obj['eventName'];
$dateTime = $json_obj['dateTime'];
$tag = $json_obj['tag'];

//creating event in sql
require 'database.php';
$stmt = $mysqli->prepare("insert into events (username, eventName, dateTime, tag) values ( ?, ?, ?, ?)");
$stmt->bind_param('ssss', $username, $eventName, $dateTime, $tag);
if($stmt->execute()){
    echo json_encode(array(
		"success" => true
	));
}else{
	echo json_encode(array(
		"success" => false,
		"message" => "Event did not create"
	));
}
$stmt->close();

exit;
?>