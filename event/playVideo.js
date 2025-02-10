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
    const queryString = `?type=${videoType}&speed=${videoSpeed}&volume=${videoVolume}`;
    
    window.location.href = '../eventButtons/playVideo/playVideo.html' + queryString;
};
