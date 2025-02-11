<?php

$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $password_hash = password_hash("The_Us3r", PASSWORD_DEFAULT); 
    $sql = "INSERT INTO registration_form.users (name, email, photo, password, role, points,roomid)
            VALUES ('user', 'user@abv.bg', 'user.png', '$password_hash', 'normal', 0, NULL)";
    $conn->exec($sql);

    $password_hash = password_hash("The_Cr3ator", PASSWORD_DEFAULT); 
    $sql = "INSERT INTO registration_form.users (name, email, photo, password, role, points,roomid)
            VALUES ('Event Creator', 'event_creator@abv.bg', 'eventCreator.png', '$password_hash', 'creator', 169, NULL)";
    $conn->exec($sql);


	$sql = "INSERT INTO events.meetings (name,photo,description,participants,creatorid)
	        VALUES ('test','test.jpg','mysql > mariadb','admin',1)";
	$conn->exec($sql);
    
    echo "Sample data has been successfully inserted into the databases.";
} catch(PDOException $e) {
    echo "Error inserting the sample data: " . $e->getMessage();
}

$conn = null;

?>