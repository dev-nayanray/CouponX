jQuery(document).ready(function($){
    // Media uploader
    $('#upload_coupon_image_button').click(function(e) {
        e.preventDefault();
        
        var image_frame = wp.media({
            title: 'Select Coupon Image',
            multiple: false,
            library: { type: 'image' }
        });

        image_frame.on('select', function() {
            var attachment = image_frame.state().get('selection').first().toJSON();
            $('#coupon_image_id').val(attachment.id);
            $('#coupon_image_preview').html('<img src="' + attachment.url + '" style="max-width:200px;">');
        });

        image_frame.open();
    });
});