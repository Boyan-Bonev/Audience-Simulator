<?php

try {
    $conn = new mysqli("localhost", "root", "", "registration_form");
}
catch (mysqli_sql_exception $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["user"];
    $role = $_POST["role"];

    $stmt = $conn->prepare("UPDATE users SET role = ? WHERE name = ?");
    $stmt->bind_param("si", $role, $user);

    if ($stmt->execute()) {
        echo "Role updated successfully.";
    } else if ($stmt->affected_rows === 0) {
        echo "No such user exists.";
    } else {
        echo "An error occurred: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>