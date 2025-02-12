<?php

    session_start();
    if(!isset($_SESSION["user"]))
    {
        header("Location: ../login/login.php");
    }
    require_once "../login/database.php";

    $email = $_SESSION["user"];
    $userId = $_SESSION["userId"];
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn,$sql);
    $user = mysqli_fetch_array($result,MYSQLI_ASSOC);

    $seats = [];
    $seatQuery = "SELECT row_pos, col_pos, user FROM events.seating WHERE event_id = 2";
    $seatResult = mysqli_query($conn, $seatQuery);
    while ($seat = mysqli_fetch_assoc($seatResult)) {
        $seats[] = $seat;
    }

    $meetingName = $_GET['name'];
    $meetingQuery = "SELECT row_num,col_num,creatorid FROM events.meetings WHERE name = '$meetingName' LIMIT 1";
    $resultMeeting = mysqli_query($conn,$meetingQuery);
    $meetingRow = mysqli_fetch_assoc($resultMeeting);
    $rows = $meetingRow['row_num'];
    $cols = $meetingRow['col_num'];
    $creatorid =$meetingRow['creatorid'];

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
    <section id="commandDisplay">
        Command: <span id="commandText"></span> | Time Left: <span id="countdown"></span>
    </section>

    <section id="seatingGrid" class="grid"></section>

    <script src="activateCommand.js"></script>

    <script src="manageMeeting.js"></script> </head>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const seatingGrid = document.getElementById("seatingGrid");
            const rows = <?php echo (int)$rows?>;
            const cols = <?php echo (int)$cols?>;
            const meetingName = "<?php echo htmlspecialchars($meetingName); ?>";
            const userEmail = "<?php echo $user['email']; ?>";
            const creatorId = <?php echo (int)$creatorid?>;
            const userId = <?php echo (int)$userId?>;

            createGrid(seatingGrid, rows, cols, meetingName, userEmail);
            updateMeetingInfo(meetingName);
            setInterval(() => updateMeetingInfo(meetingName), 1000);

            activateCommandButton.addEventListener('click', () => {
                activateSelectedCommand(meetingName);
            });

            if (creatorId != userId) {
                document.getElementById('buttonForActivatingCommands').style.display = "none";
            }
        });
    </script>

    <section class="overlay" id="overlay"></section>
    <script src="popUpManagement.js"></script>

    <section id="controls">
        <button id="buttonForActivatingCommands" onclick="openPopup('commandPopup')">Activate Command</button>
        <button onclick="openPopup('imagePopup')">Display an image</button>
        <button onclick="openPopup('soundPopup')">Play a sound</button>
        <button onclick="openPopup('videoPopup')">Play a video</button>
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

            <button id ="activateCommandButton">Activate</button>
        </section>
    </section>
    
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

            <label for="videoVolume">Volume:</label>
            <input type="range" id="videoVolume" min="0" max="100" value="50">
            <span id="videoVolumeValue">50</span><br><br>    

            <button onclick="playVideo()">Play</button>
        </section>
    </section>

    <script src="playVideo.js"></script>
</body>
</html>