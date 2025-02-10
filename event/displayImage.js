function displayImage () {
    const image = document.getElementById('imageSelect').value;
    let location = "../reactionImages/" + image + ".png";
    window.location.href = location;
}