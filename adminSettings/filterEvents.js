function filterEvents() {
    const filterText = document.getElementById('filterBy').value.toLowerCase();
    const eventList = document.getElementById('eventList');
    const listItems = eventList.getElementsByTagName('li');

    for (let i = 0; i < listItems.length; i++) {
        const eventName = listItems[i].textContent.toLowerCase();
        if (eventName.includes(filterText)) {
            listItems[i].style.display = "";
        } else {
            listItems[i].style.display = "none";
        }
    }
}