<?php
/**
 * Add metaboxes on pages, posts, custom posts if needed for seo purposes - Meta title and meta description
 * (id, title, callback, screen, context, priority, callback args)
 */

add_action( 'add_meta_boxes', 'register_seo_metaboxes' );
function register_seo_metaboxes() {
    //Title Meta Box
    add_meta_box(
        'seo_meta_title',
        __('SEO Meta Title', 'tailtheme'),
        'seo_meta_title_callback',
        ['post', 'page'],
        'normal',
        'high'
    );
    //Description Meta Box
    add_meta_box(
        'seo_meta_description',
        __('SEO Meta Description', 'tailtheme'),
        'seo_meta_description_callback',
        ['post', 'page'], // Esto añade la metabox a posts y páginas
        'normal',
        'high'
    );
}

function seo_meta_title_callback($post) {
    $meta_title = get_post_meta($post->ID, '_seo_meta_title', true);
    ?>
    <input type="text" name="seo_meta_title" value="<?php echo esc_attr($meta_title); ?>" maxlength="60" style="width:100%;" />
    <p>Recommended length: 50-60 characters.</p>
    <?php
}

function seo_meta_description_callback($post) {
    $meta_description = get_post_meta($post->ID, '_seo_meta_description', true);
    ?>
    <textarea name="seo_meta_description" maxlength="160" style="width:100%; height:100px;"><?php echo esc_textarea($meta_description); ?></textarea>
    <p>Recommended length: 150-160 characters.</p>
    <?php
}

function save_seo_meta_boxes($post_id) {
    // Verifi if is an auto-save
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check user capabilities
    if (isset($_POST['post_type']) && $_POST['post_type'] == 'page') {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save meta Title
    if (isset($_POST['seo_meta_title'])) {
        update_post_meta($post_id, '_seo_meta_title', sanitize_text_field($_POST['seo_meta_title']));
    }

    // Save meta description
    if (isset($_POST['seo_meta_description'])) {
        update_post_meta($post_id, '_seo_meta_description', sanitize_textarea_field($_POST['seo_meta_description']));
    }
}
add_action('save_post', 'save_seo_meta_boxes');

/**
 * Show Metadata on front-end
 */
function add_seo_meta_tags() {
    if (is_single() || is_page()) {
        global $post;
        $meta_title = get_post_meta($post->ID, '_seo_meta_title', true);
        $meta_description = get_post_meta($post->ID, '_seo_meta_description', true);

        if ($meta_title) {
            echo '<meta name="title" content="' . esc_attr($meta_title) . '">' . "\n";
        }

        if ($meta_description) {
            echo '<meta name="description" content="' . esc_attr($meta_description) . '">' . "\n";
        }
    }
}
add_action('wp_head', 'add_seo_meta_tags');

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