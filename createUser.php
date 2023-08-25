<?php
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

$username = $json_obj["username"];
$password = $json_obj["password"];
$passhash = password_hash($json_obj["password"], PASSWORD_DEFAULT);

require 'database.php';

//checking username/password are not whitespace
if($username == "" || $password == "" ||ctype_space($username) || ctype_space($password)){
	echo json_encode(array(
		"success" => false,
		"message" => "Username and/or Password cannot be blank"
	));
	exit;
}

//checking if username exists
$stmt = $mysqli->prepare("select COUNT(*) FROM users WHERE username = ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($count);
$check = $stmt->fetch();
$stmt->close();
if($count){
	echo json_encode(array(
		"success" => false,
		"message" => "User already exists"
	));
	exit;
}
$stmt->close();

//adding user to table through SQL query
$stmt = $mysqli->prepare("insert into users (username, passhash) values (?, ?)");
$stmt->bind_param('ss', $username, $passhash);
if($stmt->execute()){
    echo json_encode(array(
		"success" => true
	));
}else{
	echo json_encode(array(
		"success" => false,
		"message" => "User did not create"
	));
}
$stmt->close();

exit;
?>