<?php

session_start();
header('Content-Type: application/json');

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $meetingName = $_POST['meeting_name'];
    $user = $_SESSION['user'];

    // Fetch meeting
    $stmt = $pdo->prepare("SELECT participants FROM meetings WHERE name = :name");
    $stmt->execute(['name' => $meetingName]);
    $meeting = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$meeting) {
        echo json_encode(['error' => 'Meeting not found']);
        exit;
    }

    // Update participants
    $participants = json_decode($meeting['participants'], true) ?: [];
    if (!in_array($user, $participants)) {
        $participants[] = $user;
        $stmt = $pdo->prepare("UPDATE meetings SET participants = :participants WHERE name = :name");
        $stmt->execute([
            'participants' => json_encode($participants),
            'name' => $meetingName,
        ]);
    }

    echo json_encode(['success' => true, 'participants' => $participants]);
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
