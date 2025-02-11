const videoTypeSelect = document.getElementById('videoSelect');
const videoSpeedInput = document.getElementById('videoSpeed');
const videoVolumeSlider = document.getElementById('videoVolume');
const videoVolumeValueDisplay = document.getElementById('videoVolumeValue');

videoVolumeSlider.oninput = function() {
    videoVolumeValueDisplay.textContent = this.value;
};

function playVideo() {
    const videoType = videoTypeSelect.value;
    const videoSpeed = videoSpeedInput.value;
    const videoVolume = videoVolumeSlider.value / 100;
	var data = {"action":videoType};
	 fetch("addAction.php",{
      method: 'POST',
	  
	  headers: {
               'Content-Type': 'application/json'   },
      body: JSON.stringify(data),
      
    }).then(response => { return response.text();}).then(response => {console.log(response);});
    const queryString = `?type=${videoType}&speed=${videoSpeed}&volume=${videoVolume}`;
    
    window.location.href = '../eventButtons/playVideo/playVideo.html' + queryString;
};
