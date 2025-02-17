<?php
    
    require_once "../connectToEvents.php";
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

?>