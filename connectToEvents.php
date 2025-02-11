<?php

try {
    $conn = new mysqli("localhost", "root", "", "events");
}
catch (mysqli_sql_exception $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

if ($conn->connect_error) {
    die("A database error occurred. Please try again later.");
} 

?>