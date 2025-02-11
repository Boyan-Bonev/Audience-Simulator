function createGrid(seatingGrid, rows, cols, meetingName, userEmail) {
    let selectedSeat = null;

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
                        seat.innerText = " "; // Or "🚫"
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

        selectedSeat = seat;
        seat.classList.add("selected");
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

    fetchUpdatedSeats();
    setInterval(fetchUpdatedSeats, 2000);
}

function updateMeetingInfo(meetingName) {
    fetch(`meeting.php?meetingName=${meetingName}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('meetingName').textContent = data.meeting.name;

                const wantedAt = new Date(data.meeting.commandWantedAt);
                const currentTime = new Date();
                const diffInMilliseconds = wantedAt.getTime() - currentTime.getTime();

                if (!isNaN(wantedAt) && diffInMilliseconds > 0) {
                    document.getElementById('commandText').textContent = data.meeting.currentCommand;
                    document.getElementById('countdown').textContent = Math.round(diffInMilliseconds / 1000);
                } else {
                    document.getElementById('commandText').textContent = "";
                    document.getElementById('countdown').textContent = "";
                }
            } else {
                alert(data.error || 'Failed to fetch meeting info');
                window.location.href = "../dashboard/dashboard.php";
            }
        })
        .catch(error => console.error('Error:', error));
}