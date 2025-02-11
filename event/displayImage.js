function displayImage () {
	const image = document.getElementById('imageSelect').value;
	var data = {"action":image};
	 fetch("addAction.php",{
      method: 'POST',
	  
	  headers: {
               'Content-Type': 'application/json'   },
      body: JSON.stringify(data),
      
    }).then(response => { return response.text();}).then(response => {console.log(response);});
    
    let location = "../reactionImages/" + image + ".png";
    window.location.href = location;
	
}