<?php
session_start();
require_once "../connectToEvents.php";

// Check if the user is logged in
if (!isset($_SESSION["user"])) {
    echo json_encode(["success" => false, "message" => "User not logged in"]);
    exit;
}

// Check if seat data (row and col) is passed
if (!isset($_POST['row']) || !isset($_POST['col'])) {
    echo json_encode(["success" => false, "message" => "Invalid seat data"]);
    exit;
}

$email = $_SESSION["user"];
$row = (int) $_POST['row'];
$col = (int) $_POST['col'];

$meetingName = $_GET['name'];
$meetingName = mysqli_real_escape_string($conn, $meetingName);

// Fetch the eventId corresponding to the meeting name
$eventIdQuery = "SELECT id FROM meetings WHERE name = '$meetingName'";
$eventIdResult = mysqli_query($conn, $eventIdQuery);

if (!$eventIdResult) {
    die(json_encode(["error" => "Query failed: " . mysqli_error($conn)]));
}

if (mysqli_num_rows($eventIdResult) == 0) {
    die(json_encode(["error" => "Event not found"]));
}

$eventIdRow = mysqli_fetch_assoc($eventIdResult);
$eventId = $eventIdRow['id'];

// Check if the seat is already reserved by the user
$checkQuery = "SELECT * FROM seating WHERE row_pos = ? AND col_pos = ? AND event_id = ? AND user = ?";
$stmt = mysqli_prepare($conn, $checkQuery);
mysqli_stmt_bind_param($stmt, "iiss", $row, $col, $eventId, $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    echo json_encode(["success" => false, "message" => "Seat not reserved by this user"]);
    exit;
}

// Delete the seat reservation for the user (free the seat)
$deleteQuery = "DELETE FROM seating WHERE row_pos = ? AND col_pos = ? AND event_id = ? AND user = ?";
$stmt = mysqli_prepare($conn, $deleteQuery);
mysqli_stmt_bind_param($stmt, "iiss", $row, $col, $eventId, $email);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(["success" => true, "message" => "Seat deselected successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Database error"]);
}
?>