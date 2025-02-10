const volumeSlider = document.getElementById("volumeSlider");
const volumeValueDisplay = document.getElementById("volumeValue");

volumeSlider.oninput = function() {
    volumeValueDisplay.textContent = this.value;
};

function playSound() {
    const selectedValue = soundSelect.value;
    const selectedVolume = volumeSlider.value;
    const queryString = `?sound=${selectedValue}&volume=${selectedVolume}`;

    window.location.href = '../eventButtons/playSound/playSound.html' + queryString;
}