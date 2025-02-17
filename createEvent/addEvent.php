<?php

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $randomString;
}  //func to generate random string for use in img filename, taken from https://stackoverflow.com/questions/4356289/php-random-string-generator

if (session_id() == "") {
    session_start();
}

if (!isset($_SESSION["user"])) {
    header("Location: ../login/login.php");
    exit;
}

require_once "../connectToEvents.php";

$email = $_SESSION["user"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$to = generateRandomString();
	$imgName = $to.".png";
	$to = "../eventPhotos/".$imgName;
	if(move_uploaded_file($_FILES['eventsImg']['tmp_name'], $to)) {
    
    }
	
	else {
         
    }
	$name = $_POST["eventName"];
	$rowNum = $_POST["rowNum"];
	$colNum = $_POST["colNum"];
	$desc = $_POST["eventDesc"];
    $created_at = date('Y-m-d H:i:s', time());
    $ends_at = date('Y-m-d H:i:s', time() + (60*60));
    $creatorid = $_SESSION["userId"];


    
    $inp = $conn->prepare(
        "INSERT INTO meetings (name,row_num,col_num,photo,description,created_at,ends_at,creatorid) VALUES (?,?,?,?,?,?,?,?)");
    $inp->bind_param("siisssss", $name, $rowNum,$colNum,$imgName,$desc,$created_at,$ends_at,$creatorid);
    $inp->execute();

    $inp->close();
	header('Location: ../dashboard/dashboard.php');
	die();
}

?>