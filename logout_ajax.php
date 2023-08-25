<?php
// logout_ajax.php

//delete sessions and cookies
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
ini_set("session.cookie_httponly", 1);
session_start();
$_SESSION['username'] = '';
$_SESSION['token'] = '';
unset($_COOKIE['token']); 
    session_destroy();
	echo json_encode(array(
		"success" => true
	));
	exit;
?>