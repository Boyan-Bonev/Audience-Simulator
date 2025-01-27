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
                <!-- make admin settings and create event appear only if the user has the rights to it -->
                <li><a href="../adminSettings/adminSettings.php" id="adminSettings">Administrative Settings</a></li>
                <li><a href="createEvent.html" id="createEvent">Create Event</a></li>
                <li><a href="profile.html" id="profile">Profile</a></li>
                <li><a href="../login/logout.php" id="logout" class="btn btn-warning">Log out</a></li>
            </ul>
        </nav>
    </header>
    
    <!-- get events by some database instead of statically adding them -->
    <section class="events">
        <a href="event1.html" class="eventCard">
            <h3>test1</h3>
            <img src="event1.jpg" alt="Event 1">
            <p>Event 1 Description</p>
        </a>
        <a href="event2.html" class="eventCard">
            <h3>Event 2 Name</h3>
            <img src="event2.jpg" alt="Event 2">
            <p>Event 2 Description</p>
        </a>
        <a href="event3.html" class="eventCard">
            <h3>Event 3 Name</h3>
            <img src="event3.jpg" alt="Event 3">
            <p>Event 3 Description</p>  
        </a>
        <a href="event4.html" class="eventCard">
            <h3>Event 4 Name</h3>
            <img src="event4.jpg" alt="Event 4">
            <p>Event 4 Description</p>
        </a>
        <a href="event5.html" class="eventCard">
            <h3>Event 5 Name</h3>
            <img src="event5.jpg" alt="Event 5">
            <p>Event 5 Description</p>
        </a>
        <a href="event6.html" class="eventCard">
            <h3>Event 6 Name</h3>
            <img src="event6.jpg" alt="Event 6">
            <p>Event 6 Description</p>
        </a>
    </section>

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