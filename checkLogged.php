<?php
//checking if loggedin and returning result

header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
ini_set("session.cookie_httponly", 1);    

session_start();
    if(isset($_SESSION['username']) && $_SESSION['username'] != "" && isset($_COOKIE["token"]) && $_COOKIE["token"] == $_SESSION["token"]){
        echo json_encode(array(
            "logged" => true
        ));
    }else{
        echo json_encode(array(
            "logged" => false
        ));
    }
	
	exit;
?>