jQuery(document).ready(function($) {
    // Initialize Masonry
    $('.premium-coupon-masonry').masonry({
        itemSelector: '.masonry-item',
        columnWidth: '.masonry-item',
        percentPosition: true,
        transitionDuration: '0.4s'
    });

    // Reveal button functionality
    $('.is-style-premium-reveal').on('click', function(e) {
        e.preventDefault();
        var $card = $(this).closest('.coupon-card');
        $card.toggleClass('revealed');
        $card.find('.coupon-code').slideToggle();
    });

    // Clipboard functionality
    new ClipboardJS('.coupon-code', {
        text: function(trigger) {
            return trigger.innerText.trim();
        }
    });
});