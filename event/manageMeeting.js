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
                document.getElementById('commandText').textContent = data.meeting.currentCommand;
                const wantedAt = new Date(data.meeting.commandWantedAt);
                const currentTime = new Date();
                const diffInMilliseconds = wantedAt.getTime() - currentTime.getTime();
                if (!isNaN(wantedAt) && diffInMilliseconds > 0) {
                    document.getElementById('countdown').textContent = diffInMilliseconds;
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
setInterval(updateMeetingInfo, 1000);

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