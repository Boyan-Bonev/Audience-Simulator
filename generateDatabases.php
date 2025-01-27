<?php

$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "DROP DATABASE IF EXISTS registration_form;
            DROP DATABASE IF EXISTS events;";
    $conn->exec($sql);

    $sql = "CREATE DATABASE registration_form";
    $conn->exec($sql);
    $conn->exec("USE registration_form");

    $sql = "CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        photo VARCHAR(255) DEFAULT NULL,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(255) NOT NULL,
        points INT DEFAULT 0
    )";
    $conn->exec($sql);

    $sql = "CREATE DATABASE events";
    $conn->exec($sql);
    $conn->exec("USE events");

    $sql = "CREATE TABLE meetings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        photo VARCHAR(255) DEFAULT NULL,
        description TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        ends_at DATETIME DEFAULT NULL,
        participants VARCHAR(255) DEFAULT NULL
    )";
    $conn->exec($sql);

    $conn->exec("USE registration_form");

    // Insert a sample admin user (replace password with a hashed version using password_hash())
    $password_hash = password_hash("The_Adm1n", PASSWORD_DEFAULT); 
    $sql = "INSERT INTO users (name, email, photo, password, role, points)
            VALUES ('admin', 'admin@abv.bg', 'admin.jpg', '$password_hash', 'admin', 999)";
    $conn->exec($sql);

    echo "Databases and tables created successfully!";

} catch(PDOException $e) {
    echo "Error creating databases and tables: " . $e->getMessage();
}

$conn = null;