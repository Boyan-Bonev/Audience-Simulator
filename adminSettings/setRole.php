<?php

require_once '../connectToEvents.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["user"];
    $role = $_POST["role"];

    $stmt = $conn->prepare("UPDATE users SET role = ? WHERE name = ?");
    $stmt->bind_param("ss", $role, $user);

    if ($stmt->execute()) {
        echo "Role updated successfully.";
    } else if ($stmt->affected_rows === 0) {
        echo "No such user exists.";
    } else {
        echo "An error occurred: " . $stmt->error;
    }

    $stmt->close();
}

?>