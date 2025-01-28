document.querySelectorAll('.eventCard').forEach(card => {
    card.addEventListener('click', function (e) {
        const eventName = this.querySelector('h3').textContent.trim();
        const href = "../event/event.php?name=" + eventName;
        this.setAttribute('href', href);
    });
});