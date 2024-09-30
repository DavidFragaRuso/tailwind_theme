<?php
/**
 * Añadir metaboxes de SEO en páginas, entradas y tipos de post personalizados.
 */

add_action( 'add_meta_boxes', 'register_seo_metaboxes' );
function register_seo_metaboxes() {
    // Meta Box para el título SEO
    add_meta_box(
        'seo_meta_title',
        __('SEO Meta Title', 'tailtheme'),
        'seo_meta_title_callback',
        ['post', 'page'],
        'normal',
        'high'
    );
    
    // Meta Box para la descripción SEO
    add_meta_box(
        'seo_meta_description',
        __('SEO Meta Description', 'tailtheme'),
        'seo_meta_description_callback',
        ['post', 'page'],
        'normal',
        'high'
    );
    
    // Meta Box para la opción de no indexar/seguir
    add_meta_box(
        'seo_meta_robots',
        __( 'SEO Meta Robots', 'tailtheme' ),
        'seo_meta_robots_callback',
        ['post', 'page'],
        'normal',
        'high'
    );
}

function seo_meta_title_callback($post) {
    $meta_title = get_post_meta($post->ID, '_seo_meta_title', true);
    ?>
    <input type="text" name="seo_meta_title" value="<?php echo esc_attr($meta_title); ?>" maxlength="60" style="width:100%;" />
    <p>Longitud recomendada: 50-60 caracteres.</p>
    <?php
}

function seo_meta_description_callback($post) {
    $meta_description = get_post_meta($post->ID, '_seo_meta_description', true);
    ?>
    <textarea name="seo_meta_description" maxlength="160" style="width:100%; height:100px;"><?php echo esc_textarea($meta_description); ?></textarea>
    <p>Longitud recomendada: 150-160 caracteres.</p>
    <?php
}

function seo_meta_robots_callback( $post ) {
    // Recuperar los valores de los meta fields
    $noindex = get_post_meta($post->ID, '_seo_noindex', true);
    $nofollow = get_post_meta($post->ID, '_seo_nofollow', true);

    // Checkbox para 'noindex'
    echo '<label for="seo_noindex">';
    echo '<input type="checkbox" name="seo_noindex" id="seo_noindex" value="1"' . checked($noindex, '1', false) . '/>';
    echo ' No indexar esta página';
    echo '</label><br>';

    // Checkbox para 'nofollow'
    echo '<label for="seo_nofollow">';
    echo '<input type="checkbox" name="seo_nofollow" id="seo_nofollow" value="1"' . checked($nofollow, '1', false) . '/>';
    echo ' No seguir enlaces en esta página';
    echo '</label>';
}

function save_seo_meta_boxes($post_id) {
    // Evitar auto-guardado
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Verificar permisos del usuario
    if (isset($_POST['post_type']) && $_POST['post_type'] == 'page') {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Guardar meta título
    if (isset($_POST['seo_meta_title'])) {
        update_post_meta($post_id, '_seo_meta_title', sanitize_text_field($_POST['seo_meta_title']));
    }

    // Guardar meta descripción
    if (isset($_POST['seo_meta_description'])) {
        update_post_meta($post_id, '_seo_meta_description', sanitize_textarea_field($_POST['seo_meta_description']));
    }

    // Guardar 'noindex'
    if (isset($_POST['seo_noindex'])) {
        update_post_meta($post_id, '_seo_noindex', '1');
    } else {
        delete_post_meta($post_id, '_seo_noindex');
    }

    // Guardar 'nofollow'
    if (isset($_POST['seo_nofollow'])) {
        update_post_meta($post_id, '_seo_nofollow', '1');
    } else {
        delete_post_meta($post_id, '_seo_nofollow');
    }
}
add_action('save_post', 'save_seo_meta_boxes');

// Añadir campos a categorías y etiquetas
function add_seo_term_fields() {
    ?>
    <div class="form-field">
        <label for="seo_noindex"><?php _e('No indexar esta categoría/etiqueta', 'text-domain'); ?></label>
        <input type="checkbox" name="seo_noindex" id="seo_noindex" value="1" />
    </div>
    <div class="form-field">
        <label for="seo_nofollow"><?php _e('No seguir enlaces en esta categoría/etiqueta', 'text-domain'); ?></label>
        <input type="checkbox" name="seo_nofollow" id="seo_nofollow" value="1" />
    </div>
    <?php
}
add_action('category_add_form_fields', 'add_seo_term_fields');
add_action('post_tag_add_form_fields', 'add_seo_term_fields');

// Editar los campos de categorías y etiquetas
function edit_seo_term_fields($term) {
    $noindex = get_term_meta($term->term_id, '_seo_noindex', true);
    $nofollow = get_term_meta($term->term_id, '_seo_nofollow', true);
    ?>
    <tr class="form-field">
        <th scope="row"><label for="seo_noindex"><?php _e('No indexar esta categoría/etiqueta', 'text-domain'); ?></label></th>
        <td><input type="checkbox" name="seo_noindex" id="seo_noindex" value="1" <?php checked($noindex, '1'); ?> /></td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="seo_nofollow"><?php _e('No seguir enlaces en esta categoría/etiqueta', 'text-domain'); ?></label></th>
        <td><input type="checkbox" name="seo_nofollow" id="seo_nofollow" value="1" <?php checked($nofollow, '1'); ?> /></td>
    </tr>
    <?php
}
add_action('category_edit_form_fields', 'edit_seo_term_fields');
add_action('post_tag_edit_form_fields', 'edit_seo_term_fields');

// Guardar datos al actualizar categorías y etiquetas
function save_seo_term_fields($term_id) {
    if (isset($_POST['seo_noindex'])) {
        update_term_meta($term_id, '_seo_noindex', '1');
    } else {
        delete_term_meta($term_id, '_seo_noindex');
    }

    if (isset($_POST['seo_nofollow'])) {
        update_term_meta($term_id, '_seo_nofollow', '1');
    } else {
        delete_term_meta($term_id, '_seo_nofollow');
    }
}
add_action('created_category', 'save_seo_term_fields');
add_action('edited_category', 'save_seo_term_fields');
add_action('created_post_tag', 'save_seo_term_fields');
add_action('edited_post_tag', 'save_seo_term_fields');

// Mostrar metadatos SEO en el front-end
function add_seo_meta_tags() {
    global $post;

    // Optimización: Recuperar los metadatos solo si la página o entrada actual requiere meta etiquetas.
    if (is_singular(['post', 'page'])) {
        $meta_title = get_post_meta($post->ID, '_seo_meta_title', true);
        $meta_description = get_post_meta($post->ID, '_seo_meta_description', true);

        if ($meta_title) {
            echo '<meta name="title" content="' . esc_attr($meta_title) . '">' . "\n";
        }

        if ($meta_description) {
            echo '<meta name="description" content="' . esc_attr($meta_description) . '">' . "\n";
        }

        $noindex = get_post_meta($post->ID, '_seo_noindex', true);
        $nofollow = get_post_meta($post->ID, '_seo_nofollow', true);
    } elseif (is_category() || is_tag()) {
        $term = get_queried_object();
        $noindex = get_term_meta($term->term_id, '_seo_noindex', true);
        $nofollow = get_term_meta($term->term_id, '_seo_nofollow', true);
    }

    // Etiquetas meta robots
    if (isset($noindex) && $noindex == '1' && isset($nofollow) && $nofollow == '1') {
        echo '<meta name="robots" content="noindex, nofollow" />' . "\n";
    } elseif (isset($noindex) && $noindex == '1') {
        echo '<meta name="robots" content="noindex, follow" />' . "\n";
    } elseif (isset($nofollow) && $nofollow == '1') {
        echo '<meta name="robots" content="index, nofollow" />' . "\n";
    }
}
add_action('wp_head', 'add_seo_meta_tags', 1);

/**
 * Add featured images on categories and tags for SEO purposes
 */
// Agregar campo de imagen destacada con vista previa en la pantalla de edición de categorías/etiquetas
function add_term_image_field() {
    ?>
    <div class="form-field term-group">
        <label for="term_image"><?php _e('Imagen destacada', 'tailtheme'); ?></label>
        <input type="hidden" id="term_image" name="term_image" value="" />
        <div id="term-image-preview" style="margin-top:10px;">
            <img src="" alt="" style="max-width:100%; height:auto;" />
        </div>
        <button class="upload_image_button button"><?php _e('Subir/Seleccionar imagen', 'tailtheme'); ?></button>
        <button class="remove_image_button button"><?php _e('Eliminar imagen', 'tailtheme'); ?></button>
    </div>
    <?php
}
add_action('category_add_form_fields', 'add_term_image_field');
add_action('post_tag_add_form_fields', 'add_term_image_field');

// Editar campo con vista previa en la edición de categorías/etiquetas
function edit_term_image_field($term) {
    $term_image = get_term_meta($term->term_id, 'term_image', true);
    ?>
    <tr class="form-field term-group">
        <th scope="row" valign="top">
            <label for="term_image"><?php _e('Imagen destacada', 'tailtheme'); ?></label>
        </th>
        <td>
            <input type="hidden" id="term_image" name="term_image" value="<?php echo esc_attr($term_image); ?>" />
            <div id="term-image-preview" style="margin-top:10px;">
                <?php if ($term_image) { ?>
                    <img src="<?php echo esc_url($term_image); ?>" alt="" style="max-width:100%; height:auto;" />
                <?php } else { ?>
                    <img src="" alt="" style="max-width:100%; height:auto;" />
                <?php } ?>
            </div>
            <button class="upload_image_button button"><?php _e('Subir/Seleccionar imagen', 'tailtheme'); ?></button>
            <button class="remove_image_button button"><?php _e('Eliminar imagen', 'tailtheme'); ?></button>
        </td>
    </tr>
    <?php
}
add_action('category_edit_form_fields', 'edit_term_image_field');
add_action('post_tag_edit_form_fields', 'edit_term_image_field');

function save_term_image_field($term_id) {
    if(isset($_POST['term_image'])){
        update_term_meta($term_id, 'term_image', $_POST['term_image']);
    }
}
add_action('created_category', 'save_term_image_field', 10, 2);
add_action('edited_category', 'save_term_image_field', 10, 2);
add_action('created_post_tag', 'save_term_image_field', 10, 2);
add_action('edited_post_tag', 'save_term_image_field', 10, 2);

function enqueue_term_media_uploader() {
    if(isset($_GET['taxonomy'])) {
        wp_enqueue_media();
        wp_enqueue_script('term_image_script', get_template_directory_uri() . '/public/js/category-image.js', array('jquery'), null, true);
    }
}
add_action('admin_enqueue_scripts', 'enqueue_term_media_uploader');