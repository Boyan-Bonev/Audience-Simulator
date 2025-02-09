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
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="meetingName">Event Page</title>
    <link rel="stylesheet" href="eventStyles.css">
</head>
<body>
    <!-- make it live! -->

    <!-- connect it to the currently active command -->
    <section id="commandDisplay">
        Command: <span id="commandText"></span> | Time Left: <span id="countdown"></span>
    </section>

    <!-- dynamically adds participants instead of statically-->
    <!-- make it so if they play a noise, use an emoji or play a video -->
    <!-- it appears for everyone live -->
    <!-- same goes for the +1 button -->
    <section id="participants">
    </section>

    <!-- create the popups and link the entered information -->
    <!-- to the event page -->
    <!-- make it so the user gains a point if -->
    <!-- they time the correct reaction successfully -->
    <section id="controls">
        <button onclick="openPopup('commandPopup')">Activate Command</button>
        <button onclick="openPopup('imagePopup')">Display an image</button>
        <button onclick="openPopup('soundPopup')">Play a sound</button>
        <button onclick="openPopup('videoPopup')">Play a video</button>
        <!-- connect this to the simulation mode -->
        <!-- that's connected to the user's profile --> 
        <label>Simulate: <input type="checkbox"></label>
    </section>

    <section id="commandPopup" class="popup">
        <section class="popup-content">
            <span class="close-button" onclick="closePopup('commandPopup')">&times;</span>
            <h2>Activate Command</h2>

            <label for="commandSelect">Select Command:</label>
            <select id="commandSelect">
                <option value="clap">Clap</option>
                <option value="stomp">Stomp</option>
                <option value="whistle">Whistle</option>
                <option value="throwTomatoes">Throw Tomatoes</option>
                <option value="gasp">Gasp</option>
                <option value="sigh">Sigh</option>
                <option value="boo">Boo</option>
                </select><br><br>

            <label for="delayInput">Delay (seconds):   </label>
            <input type="number" id="delayInput" value="0" min="0"><br><br>

            <label for="pointsInput">Minimum Points:   </label>
            <input type="number" id="pointsInput" value="0" min="0"><br><br>

            <button onclick="activateSelectedCommand()">Activate</button>
        </section>
    </section>

    <script src="activateCommand.js"></script>

    <section id="commandPopup" class="popup">
        <h2>Activate Command</h2>
        <button onclick="closePopup('commandPopup')">Close</button>
    </section>

    <section id="imagePopup" class="popup">
        <h2>Select Image</h2>
        <button onclick="closePopup('imagePopup')">Close</button>
    </section>

    <section id="soundPopup" class="popup">
        <h2>Play Sound</h2>
        <button onclick="closePopup('soundPopup')">Close</button>
    </section>

    <section id="videoPopup" class="popup">
        <h2>Play Video</h2>
        <button onclick="closePopup('videoPopup')">Close</button>
    </section>

    <section class="overlay" id="overlay"></section>

    <script src="popUpManagement.js"></script>

    <script src="manageMeeting.js"></script>

</body>
</html>