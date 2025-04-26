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