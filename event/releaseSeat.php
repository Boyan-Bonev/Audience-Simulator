<?php
session_start();
require_once "../login/database.php";

if (!isset($_SESSION["user"])) {
    echo json_encode(["success" => false, "message" => "User not logged in"]);
    exit;
}

if (!isset($_POST['row']) || !isset($_POST['col'])) {
    echo json_encode(["success" => false, "message" => "Invalid seat data"]);
    exit;
}

$email = $_SESSION["user"];
$row = (int) $_POST['row'];
$col = (int) $_POST['col'];

$meetingName = $_GET['name'];
$meetingName = mysqli_real_escape_string($conn, $meetingName);

$eventIdQuery = "SELECT id FROM events.meetings WHERE name = '$meetingName'";
$eventIdResult = mysqli_query($conn, $eventIdQuery);

if (!$eventIdResult) {
    die(json_encode(["error" => "Query failed: " . mysqli_error($conn)]));
}

if (mysqli_num_rows($eventIdResult) == 0) {
    die(json_encode(["error" => "Event not found"]));
}

$eventIdRow = mysqli_fetch_assoc($eventIdResult);
$eventId = $eventIdRow['id'];

$checkQuery = "SELECT * FROM events.seating WHERE row_pos = ? AND col_pos = ? AND event_id = ? AND user = ?";
$stmt = mysqli_prepare($conn, $checkQuery);
mysqli_stmt_bind_param($stmt, "iiss", $row, $col, $eventId, $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    echo json_encode(["success" => false, "message" => "Seat not reserved by this user"]);
    exit;
}

$deleteQuery = "DELETE FROM events.seating WHERE row_pos = ? AND col_pos = ? AND event_id = ? AND user = ?";
$stmt = mysqli_prepare($conn, $deleteQuery);
mysqli_stmt_bind_param($stmt, "iiss", $row, $col, $eventId, $email);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(["success" => true, "message" => "Seat released successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Database error"]);
}
?>
