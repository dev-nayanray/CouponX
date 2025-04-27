document.addEventListener('DOMContentLoaded', function() {
    function updateCountdowns() {
        document.querySelectorAll('.countdown').forEach(element => {
            let time = element.textContent.split(':');
            let hours = parseInt(time[0]);
            let minutes = parseInt(time[1]);
            let seconds = parseInt(time[2]);

            if (seconds > 0) {
                seconds--;
            } else {
                seconds = 59;
                if (minutes > 0) {
                    minutes--;
                } else {
                    minutes = 59;
                    if (hours > 0) hours--;
                }
            }

            element.textContent = 
                `${hours.toString().padStart(2, '0')}:` +
                `${minutes.toString().padStart(2, '0')}:` +
                `${seconds.toString().padStart(2, '0')}`;
        });
    }

    setInterval(updateCountdowns, 1000);
});