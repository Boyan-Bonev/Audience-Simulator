function setRole() {
    const user = document.getElementById('user').value;
    const role = document.getElementById('role').value;
    const messageSection = document.getElementById('message');

    fetch('setRole.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `user=${user}&role=${role}`,
    })
    .then(response => response.text())
    .then(message => {
        messageSection.textContent = message;
    })
    .catch(error => {
        messageSection.textContent = "An error occurred.";
        console.error(error);
    });
}