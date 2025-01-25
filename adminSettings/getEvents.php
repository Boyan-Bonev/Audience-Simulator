<?php
// TODO: Has to be connected to the session so it enters the given username and password
try {
    $conn = new mysqli("localhost", "username", "password", "database");
}
catch (mysqli_sql_exception $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

if ($conn->connect_error) {
    die("A database error occurred. Please try again later.");
}

$sql = "SELECT * FROM events"; // TODO: create the database and choose which columns will be shown
$result = $conn->query($sql);

$events = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}
 
header('Content-Type: application/json'); // TODO: Choose header content
echo json_encode($events);

$conn->close();
?>