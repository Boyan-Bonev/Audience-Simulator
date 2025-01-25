<?php
// TODO: Has to be connected to the session so it enters the given username and password
try {
    $conn = new mysqli("localhost", "username", "password", "database");
}
catch (mysqli_sql_exception $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT username FROM users"; // TODO: Have to create the given database
$result = $conn->query($sql);

$users = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

header('Content-Type: application/json'); // TODO: Choose header content
echo json_encode($users);

$conn->close();
?>