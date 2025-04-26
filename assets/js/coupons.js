document.addEventListener('DOMContentLoaded', function() {
    // Clipboard initialization
    new ClipboardJS('.copy-button').on('success', function(e) {
        e.trigger.textContent = 'Copied!';
        setTimeout(function() {
            e.trigger.textContent = 'Copy';
        }, 2000);
    });

    // Countdown timers
    document.querySelectorAll('.coupon-card:not(.expired)').forEach(function(card) {
        const expiration = card.querySelector('.expiration-date');
        if (!expiration) return;
        
        const endDate = new Date(expiration.dataset.expiration);
        const timer = card.querySelector('.countdown-timer');
        
        function updateTimer() {
            const now = new Date();
            const diff = endDate - now;
            
            if (diff <= 0) {
                timer.innerHTML = 'Expired';
                card.classList.add('expired');
                return;
            }
            
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            
            timer.innerHTML = `${days}d ${hours}h left`;
        }
        
        updateTimer();
        setInterval(updateTimer, 3600000);
    });
});