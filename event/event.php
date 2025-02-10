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

    $seats = [];
    $seatQuery = "SELECT row_pos, col_pos, user FROM seating WHERE event_id = 'some_event_id'";
    $seatResult = mysqli_query($conn, $seatQuery);
    while ($seat = mysqli_fetch_assoc($seatResult)) {
        $seats[] = $seat;
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="meetingName">Event Page</title>
    <link rel="stylesheet" href="eventStyle.css">

    <link rel="stylesheet" href="eventStyles.css">
    <style>
        .grid {
            display: grid;
            grid-template-columns: repeat(10, 50px);
            gap: 5px;
            justify-content: center;
            margin-top: 20px;
        }
        .seat {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: lightgray;
            cursor: pointer;
            font-size: 24px;
            border-radius: 5px;
            user-select: none;
            transition: background-color 0.3s;
        }
        .seat.taken {
            background-color: red;
            pointer-events: none;
        }
        .seat.selected {
            background-color: green;
        }
    </style>
</head>
<body>
    <!-- connect it to the currently active command -->
    <section id="commandDisplay">
        Command: <span id="commandText"></span> | Time Left: <span id="countdown"></span>
    </section>

    <div id="seatingGrid" class="grid"></div>

    <script>
        const rows = 5;
        const cols = 10;
        const seatingGrid = document.getElementById("seatingGrid");
        let selectedSeat = null;
        const occupiedSeats = <?php echo json_encode($seats); ?>;

        function createGrid() {
            for (let r = 0; r < rows; r++) {
                for (let c = 0; c < cols; c++) {
                    let seat = document.createElement("div");
                    seat.classList.add("seat");
                    seat.dataset.row = r;
                    seat.dataset.col = c;
                    seat.innerText = "🪑";
                    
                    let takenSeat = occupiedSeats.find(s => s.row_pos == r && s.col_pos == c);
                    if (takenSeat) {
                        seat.classList.add("taken");
                        seat.innerText = "🚫";
                    } else {
                        seat.addEventListener("click", selectSeat);
                    }
                    seatingGrid.appendChild(seat);
                }
            }
        }
        
        function selectSeat(event) {
            if (selectedSeat) {
                selectedSeat.classList.remove("selected");
                selectedSeat.innerText = "🪑";
            }
            
            let seat = event.target;
            let row = seat.dataset.row;
            let col = seat.dataset.col;
            selectedSeat = seat;
            seat.classList.add("selected");
            seat.innerText = "😀";
            
            fetch('saveSeat.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `row=${row}&col=${col}&user=<?php echo $user['email']; ?>`
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert(data.message);
                    seat.classList.remove("selected");
                    seat.innerText = "🪑";
                }
            })
            .catch(error => console.error('Error:', error));
        }
        
        function openPopup(popupId) {
            alert(`${popupId} activated!`); // Placeholder for popup functionality
        }
        
        createGrid();
    </script>
    <!-- make it live! -->

    

    <!-- dynamically adds participants instead of statically-->

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