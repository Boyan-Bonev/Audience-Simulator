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
    $seatQuery = "SELECT row_pos, col_pos, user FROM seating WHERE event_id = 2";
    $seatResult = mysqli_query($conn, $seatQuery);
    while ($seat = mysqli_fetch_assoc($seatResult)) {
        $seats[] = $seat;
    }

    $meetingName = $_GET['name'];
    $meetingQuery = "SELECT row_num,col_num FROM events.meetings WHERE name = '$meetingName' LIMIT 1";
    $resultMeeting = mysqli_query($conn,$meetingQuery);
    $meetingRow = mysqli_fetch_assoc($resultMeeting);
    $rows = $meetingRow['row_num'];
    $cols = $meetingRow['col_num'];
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

    <script>
        const seatingGrid = document.getElementById("seatingGrid");
        const rows = <?php echo (int)$rows?>;
        const cols = <?php echo (int)$cols?>;
        let selectedSeat = null;

const meetingName = "<?php echo htmlspecialchars($meetingName); ?>";
const userEmail = "<?php echo $user['email']; ?>"; 

// Function to create the seating grid
function createGrid() {
    seatingGrid.innerHTML = ""; 
    seatingGrid.style.gridTemplateColumns = `repeat(${cols}, 1fr)`;

    for (let r = 0; r < rows; r++) {
        for (let c = 0; c < cols; c++) {
            let seat = document.createElement("section");
            seat.classList.add("seat");
            seat.dataset.row = r;
            seat.dataset.col = c;
            seat.innerText = "🪑";
            seat.addEventListener("click", selectSeat);
            seatingGrid.appendChild(seat);
        }
    }
}

        // fetch seat updates every 2 seconds
        function fetchUpdatedSeats() {
            fetch(`fetchSeats.php?name=${encodeURIComponent(meetingName)}`)
                .then(response => response.json())
                .then(data => {
                    document.querySelectorAll('.seat').forEach(seat => {
                        let row = seat.dataset.row;
                        let col = seat.dataset.col;
                        let takenSeat = data.find(s => s.row_pos == row && s.col_pos == col);

                if (takenSeat) {
                    seat.classList.add("taken");
                    // seat.innerText = "🚫";
                    seat.innerText = " ";
                    seat.removeEventListener("click", selectSeat);
                } else if (!seat.classList.contains("selected")) {
                    seat.classList.remove("taken");
                    seat.innerText = "🪑";
                    seat.addEventListener("click", selectSeat);
                }
            });
        })
        .catch(error => console.error('Error fetching seat updates:', error));
}

        function selectSeat(event) {
            let seat = event.target;
            let row = seat.dataset.row;
            let col = seat.dataset.col;

            if (selectedSeat) {
                let prevRow = selectedSeat.dataset.row;
                let prevCol = selectedSeat.dataset.col;

                fetch(`deselectSeat.php?name=${encodeURIComponent(meetingName)}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `row=${prevRow}&col=${prevCol}&user=${encodeURIComponent(userEmail)}`
                }).catch(error => console.error('Error:', error));

                selectedSeat.classList.remove("selected");
                selectedSeat.innerText = "🪑";
            }

    // Now, select the new seat
    selectedSeat = seat;
    seat.classList.add("selected");
    // seat.innerText = "😀";
    seat.innerText = " ";

            fetch(`saveSeat.php?name=${encodeURIComponent(meetingName)}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `row=${row}&col=${col}&user=${encodeURIComponent(userEmail)}`
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert(data.message);
                    seat.classList.remove("selected");
                    seat.innerText = "🪑";
                } else {
                    fetchUpdatedSeats();
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function handleUserLeaving() {
            if (selectedSeat) {
                let row = selectedSeat.dataset.row;
                let col = selectedSeat.dataset.col;

                fetch(`releaseSeat.php?name=${encodeURIComponent(meetingName)}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `row=${row}&col=${col}&user=${encodeURIComponent(userEmail)}`
                })
                .catch(error => console.error('Error releasing seat:', error));
            }
        }

        window.addEventListener('beforeunload', handleUserLeaving);
        window.addEventListener('unload', handleUserLeaving); // Extra safety measure

        createGrid();
        fetchUpdatedSeats();
        setInterval(fetchUpdatedSeats, 2000);

        // Fetch and update meeting info
        function updateMeetingInfo() {
            fetch(`meeting.php?meeting_name=${meetingName}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('meetingName').textContent = data.meeting.name;
                        document.getElementById('commandText').textContent = data.meeting.currentCommand;
                        const wantedAt = new Date(data.meeting.commandWantedAt);
                        const currentTime = new Date();
                        const diffInMilliseconds = wantedAt.getTime() - currentTime.getTime();
                        if (!isNaN(wantedAt) && diffInMilliseconds > 0) {
                            document.getElementById('countdown').textContent = Math.round(diffInMilliseconds / 1000);
                        } else {
                            document.getElementById('countdown').textContent = "";
                        }
                    } else {
                        alert(data.error || 'Failed to fetch meeting info');
                        window.location.href = "../dashboard/dashboard.php"; 
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Periodically refresh meeting info
        setInterval(updateMeetingInfo, 1000);

        updateMeetingInfo();
    </script>

    <section class="overlay" id="overlay"></section>
    <script src="popUpManagement.js"></script>

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

            <button id ="activateCommandButton">Activate</button>
        </section>
    </section>
    
    <script> 
        activateCommandButton.addEventListener('click', () => {
            activateSelectedCommand(meetingName);
        });
    </script>

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