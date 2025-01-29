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

 session_start();
 $id = $_SESSION["iduser"];
try {
    $conn = new mysqli("localhost", "username", "password", "database");
}
catch (mysqli_sql_exception $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$to = generateRandomString()."_".$id;
	$imgName = $to;
	$to = "uploads/".$to;
	if(move_uploaded_file($_FILES["eventImg"]["tmp_name"], $to)) {
    echo "file uploaded";
    }
	
	else {
         echo "Error: file upload";
    }
	$name = $_POST["eventName"];
	$userCount = $_POST["usersNum"];
	$desc = $_POST["eventDesc"];
    

    $inp = $conn->prepare("INSERT INTO events (name,userCount,img,desc) VALUES (?,?,?,?)");
    $inp->bind_param("siss", $name, $userCount,$imgName,$desc);

    if ($inp->execute()) {
        echo "Event created.";
    }  else {
        echo "An error occurred: " . $inp->error;
    }

    $inp->close();
}

$conn->close();
?>