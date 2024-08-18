jQuery(document).ready(function($){
    var mediaUploader;

    $('.upload_image_button').click(function(e) {
        e.preventDefault();

        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Seleccionar imagen destacada',
            button: {
                text: 'Usar esta imagen'
            }, multiple: false });

        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#term_image').val(attachment.url);
            $('#term-image-preview img').attr('src', attachment.url);
        });

        mediaUploader.open();
    });

    $('.remove_image_button').click(function(e) {
        e.preventDefault();
        $('#term_image').val('');
        $('#term-image-preview img').attr('src', '');
    });
});