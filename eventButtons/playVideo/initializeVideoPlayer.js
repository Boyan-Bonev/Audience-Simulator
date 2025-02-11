urlParams = new URLSearchParams(window.location.search);
const videoType = urlParams.get('type');
const videoVolume = urlParams.get('volume');
const videoPlayer = document.getElementById('videoPlayer');

if (videoType && videoSpeed && videoVolume) {
  const videoPath = "../../reactionClips/" + videoType + ".mp4";
  videoPlayer.src = videoPath;
  videoPlayer.volume = videoVolume;

  videoPlayer.onerror = function(error) {
      console.error('Error loading video:', error);
      alert('An error occurred while loading the video.');
  };

  videoPlayer.oncanplaythrough = function() {
      videoPlayer.play();
  };

  videoPlayer.load();
} else {
  console.error("Missing video parameters.");
  alert("Missing video parameters. Please check the URL.");
}