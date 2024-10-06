jQuery(document).ready(function($) {
    var mediaUploader;

    $('.upload_image_button').on('click', function(e) {
        e.preventDefault();

        console.log('Botón de selección de imagen clicado'); // Para depuración

        var $button = $(this); // Guardar referencia al botón clicado
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media({
            title: 'Seleccionar imagen destacada',
            button: {
                text: 'Usar esta imagen'
            },
            multiple: false
        });

        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $button.parent().find('#term_image').val(attachment.url);
            $button.parent().find('#term-image-preview img').attr('src', attachment.url);
        });

        mediaUploader.open();
    });

    $('.remove_image_button').on('click', function(e) {
        e.preventDefault();
        var $button = $(this); // Guardar referencia al botón clicado
        $button.parent().find('#term_image').val('');
        $button.parent().find('#term-image-preview img').attr('src', '');
    });
});