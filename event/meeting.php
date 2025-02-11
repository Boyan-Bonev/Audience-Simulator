<?php

    require_once '../connectToEvents.php';

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $meetingName = $_GET['meetingName'];

        $stmt = $conn->prepare("SELECT * FROM meetings WHERE name = ?");
        $stmt->bind_param("s", $meetingName);

        if (!$stmt->execute()) {
            echo json_encode(['error' => 'Error executing query: ' . $stmt->error]);
            exit;
        }

        $result = $stmt->get_result();
        $meeting = $result->fetch_assoc();

        if (!$meeting) {
            echo json_encode(['error' => 'Meeting not found']);
            exit;
        }

        echo json_encode(['success' => true, 'meeting' => $meeting]);
        exit;

    }

    echo json_encode(['error' => 'Invalid request']);

    $conn->close();
    
?>
