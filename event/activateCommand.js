function activateSelectedCommand() {
    const selectedCommand = document.getElementById("commandSelect").value;
    const delay = parseInt(document.getElementById("delayInput").value);
    const minPoints = parseInt(document.getElementById("pointsInput").value);

    displayCommand(selectedCommand, delay);
	
    closePopup('commandPopup');
}

function displayCommand(command, duration) {
    const commandText = document.getElementById("commandText");
    const countdownDisplay = document.getElementById("countdown");

    commandText.textContent = command;

    let timeLeft = duration;

    if (timeLeft >= 0) {
    countdownDisplay.textContent = timeLeft;
    } else {
    countdownDisplay.textContent = "Time's up!";
    }

    const countdownInterval = setInterval(() => {
        timeLeft--;
        countdownDisplay.textContent = timeLeft;

        if (timeLeft < 0) {
            clearInterval(countdownInterval);
            commandText.textContent = "";
            countdownDisplay.textContent = "";
        }
    }, 1000);
	const data = {"command":command}
    fetch("awardPoints.php",{
  method: "POST",
  headers: {
    "Content-Type": "application/json"
  }
  body: JSON.stringify(data),
  
});	
}