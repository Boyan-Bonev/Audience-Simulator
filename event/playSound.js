const volumeSlider = document.getElementById("volumeSlider");
const volumeValueDisplay = document.getElementById("volumeValue");

volumeSlider.oninput = function() {
    volumeValueDisplay.textContent = this.value;
};

function playSound() {
    const selectedValue = soundSelect.value;
    const selectedVolume = volumeSlider.value;
	var data = {"action":selectedValue};
	 fetch("addAction.php",{
      method: 'POST',
	  
	  headers: {
               'Content-Type': 'application/json'   },
      body: JSON.stringify(data),
      
    }).then(response => { return response.text();}).then(response => {console.log(response);});
    const queryString = `?sound=${selectedValue}&volume=${selectedVolume}`;

    window.location.href = '../eventButtons/playSound/playSound.html' + queryString;
}