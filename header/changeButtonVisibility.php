<?php

require_once '../login/database.php';

$user = $_SESSION["user"];

$stmt = $conn->prepare("SELECT role FROM users WHERE email = ?");
$stmt->bind_param("s", $user);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userRole = $row["role"];

    if (!empty($userRole)) {
        if ($userRole === "admin") {
            echo '<li><a href="../adminSettings/adminSettings.php" id="adminSettings">Administrative Settings</a></li>';
        }
        if ($userRole === "admin" || $userRole === "creator") {
            echo '<li><a href="../createEvent/createEvent.php" id="createEvent">Create Event</a></li>';
        }   
    }   
}
    
$stmt->close();
$conn->close();

?>