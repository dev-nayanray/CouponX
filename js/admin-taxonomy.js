jQuery(document).ready(function($) {
    // Uploader variable
    var file_frame;

    // Add Image button
    $('.ct_tax_media_button').click(function(e) {
        e.preventDefault();
        var button = $(this);
        var wrapper = button.closest('.form-field').find('#taxonomy-image-wrapper');

        // If media frame exists, reopen it
        if (file_frame) {
            file_frame.open();
            return;
        }

        // Create media frame
        file_frame = wp.media.frames.file_frame = wp.media({
            title: button.data('uploader_title') || 'Select Image',
            button: { text: button.data('uploader_button_text') || 'Use Image' },
            multiple: false
        });

        // When image selected
        file_frame.on('select', function() {
            var attachment = file_frame.state().get('selection').first().toJSON();
            $('#taxonomy-image-id').val(attachment.id);
            wrapper.html('<img src="' + attachment.url + '" alt="" style="max-width:100px;"/>');
        });

        file_frame.open();
    });

    // Remove Image button
    $('.ct_tax_media_remove').click(function(e) {
        e.preventDefault();
        $('#taxonomy-image-id').val('');
        $('#taxonomy-image-wrapper').html('');
    });
});