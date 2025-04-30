jQuery(document).ready(function($) {
    const swiper = new Swiper('.premium-coupon-carousel', {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 30,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 3,
            },
        },
    });

    // Countdown Timers
    $('.coupon-timer').each(function() {
        const expiry = new Date($(this).data('expiry')).getTime();
        const timerElement = $(this);
        
        function updateTimer() {
            const now = new Date().getTime();
            const distance = expiry - now;
            
            if (distance < 0) {
                timerElement.html('EXPIRED');
                return;
            }
            
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            
            timerElement.find('.days').text(days);
            timerElement.find('.hours').text(hours);
            timerElement.find('.minutes').text(minutes);
        }
        
        setInterval(updateTimer, 1000);
        updateTimer();
    });
});
