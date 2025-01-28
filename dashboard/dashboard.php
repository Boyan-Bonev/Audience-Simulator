<?php
    session_start();
    if(!isset($_SESSION["user"]))
    {
        header("Location: ../login/login.php");
    }
    require_once "../login/database.php";
    $email = $_SESSION["user"];
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn,$sql);
    $user = mysqli_fetch_array($result,MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Dashboard</title>
    <link rel="stylesheet" href="dashboardStyles.css">
</head>
<body>
    
    <?php
    $profileData = include 'profileData.php'; 

    if ($profileData === false) {
        die("Error including profile data.");
    }

    $profileName = $profileData['name'];
    $profilePicture = $profileData['picture'];
    $profilePicture = "../userPhotos/$profilePicture";
    ?>

    <header>
        <section id="profileInfo">
            <img id="profilePicture" src="<?php echo $profilePicture; ?>" alt="<?php echo $profileName; ?>">
            <p id="profileName"><?php echo $profileName; ?></p>
        </section>
        <nav id="topNav">
            <ul>
                <?php include 'changeButtonVisibility.php' ?>
                <li><a href="profile.html" id="profile">Profile</a></li>
                <li><a href="../login/logout.php" id="logout" class="btn btn-warning">Log out</a></li>
            </ul>
        </nav>
    </header>
    
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

    <section id="bottomSection">
        <form id = "eventConnectForm">
            <label for="eventName">Insert link</label>
            <input type="text" id="eventName" name="eventName">
            <input type="submit" value="Submit">
        </form>
    </section>

    <script src="connectByEventName.js"></script>
    <script src="connectEventToLink.js"></script>
</body>
</html>