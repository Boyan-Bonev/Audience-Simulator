<?php

$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn->exec("USE registration_form");

    $sql = "CREATE TABLE seating (
        id INT AUTO_INCREMENT PRIMARY KEY,
        row_pos INT NOT NULL,
        col_pos INT NOT NULL,
        user VARCHAR(255) NOT NULL,
        event_id INT NOT NULL,
        FOREIGN KEY (event_id) REFERENCES events.meetings(id) ON DELETE CASCADE
    )";
    $conn->exec($sql);

    echo "Databases and tables created successfully!";

} catch(PDOException $e) {
    echo "Error creating databases and tables: " . $e->getMessage();
}

$conn = null;