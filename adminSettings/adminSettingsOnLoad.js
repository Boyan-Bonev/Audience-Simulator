function displayEvents(events) {
    const eventList = document.getElementById('eventsList');
    eventList.innerHTML = ""; 

    events.forEach(event => {
        const listItem = document.createElement('li');
        listItem.textContent = event.name + " - " + event.description + " - " + event.participants;
        eventList.appendChild(listItem);
    });
}

// Fetch events and users on page load
window.onload = function() {
    fetch('getEvents.php')
        .then(response => response.json())
        .then(events => {
            displayEvents(events);
        });
    fetch('getUsers.php')
        .then(response => response.json())
        .then(users => {
            const userSelect = document.getElementById('user');
            users.forEach(user => {
                const option = document.createElement('option');
                option.value = user.name;
                option.text = user.name;
                userSelect.appendChild(option);
            });
        });
};