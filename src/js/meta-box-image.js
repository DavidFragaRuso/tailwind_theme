jQuery(document).ready(function($){
    var mediaUploader;

    $('#seo_meta_image_button').on('click', function(e) {
        e.preventDefault();
        // If the uploader object has already been created, reopen the dialog
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        // Extend the wp.media object
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        // When an image is selected, grab the URL and set it as the value of the input
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#seo_meta_image').val(attachment.url);
            $('#seo_meta_image_preview').attr('src', attachment.url);
        });

        // Open the uploader dialog
        mediaUploader.open();
    });
});