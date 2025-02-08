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

require_once "../login/database.php";

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
	$userCount = $_POST["usersNum"];
	$desc = $_POST["eventDesc"];
    

    $inp = $conn->prepare("INSERT INTO events.meetings (name,participants,photo,description) VALUES (?,?,?,?)");
    $inp->bind_param("ssss", $name, $userCount,$imgName,$desc);

    $inp->execute();

    $inp->close();
	header('Location: ../dashboard/dashboard.php');
	die();
}


?>