jQuery(document).ready(function ($) {
    var mediaUploader;

    $('#meta_image_button').on('click', function (event) {
        event.preventDefault();
        console.log('Botón de selección de imagen clicado'); // Para depuración

        // Si ya existe una ventana de selección de archivos abierta, ciérrala
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        // Crear una nueva ventana de selección de archivos
        mediaUploader = wp.media({
            title: 'Seleccionar o Subir Imagen',
            button: {
                text: 'Usar esta imagen'
            },
            multiple: false
        });

        // Al seleccionar la imagen
        mediaUploader.on('select', function () {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            console.log(attachment);
            $('#selected_image').val(attachment.url); // Guarda la URL en el campo oculto
            console.log('URL de la imagen seleccionada: ' + attachment.url); // Para depuración
            $('#seo_meta_image_preview').attr('src', attachment.url); // Actualiza la vista previa
        });

        // Abre la ventana de selección
        mediaUploader.open();
    });
});
