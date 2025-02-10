<?php

if (session_id() == "") {
    session_start();
}

$meetingName = $_GET['meetingName'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "events";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

$userId = $_SESSION["user"]; 

$stmt = $conn->prepare("SELECT participants FROM meetings WHERE name = ?");
$stmt->bind_param("s", $meetingName);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $currentParticipants = json_decode($row['participants'], true);

    if (!in_array($userId, $currentParticipants)) {
        if (empty($currentParticipants) || $currentParticipants === [null]) { 
            $currentParticipants = [$userId]; 
        } else {
            $currentParticipants[] = $userId; 
        }
        $updatedParticipants = json_encode($currentParticipants);

        $updateStmt = $conn->prepare("UPDATE meetings SET participants = ? WHERE name = ?");
        $updateStmt->bind_param("ss", $updatedParticipants, $meetingName);
        $updateStmt->execute();

        echo "User added to meeting successfully."; 

        $updateStmt->close();
    } else {
        echo "User is already in the meeting.";
    }
} else {
    echo "Meeting not found.";
}

$stmt->close();
$conn->close();

?>