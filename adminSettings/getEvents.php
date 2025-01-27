<?php

try {
    $conn = new mysqli("localhost", "root", "", "events");
}
catch (mysqli_sql_exception $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

if ($conn->connect_error) {
    die("A database error occurred. Please try again later.");
}

$sql = "SELECT * FROM meetings";
$result = $conn->query($sql);

$events = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}
 
header('Content-Type: application/json');
echo json_encode($events);

$conn->close();
?>