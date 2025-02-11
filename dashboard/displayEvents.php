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

    $sql = "SELECT name, photo, description FROM meetings";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<section class="events">';
        while($row = $result->fetch_assoc()) {
            echo '<a href="event.php?name=' . urlencode($row["name"]) . '" class="eventCard">';
            echo '<h3>' . $row["name"] . '</h3>';
            echo '<img src="../eventPhotos/' . $row["photo"] . '" alt="' . $row["name"] . '">';
            echo '<p>' . $row["description"] . '</p>';
            echo '</a>';
        }
        echo '</section>';
    } else {
        echo "<p>No events found.</p>";
    }

    $conn->close();

?>