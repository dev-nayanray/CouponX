jQuery(document).ready(function($) {
    // Initialize masonry with imagesLoaded
    var $grid = $('.premium-coupon-masonry').imagesLoaded(function() {
        $grid.masonry({
            itemSelector: '.masonry-item',
            columnWidth: '.masonry-item',
            percentPosition: true,
            transitionDuration: '0.6s',
            stagger: 30
        });
    });

    // Interactive reveal effect with animation
    $('.is-style-premium-reveal').on('click', function(e) {
        e.preventDefault();
        var $card = $(this).closest('.premium-card');
        $card.toggleClass('code-revealed');
        $card.find('.reveal-icon').toggleClass('fa-chevron-down fa-chevron-up');
        
        if ($card.hasClass('code-revealed')) {
            $card.find('.reveal-text').text('Code Revealed!');
        } else {
            $card.find('.reveal-text').text('Reveal Exclusive Code');
        }
    });
});