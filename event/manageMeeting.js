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
                    img.src = '../userPhotos/placeholder.jpg';
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