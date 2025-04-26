(function($) {
    'use strict';

    // Initialize media uploader
    $(document).ready(function() {
        var mediaFrame;
        var $mediaContainer;
        var $imageInput;
        var $imagePreview;
        var $removeBtn;

        // Media upload handler
        $(document).on('click', '.upload-image-btn', function(e) {
            e.preventDefault();
            
            $mediaContainer = $(this).closest('.couponx-media-upload');
            $imageInput = $mediaContainer.find('input[type="hidden"]');
            $imagePreview = $mediaContainer.find('.image-preview');
            $removeBtn = $mediaContainer.find('.remove-image-btn');

            // Create media frame
            mediaFrame = wp.media({
                title: $mediaContainer.find('.upload-image-btn').data('uploader-title'),
                button: {
                    text: $mediaContainer.find('.upload-image-btn').data('uploader-btn-text')
                },
                library: {
                    type: 'image'
                },
                multiple: false
            });

            // Handle selection
            mediaFrame.on('select', function() {
                var attachment = mediaFrame.state().get('selection').first().toJSON();
                $imageInput.val(attachment.id).trigger('change');
                $imagePreview.html(
                    $('<img>').attr('src', attachment.sizes.medium.url)
                );
                $removeBtn.show();
            });

            mediaFrame.open();
        });

        // Remove image handler
        $(document).on('click', '.remove-image-btn', function(e) {
            e.preventDefault();
            
            $mediaContainer = $(this).closest('.couponx-media-upload');
            $imageInput = $mediaContainer.find('input[type="hidden"]');
            $imagePreview = $mediaContainer.find('.image-preview');
            
            $imageInput.val('');
            $imagePreview.html('');
            $(this).hide();
        });

        // Handle media state changes
        $(document).on('change', 'input[type="hidden"].coupon-image-id', function() {
            var val = $(this).val();
            if (!val) {
                $(this).closest('.couponx-media-upload')
                    .find('.remove-image-btn').hide();
            }
        });
    });

})(jQuery);