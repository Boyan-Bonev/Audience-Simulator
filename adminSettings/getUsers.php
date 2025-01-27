<?php

try {
    $conn = new mysqli("localhost", "root", "", "registration_form");
}
catch (mysqli_sql_exception $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT name FROM users";
$result = $conn->query($sql);

$users = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($users);

$conn->close();
?>