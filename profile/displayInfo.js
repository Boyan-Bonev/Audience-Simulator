function displayInfo(info) {
    document.getElementById("pointsLi").textContent = info['points'];
	document.getElementById("otherLi").textContent = info['other'];
	document.getElementById("username").textContent = info['username'];

    
}


window.onload = function() {
    fetch('getInfo.php')
        .then(response => response.json())
        .then(events => {
            displayInfo(events);
        });
    
};