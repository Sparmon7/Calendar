<?php

header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
ini_set("session.cookie_httponly", 1);

session_start();

//returns events from mysql
require 'database.php';

$stmt = $mysqli->prepare("select * from events where username = ?");

$stmt->bind_param('s', $_SESSION["username"]);
if(!$stmt){
	echo ("Query Prep Failed:" +$mysqli->error);
	exit;
}

$stmt->execute();

$result = $stmt->get_result();

while($row = $result->fetch_assoc())
{
  $eventName = $row['eventName'];
  $eventid=$row['eventid'];
  $dateTime=$row['dateTime'];
  $tag = $row['tag'];
  $employees[] = array( 'eventName'=> htmlentities($eventName), 'eventid' =>htmlentities($eventid), 'dateTime' =>htmlentities($dateTime), 'tag'=>htmlentities($tag));
}
echo json_encode($employees);
$stmt->close();
exit;


?>