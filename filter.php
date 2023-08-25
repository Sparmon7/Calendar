<?php
ini_set("session.cookie_httponly", 1);
session_start();

header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

//checking csrf
if(isset($_SESSION['username'])&& isset($_COOKIE["token"]) && $_COOKIE["token"] == $_SESSION["token"]){
    $username = $_SESSION['username'];
}else{
    echo json_encode(array(
		"success" => false,
		"message" => "session unset"
	));
    exit;
}


$filter = $json_obj['filter'];
$success = false;
//if passed a filter, return results with that filter from mysql
if($filter){
  $success = true;
  require 'database.php';
  $stmt = $mysqli->prepare("select * from events WHERE username = ? AND tag = ?");

  if(!$stmt){
    echo json_encode(array(
      'data' => ("Query Prep Failed:" + htmlentities($mysqli->error)),
      'success' => $success
  ));
    exit;
  }

  $stmt->bind_param('ss', $username, $filter);
  $stmt->execute();

  $result = $stmt->get_result();

  $employees = [];

  while($row = $result->fetch_assoc())
  {
    $eventName = $row['eventName'];
    $eventid=$row['eventid'];
    $dateTime=$row['dateTime'];
    $tag = $row['tag'];
    $employees[] = array( 'eventName'=> htmlentities($eventName), 'eventid' =>htmlentities($eventid), 'dateTime' =>htmlentities($dateTime), 'tag'=>htmlentities($tag));
  }
  echo json_encode(array(
      'data' => $employees,
      'success' => $success
  ));
  $stmt->close();
  exit;
}
echo json_encode(array(
  'success' => $success
));
?>