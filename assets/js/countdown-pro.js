document.addEventListener('DOMContentLoaded', function() {
    const countdowns = document.querySelectorAll('.deal-pro-countdown');
    
    countdowns.forEach(countdown => {
        const targetDate = new Date(countdown.dataset.date).getTime();
        
        function updateCountdown() {
            const now = new Date().getTime();
            const distance = targetDate - now;

            if (distance < 0) {
                clearInterval(interval);
                countdown.innerHTML = '<div class="countdown-expired">Offer Expired!</div>';
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

            // Add animation class
            countdown.querySelectorAll('.countdown-number').forEach(num => {
                num.classList.add('animate-pulse');
                setTimeout(() => num.classList.remove('animate-pulse'), 300);
            });
        }

        // Update immediately and then every second
        updateCountdown();
        const interval = setInterval(updateCountdown, 1000);
    });
});