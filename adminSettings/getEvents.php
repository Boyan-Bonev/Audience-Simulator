<?php

require_once '../connectToEvents.php';

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