jQuery(document).ready(function($) {
    // Media uploader for taxonomy images
    $('.ct-tax-media-button').click(function(e) {
        e.preventDefault();
        
        const button = $(this);
        const wrapper = button.closest('.form-field').find('#taxonomy-image-wrapper');
        const input = button.closest('.form-field').find('#taxonomy-image-id');
        
        // Create media frame
        const frame = wp.media({
            title: 'Select or Upload Image',
            button: { text: 'Use this image' },
            multiple: false
        });

        // Handle image selection
        frame.on('select', function() {
            const attachment = frame.state().get('selection').first().toJSON();
            input.val(attachment.id);
            wrapper.html('<img src="' + attachment.url + '" alt="" style="max-width:200px;"/>');
        });

        frame.open();
    });

    // Remove image handler
    $('.ct-tax-media-remove').click(function(e) {
        e.preventDefault();
        
        const button = $(this);
        const wrapper = button.closest('.form-field').find('#taxonomy-image-wrapper');
        const input = button.closest('.form-field').find('#taxonomy-image-id');
        
        input.val('');
        wrapper.html('');
    });
});