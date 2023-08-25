<?php

ini_set("session.cookie_httponly", 1);
session_start();

header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

//check session and cookie to find username
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

$eventid = (int) $json_obj['eventid'];

//delete event in mysql
require 'database.php';
$stmt = $mysqli->prepare("delete from events WHERE eventid = ? AND username = ?");
$stmt->bind_param('is', $eventid, $username);
$stmt->execute();
if($stmt->execute){
    echo json_encode(array(
		"success" => true
	));
}else{
	echo json_encode(array(
		"success" => false,
		"message" => "Event did not delete"
	));
}

$stmt->close();

exit;
?>