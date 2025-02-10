const urlParams = new URLSearchParams(window.location.search);
const sound = urlParams.get('sound');
const volume = urlParams.get('volume');
const audioPlayer = document.getElementById('audioPlayer');

if (sound && volume) {
const soundPath = "../../reactionSounds/" + sound + ".mp3";
audioPlayer.src = soundPath;
audioPlayer.volume = volume / 100;

audioPlayer.onerror = function(error) {
    console.error('Error loading audio:', error);
    alert('An error occurred while loading the sound.');
}

// whenever it loads
audioPlayer.oncanplaythrough = function() {
    audioPlayer.play();
};

audioPlayer.load();
} else {
    console.error("Missing sound or volume parameters.");
    alert('Missing sound or volume parameters.');
}