jQuery(document).ready(function($) {
    $('.cx-load-more').on('click', function(e) {
        e.preventDefault();
        const button = $(this);
        const page = button.data('page');
        const perPage = button.data('per-page');
        
        button.addClass('loading').prop('disabled', true);
        
        $.ajax({
            url: couponx_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'couponx_load_more_stores',
                security: couponx_ajax.nonce,
                page: page,
                per_page: perPage
            },
            success: function(response) {
                if (response.success) {
                    $('.cx-stores-grid').append(response.data.html);
                    button.data('page', response.data.page);
                    
                    if (response.data.page > response.data.total_pages) {
                        button.hide();
                    }
                }
            },
            complete: function() {
                button.removeClass('loading').prop('disabled', false);
            }
        });
    });
});
jQuery(document).ready(function($) {
    const $container = $('.premium-coupon-masonry');
    const $loadMoreBtn = $('.is-style-load-more');
    let page = 1;
    
    // Initialize masonry
    $container.imagesLoaded(function() {
        $container.masonry({
            itemSelector: '.masonry-item',
            columnWidth: '.masonry-item',
            percentPosition: true
        });
    });

    // Load more handler
    $loadMoreBtn.on('click', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: couponx_vars.ajaxurl,
            type: 'post',
            data: {
                action: 'couponx_load_more',
                page: page + 1,
                nonce: couponx_vars.nonce
            },
            beforeSend: function() {
                $loadMoreBtn.addClass('loading').text('Loading...');
            },
            success: function(response) {
                if(response.success) {
                    const $items = $(response.data.html);
                    
                    $items.imagesLoaded(function() {
                        $container.append($items).masonry('appended', $items);
                        $container.masonry('layout');
                    });
                    
                    page++;
                    if(page >= response.data.max_page) {
                        $loadMoreBtn.hide();
                    }
                }
            },
            complete: function() {
                $loadMoreBtn.removeClass('loading').text('Load More');
            }
        });
    });
});