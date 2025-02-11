<?php
require_once "../login/database.php";

$meetingName = $_GET['name'];
//$meetingName = 'cool name 2';
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

$seatQuery = "SELECT row_pos, col_pos,user FROM events.seating WHERE event_id = $eventId";
$seatResult = mysqli_query($conn, $seatQuery);

$seats = [];
while ($seat = mysqli_fetch_assoc($seatResult)) {
    $seats[] = $seat;
}

echo json_encode($seats);
?>
