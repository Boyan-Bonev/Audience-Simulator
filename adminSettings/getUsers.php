<?php

require_once '../connectToEvents.php';

$sql = "SELECT name FROM users";
$result = $conn->query($sql);

$users = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($users);

?>