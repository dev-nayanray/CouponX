document.addEventListener('DOMContentLoaded', function() {
    const testimonialSlider = new Swiper('.testimonials-slider.swiper', {
        // Enable loop functionality
        loop: true,
        
        // Navigation arrows
        navigation: {
            nextEl: '.testimonial-swiper-button-next',
            prevEl: '.testimonial-swiper-button-prev',
        },
        
        // Pagination dots
        pagination: {
            el: '.testimonial-swiper-pagination',
            clickable: true,
        },
        
        // Responsive breakpoints
        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            // when window width is >= 768px
            768: {
                slidesPerView: 2,
                spaceBetween: 30
            },
            // when window width is >= 1024px
            1024: {
                slidesPerView: 3,
                spaceBetween: 40
            }
        }
    });
});