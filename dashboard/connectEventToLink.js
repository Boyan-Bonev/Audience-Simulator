document.querySelectorAll('.eventCard').forEach(card => {
    card.addEventListener('click', function (e) {
        const eventName = this.querySelector('h3').textContent.trim();
        const href = "../event/event.html?name=" + eventName;
        this.setAttribute('href', href);
    });
});