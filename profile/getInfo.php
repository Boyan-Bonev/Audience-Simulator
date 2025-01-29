<?php
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


$sql = $conn->prepare("Select username,points,extraData FROM users WHERE iduser = ?");
$sql->bind_param("i",$id);
$result = $sql->execute();
if ($result->num_rows > 0) {
    $entry = $result->fetch_assoc();
}

header('Content-Type: application/json'); 
echo json_encode($entry);

$conn->close();
?>