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

jQuery(document).ready(function($) {
    // Media uploader
    $('.couponx-upload-image').click(function(e) {
        e.preventDefault();

        var button = $(this);
        var customUploader = wp.media({
            title: 'Choose Coupon Image',
            library: {
                type: 'image'
            },
            button: {
                text: 'Use this image'
            },
            multiple: false
        }).on('select', function() {
            var attachment = customUploader.state().get('selection').first().toJSON();
            button.siblings('input[type="hidden"]').val(attachment.id);
            button.siblings('.couponx-image-preview').html('<img src="' + attachment.url + '" style="max-width:200px; height:auto;">');
            button.siblings('.couponx-remove-image').show();
        }).open();
    });

    // Remove image
    $('.couponx-remove-image').click(function(e) {
        e.preventDefault();
        $(this).siblings('input[type="hidden"]').val('');
        $(this).siblings('.couponx-image-preview').html('');
        $(this).hide();
    });
});

jQuery(document).ready(function($) {
    // Image upload
    $('.couponx-upload-image').click(function(e) {
        e.preventDefault();
        const button = $(this);
        const customUploader = wp.media({
            title: 'Select Image',
            library: { type: 'image' },
            button: { text: 'Use This Image' },
            multiple: false
        }).on('select', function() {
            const attachment = customUploader.state().get('selection').first().toJSON();
            button.siblings('.couponx-image-preview').html('<img src="'+attachment.url+'" style="max-width:200px;">');
            button.siblings('.couponx-remove-image').show();
            button.siblings('input[type="hidden"]').val(attachment.id);
        }).open();
    });

    // Image removal
    $('.couponx-remove-image').click(function(e) {
        e.preventDefault();
        $(this).siblings('.couponx-image-preview').html('');
        $(this).hide();
        $(this).siblings('input[type="hidden"]').val('');
    });
});

