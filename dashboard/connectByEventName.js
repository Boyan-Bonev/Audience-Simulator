const form = document.getElementById('eventConnectForm');

form.addEventListener('submit', function(event) {
    event.preventDefault();

    const eventName = document.getElementById('eventName').value;
    if (eventName === "") {
        alert("Please enter a link!");
        return;
    }

    let url;
    try {
        url = new URL(eventName);
    } catch (_) {
        url = new URL("http://localhost/Audience-Simulator/event/event.php?name=" + encodeURIComponent(eventName));
    }
    

    window.location.href = url;
});