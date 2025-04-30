// assets/js/premium-coupons.js

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Swiper Carousels
    document.querySelectorAll('.premium-coupon-carousel').forEach(carousel => {
      const settings = JSON.parse(carousel.dataset.settings);
      
      new Swiper(carousel, {
        slidesPerView: settings.slides || 3,
        spaceBetween: 30,
        loop: settings.loop,
        autoplay: settings.autoplay ? {
          delay: settings.autoplay,
          disableOnInteraction: false,
        } : false,
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
        breakpoints: {
          320: {
            slidesPerView: 1
          },
          768: {
            slidesPerView: 2
          },
          1024: {
            slidesPerView: settings.slides || 3
          }
        }
      });
    });
  
    // Clipboard Initialization
    new ClipboardJS('.copy-btn').on('success', function(e) {
      const originalText = e.trigger.textContent;
      e.trigger.textContent = couponxSettings.copyText;
      setTimeout(() => {
        e.trigger.textContent = originalText;
      }, 2000);
    });
  
    // Set dynamic carousel slide width
    function setCarouselSlideWidth() {
      document.querySelectorAll('.premium-coupon-carousel').forEach(carousel => {
        const slidesPerView = carousel.swiper ? carousel.swiper.params.slidesPerView : 3;
        carousel.style.setProperty('--slides-per-view', slidesPerView);
      });
    }
  
    window.addEventListener('resize', setCarouselSlideWidth);
    setCarouselSlideWidth();
  });