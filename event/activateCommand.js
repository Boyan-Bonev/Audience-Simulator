function activateSelectedCommand(meetingName) {
    const selectedCommand = document.getElementById("commandSelect").value;
    const delay = parseInt(document.getElementById("delayInput").value);
    const minPoints = parseInt(document.getElementById("pointsInput").value);
    const url = `activateCommand.php?name=${meetingName}&currentCommand=${selectedCommand}&delay=${delay}&commandMinPoints=${minPoints}`;

    fetch(url, {method: 'GET'})
      .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text();
      })  
      .then(data => {
        console.log("PHP response:", data); // Log the text to the console
      })
      .catch(error => {
        console.error("Fetch error:", error);
      });

    closePopup('commandPopup');
}