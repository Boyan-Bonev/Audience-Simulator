<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "events";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['name'])) {
    echo "Meeting ID parameter is missing.";
    exit();
}

$meetingName = $_GET['name'];

if (!isset($_GET['currentCommand']) || !isset($_GET['delay']) || !isset($_GET['commandMinPoints'])) {
    echo "currentCommand and commandWantedAt parameters are required.";
    exit();
}


$stmt = $conn->query("SELECT CURRENT_TIMESTAMP()");
$currentTimeRow = $stmt->fetch_row();
$currentTime = $currentTimeRow[0];

$currentCommand = $_GET['currentCommand'];
$delay = $_GET['delay'];
$commandMinPoints = $_GET['commandMinPoints'];

$stmt = $conn->prepare("UPDATE meetings SET currentCommand = ?, commandMinPoints = ?, commandWantedAt = DATE_ADD(?, INTERVAL ? SECOND) WHERE name = ?");
$stmt->bind_param("sisis", $currentCommand, $commandMinPoints, $currentTime, $delay, $meetingName);

if ($stmt->execute()) {
    echo "Meeting updated successfully.";
} else {
    echo "Error updating meeting.";
}

$pdo = null; 

?>