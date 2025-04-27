document.addEventListener('DOMContentLoaded', function() {
    function updateCountdown() {
        document.querySelectorAll('.modern-countdown').forEach(function(countdown) {
            const targetDate = new Date(countdown.dataset.date).getTime();
            const now = new Date().getTime();
            const distance = targetDate - now;

            if (distance < 0) {
                countdown.innerHTML = "<div class='expired-message'>Offer Expired!</div>";
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            countdown.querySelector('.days').textContent = days.toString().padStart(2, '0');
            countdown.querySelector('.hours').textContent = hours.toString().padStart(2, '0');
            countdown.querySelector('.minutes').textContent = minutes.toString().padStart(2, '0');
            countdown.querySelector('.seconds').textContent = seconds.toString().padStart(2, '0');
        });
    }

    // Update immediately and then every second
    updateCountdown();
    setInterval(updateCountdown, 1000);
});