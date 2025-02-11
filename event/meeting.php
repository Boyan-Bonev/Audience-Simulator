<?php

$dsn = "mysql:host=localhost;dbname=events;charset=utf8mb4";
$username = "root";
$password = "";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $meetingName = $_GET['meeting_name'];

    $stmt = $pdo->prepare("SELECT * FROM meetings WHERE name = :name");
    $stmt->execute(['name' => $meetingName]);
    $meeting = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$meeting) {
        echo json_encode(['error' => 'Meeting not found']);
        exit;
    }

    echo json_encode(['success' => true, 'meeting' => $meeting]);
    exit;
}

echo json_encode(['error' => 'Invalid request']);

?>
