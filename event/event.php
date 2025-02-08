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
        <button onclick="openPopup('emojiPopup')">Use an emoji</button>
        <button onclick="openPopup('soundPopup')">Play a sound</button>
        <button onclick="openPopup('videoPopup')">Play a video</button>
        <!-- connect this to the simulation mode -->
        <!-- that's connected to the user's profile --> 
        <label>Simulate: <input type="checkbox"></label>
    </section>

    <section id="commandPopup" class="popup">
        <h2>Activate Command</h2>
        <button onclick="closePopup('commandPopup')">Close</button>
    </section>

    <section id="emojiPopup" class="popup">
        <h2>Select Emoji</h2>
        <button onclick="closePopup('emojiPopup')">Close</button>
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

    <script>
    function openPopup(popupId) {
        document.getElementById(popupId).style.display = "block";
        document.getElementById("overlay").style.display = "block";
    }

    function closePopup(popupId) {
        document.getElementById(popupId).style.display = "none";
        document.getElementById("overlay").style.display = "none";
    }
    </script>

    <script>
        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        const meetingName = getQueryParam('name');
        if (meetingName) {
            console.log(`Connected to event:` + meetingName);
            document.getElementById('meetingName').textContent = meetingName;
            joinMeeting(meetingName);
        }

        // Fetch and update meeting info
        function updateMeetingInfo() {
            fetch(`meeting.php?meeting_name=${meetingName}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('meetingName').textContent = data.meeting.name;

                        const participantsContainer = document.getElementById('participants');
                        participantsContainer.innerHTML = '';

                        const participants = JSON.parse(data.meeting.participants || '[]');

                        // TODO: Have to connect it to the given participant 
                        // in order to be able to access their photo, points and name
                        participants.forEach(participant => {
                            const participantSection = document.createElement('section');
                            participantSection.classList.add('participant');

                            const button = document.createElement('button');
                            button.classList.add('plusOne');
                            button.textContent = '+1';
                            participantSection.appendChild(button);

                            const img = document.createElement('img');
                            img.src = 'placeholder.png';
                            img.alt = `Profile of ${participant}`;
                            participantSection.appendChild(img);

                            participantsContainer.appendChild(participantSection);
                        });
                    } else {
                        alert(data.error || 'Failed to fetch meeting info');
                        window.location.href = "../dashboard/dashboard.php"; 
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function joinMeeting(eventName) {
            fetch('meeting.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `meeting_name=${encodeURIComponent(eventName)}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log(`Joined meeting: ${eventName}`);
                        updateMeetingInfo();
                    } else {
                        alert(data.error || 'Failed to join meeting');
                        window.location.href = "../dashboard/dashboard.php"; 
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Periodically refresh meeting info
        setInterval(updateMeetingInfo, 5000);

        // TODO: 
        /*window.onbeforeunload = function() {
            fetch('/removeUserFromMeeting.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    userId: $_SESSION["user"],
                    meetingName: meetingName
                })
            });
        };*/
        window.onload = function() {
            fetch(`addUserToMeeting.php?meetingName=${meetingName}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
                })
            .then(data => {
                console.log(data);
                })
            .catch(error => {
                console.error('There has been a problem with your fetch operation:', error);
                });
        };

        updateMeetingInfo();
    </script>

</body>
</html>