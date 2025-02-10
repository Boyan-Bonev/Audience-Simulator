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
    <link rel="stylesheet" href="eventStyle.css">
</head>
<body>
    <!-- make it live! -->

    <!-- connect it to the currently active command -->
    <section id="commandDisplay">
        Command: <span id="commandText"></span> | Time Left: <span id="countdown"></span>
    </section>

    <!-- dynamically adds participants instead of statically-->
    <section id="participants"></section>
    <script src="manageMeeting.js"></script>

    <section class="overlay" id="overlay"></section>
    <script src="popUpManagement.js"></script>
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
        <section class="popupContent">
            <span class="closeButton" onclick="closePopup('commandPopup')">&times;</span>
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

            <label for="delayInput">Delay (seconds): </label>
            <input type="number" id="delayInput" value="0" min="0"><br><br>

            <label for="pointsInput">Minimum Points: </label>
            <input type="number" id="pointsInput" value="0" min="0"><br><br>

            <button onclick="activateSelectedCommand()">Activate</button>
        </section>
    </section>

    <script src="activateCommand.js"></script>

    <section id="imagePopup" class="popup">
        <section class="popupContent">
            <span class="closeButton" onclick="closePopup('imagePopup')">&times;</span>
            <h2>Display an image</h2>

            <label for="imageSelect">Select Image:</label>
            <select id="imageSelect">
                <option value="clap">Clap</option>
                <option value="stomp">Stomp</option>
                <option value="whistle">Whistle</option>
                <option value="throwTomatoes">Throw Tomatoes</option>
                <option value="gasp">Gasp</option>
                <option value="sigh">Sigh</option>
                <option value="boo">Boo</option>
            </select><br><br>

            <button onclick="displayImage()">Display</button>
        </section>
    </section>

    <script src="displayImage.js"></script>

    <section id="soundPopup" class="popup">
        <section class="popupContent">
            <span class="closeButton" onclick="closePopup('soundPopup')">&times;</span>
            <h2>Play a sound</h2>

            <label for="soundSelect">Select Sound:</label>
            <select id="soundSelect">
                <option value="clap">Clap</option>
                <option value="stomp">Stomp</option>
                <option value="whistle">Whistle</option>
                <option value="throwTomatoes">Throw Tomatoes</option>
                <option value="gasp">Gasp</option>
                <option value="sigh">Sigh</option>
                <option value="boo">Boo</option>
            </select><br><br>

            <label for="volumeSlider">Volume:</label>
            <input type="range" id="volumeSlider" min="0" max="100" value="50">
            <span id="volumeValue">50</span><br><br>

            <button onclick="playSound()">Play</button>
        </section>
    </section>

    <script src="playSound.js"></script>

    <section id="videoPopup" class="popup">
        <section class="popupContent">
            <span class="closeButton" onclick="closePopup('videoPopup')">&times;</span>
            <h2>Play a video</h2>

            <label for="videoSelect">Select Video:</label>
            <select id="videoSelect">
                <option value="clap">Clap</option>
                <option value="stomp">Stomp</option>
                <option value="whistle">Whistle</option>
                <option value="throwTomatoes">Throw Tomatoes</option>
                <option value="gasp">Gasp</option>
                <option value="sigh">Sigh</option>
                <option value="boo">Boo</option>
            </select><br><br>

            <label for="videoSpeed">Video Speed:</label>
            <input type="number" id="videoSpeed" min="0.5" max="2.0" step="0.1" value="1.0"><br><br>

            <label for="videoVolume">Volume:</label>
            <input type="range" id="videoVolume" min="0" max="100" value="50">
            <span id="videoVolumeValue">50</span><br><br>    

            <button onclick="playVideo()">Play</button>
        </section>
    </section>

    <script src="playVideo.js"></script>
</body>
</html>