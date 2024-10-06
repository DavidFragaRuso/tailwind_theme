<?php
class Custom_SEO_Meta {
    
    public function __construct() {
        add_action( 'add_meta_boxes', [ $this, 'register_seo_metaboxes' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_custom_admin_scripts' ] );
        add_action( 'save_post', [ $this, 'save_seo_meta_boxes' ] );
        add_action( 'category_add_form_fields', [ $this, 'add_seo_term_fields' ] );
        add_action( 'post_tag_add_form_fields', [ $this, 'add_seo_term_fields' ] );
        add_action( 'category_edit_form_fields', [ $this, 'edit_seo_term_fields' ] );
        add_action( 'post_tag_edit_form_fields', [ $this, 'edit_seo_term_fields' ] );
        add_action( 'created_category', [ $this, 'save_seo_term_fields' ] );
        add_action( 'edited_category', [ $this, 'save_seo_term_fields' ] );
        add_action( 'created_post_tag', [ $this, 'save_seo_term_fields' ] );
        add_action( 'edited_post_tag', [ $this, 'save_seo_term_fields' ] );
        add_action( 'wp_head', [ $this, 'add_seo_meta_tags' ], 1 ); // Priority 1
    }

    public function enqueue_custom_admin_scripts() {
        wp_enqueue_media();
        wp_enqueue_script( 'custom-meta-box-image', get_template_directory_uri() . '/public/js/meta-box-image.js', array('jquery'), null, true );
    }

    public function register_seo_metaboxes() {
        add_meta_box( 'seo_meta_title', __( 'SEO Meta Title', 'tailtheme' ), [ $this, 'seo_meta_title_callback' ], ['post', 'page'], 'normal', 'high' );
        add_meta_box( 'seo_meta_description', __( 'SEO Meta Description', 'tailtheme' ), [ $this, 'seo_meta_description_callback' ], ['post', 'page'], 'normal', 'high' );
        add_meta_box( 'seo_meta_image', __( 'SEO Meta Image', 'tailtheme' ), [ $this, 'seo_meta_image_callback' ], ['post', 'page'], 'normal', 'high' );
        add_meta_box( 'seo_meta_robots', __( 'SEO Meta Robots', 'tailtheme' ), [ $this, 'seo_meta_robots_callback' ], ['post', 'page'], 'normal', 'high' );
    }

    public function seo_meta_title_callback($post) {
        $meta_title = get_post_meta($post->ID, '_seo_meta_title', true);
        echo '<input type="text" name="seo_meta_title" value="' . esc_attr($meta_title) . '" maxlength="60" style="width:100%;" />';
        echo '<p>Recommended length: 50-60 characters.</p>';
    }

    public function seo_meta_description_callback($post) {
        $meta_description = get_post_meta($post->ID, '_seo_meta_description', true);
        echo '<textarea name="seo_meta_description" maxlength="160" style="width:100%; height:100px;">' . esc_textarea($meta_description) . '</textarea>';
        echo '<p>Recommended length: 150-160 characters.</p>';
    }

    public function seo_meta_image_callback($post) {
        wp_nonce_field(basename(__FILE__), 'seo_meta_image_nonce');
        $meta_image = get_post_meta($post->ID, '_seo_meta_image', true);
        ?>
        <input type="hidden" id="selected_image" name="selected_image" value="<?php echo esc_attr($meta_image); ?>" />
        <label for="seo_meta_image">Seleccionar imagen SEO<?php __('Select Image for Open Graph (1200x630px recommended)', 'tailtheme'); ?></label>
        <input type="text" name="seo_metabox_image" id="seo_meta_image" value="<?php echo esc_attr($meta_image ? $meta_image : ''); ?>" style="width:100%;" />
        <input type="button" class="button" id="meta_image_button" value="<?php _e( 'Select / Upload image', 'tailtheme' ); ?>" />
        <input type="button" class="button" id="remove_meta_image_button" value="<?php _e('Delete image', 'tailtheme'); ?>" style="display: <?php echo $meta_image ? 'inline-block' : 'none'; ?>;" />
        <div>
            <img id="seo_meta_image_preview" src="<?php echo esc_attr($meta_image ? $meta_image : ''); ?>" style="max-width:100%; margin-top:10px;" />
        </div>
        <?php
    }

    public function seo_meta_robots_callback($post) {
        $noindex = get_post_meta($post->ID, '_seo_noindex', true);
        $nofollow = get_post_meta($post->ID, '_seo_nofollow', true);

        echo '<label for="seo_noindex"><input type="checkbox" name="seo_noindex" id="seo_noindex" value="1"' . checked($noindex, '1', false) . '/> No indexar esta página</label><br>';
        echo '<label for="seo_nofollow"><input type="checkbox" name="seo_nofollow" id="seo_nofollow" value="1"' . checked($nofollow, '1', false) . '/> No seguir enlaces en esta página</label>';
    }

    public function save_seo_meta_boxes($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    
        if (isset($_POST['post_type']) && $_POST['post_type'] == 'page') {
            if (!current_user_can('edit_page', $post_id)) return;
        } else {
            if (!current_user_can('edit_post', $post_id)) return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

        if (isset($_POST['post_type']) && $_POST['post_type'] == 'page') {
            if (!current_user_can('edit_page', $post_id)) return;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return;
        }

        if (isset($_POST['seo_meta_title'])) {
            update_post_meta($post_id, '_seo_meta_title', sanitize_text_field($_POST['seo_meta_title']));
        }

        if (isset($_POST['seo_meta_description'])) {
            update_post_meta($post_id, '_seo_meta_description', sanitize_textarea_field($_POST['seo_meta_description']));
        }

        if (!isset($_POST['seo_meta_image_nonce']) || !wp_verify_nonce($_POST['seo_meta_image_nonce'], basename(__FILE__))) return;

        if (isset($_POST['selected_image'])) {
            $seo_meta_image = sanitize_text_field($_POST['selected_image']);
            update_post_meta($post_id, '_seo_meta_image', $seo_meta_image);
        } else {
            delete_post_meta($post_id, '_seo_meta_image');
        }

        if (isset($_POST['seo_noindex'])) {
            update_post_meta($post_id, '_seo_noindex', '1');
        } else {
            delete_post_meta($post_id, '_seo_noindex');
        }

        if (isset($_POST['seo_nofollow'])) {
            update_post_meta($post_id, '_seo_nofollow', '1');
        } else {
            delete_post_meta($post_id, '_seo_nofollow');
        }
    }    

    public function add_seo_term_fields() {
        echo '<div class="form-field"><label for="seo_noindex">' . __('No indexar esta categoría/etiqueta', 'text-domain') . '</label><input type="checkbox" name="seo_noindex" id="seo_noindex" value="1" /></div>';
        echo '<div class="form-field"><label for="seo_nofollow">' . __('No seguir enlaces en esta categoría/etiqueta', 'text-domain') . '</label><input type="checkbox" name="seo_nofollow" id="seo_nofollow" value="1" /></div>';
    }

    public function edit_seo_term_fields($term) {
        $noindex = get_term_meta($term->term_id, '_seo_noindex', true);
        $nofollow = get_term_meta($term->term_id, '_seo_nofollow', true);
        
        echo '<tr class="form-field"><th scope="row"><label for="seo_noindex">' . __('No indexar esta categoría/etiqueta', 'text-domain') . '</label></th><td><input type="checkbox" name="seo_noindex" id="seo_noindex" value="1"' . checked($noindex, '1', false) . ' /></td></tr>';
        echo '<tr class="form-field"><th scope="row"><label for="seo_nofollow">' . __('No seguir enlaces en esta categoría/etiqueta', 'text-domain') . '</label></th><td><input type="checkbox" name="seo_nofollow" id="seo_nofollow" value="1"' . checked($nofollow, '1', false) . ' /></td></tr>';
    }

    public function save_seo_term_fields($term_id) {
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

    public function add_seo_meta_tags() {
        $noindex = '';
        $nofollow = '';
        $og_image = '';

        if (is_singular('post') || is_singular('page')) {
            global $post;
            $meta_title = get_post_meta($post->ID, '_seo_meta_title', true);
            $meta_description = get_post_meta($post->ID, '_seo_meta_description', true);
            $noindex = get_post_meta($post->ID, '_seo_noindex', true);
            $nofollow = get_post_meta($post->ID, '_seo_nofollow', true);
            $og_image = get_the_post_thumbnail_url($post->ID);

            //Meta title
            if ($meta_title) {
                echo '<meta name="title" content="' . esc_attr($meta_title) . '">' . "\n";
            }

            //Meta description
            if ($meta_description) {
                echo '<meta name="description" content="' . esc_attr($meta_description) . '">' . "\n";
            }

            //Open Graph Meta Tags
            echo '<meta property="og:locale" content="es_ES" />' . "\n";
            if (is_singular('post')) {
                echo '<meta property="og:type" content="article" />' . "\n"; // Posts
            } elseif (is_page()) {
                echo '<meta property="og:type" content="website" />' . "\n"; // Static pages
            }
            echo '<meta property="og:title" content="' . esc_attr($meta_title) . '" />' . "\n";
            echo '<meta property="og:description" content="' . esc_attr($meta_description) . '" />' . "\n";
            echo '<meta property="og:url" content="' . get_permalink() . '" />' . "\n";
            if ($og_image) {
                echo '<meta property="og:image" content="' . esc_url($og_image) . '" />' . "\n";
            }

             // Twitter Cards Meta Tags
            echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
            echo '<meta name="twitter:title" content="' . esc_attr($meta_title) . '" />' . "\n";
            echo '<meta name="twitter:description" content="' . esc_attr($meta_description) . '" />' . "\n";
            if ($og_image) {
                echo '<meta name="twitter:image" content="' . esc_url($og_image) . '" />' . "\n";
            }

            // Robots Meta Tags
            if ($noindex == '1' && $nofollow == '1') {
                echo '<meta name="robots" content="noindex, nofollow" />' . "\n";
            } elseif ($noindex == '1') {
                echo '<meta name="robots" content="noindex, follow" />' . "\n";
            } elseif ($nofollow == '1') {
                echo '<meta name="robots" content="index, nofollow" />' . "\n";
            }
        }

        if (is_category() || is_tag()) {
            $term = get_queried_object();
            $noindex = get_term_meta($term->term_id, '_seo_noindex', true);
            $nofollow = get_term_meta($term->term_id, '_seo_nofollow', true);

            // Robots Meta Tags for Categories and Tags
            if ($noindex == '1' && $nofollow == '1') {
                echo '<meta name="robots" content="noindex, nofollow" />' . "\n";
            } elseif ($noindex == '1') {
                echo '<meta name="robots" content="noindex, follow" />' . "\n";
            } elseif ($nofollow == '1') {
                echo '<meta name="robots" content="index, nofollow" />' . "\n";
            }
        }
    }
}

new Custom_SEO_Meta();

/**
 * Add featured images on categories and tags for SEO purposes
 */
function add_term_image_field() {
    ?>
    <div class="form-field term-group">
        <label for="term_image"><?php _e('Imagen destacada', 'tailtheme'); ?></label>
        <input type="hidden" id="term_image" name="term_image" value="" />
        <div id="term-image-preview" style="margin-top:10px;">
            <img src="" alt="" style="max-width:100%; height:auto;" />
        </div>
        <button class="upload_image_button button"><?php _e('Upload / Select Image', 'tailtheme'); ?></button>
        <button class="remove_image_button button"><?php _e('Delete image', 'tailtheme'); ?></button>
    </div>
    <?php
}
add_action('category_add_form_fields', 'add_term_image_field', 10);
add_action('post_tag_add_form_fields', 'add_term_image_field', 10);

function edit_term_image_field($term) {
    $term_image = get_term_meta($term->term_id, 'term_image', true);
    ?>
    <tr class="form-field term-group">
        <th scope="row" valign="top">
            <label for="term_image"><?php _e('Featured image', 'tailtheme'); ?></label>
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
            <button class="upload_image_button button"><?php _e('Upload / Select Image', 'tailtheme'); ?></button>
            <button class="remove_image_button button"><?php _e('Delete image', 'tailtheme'); ?></button>
        </td>
    </tr>
    <?php
}
add_action('category_edit_form_fields', 'edit_term_image_field', 10);
add_action('post_tag_edit_form_fields', 'edit_term_image_field', 10);

function save_term_image_field($term_id) {
    if (isset($_POST['term_image'])) {
        update_term_meta($term_id, 'term_image', sanitize_text_field($_POST['term_image']));
    }
}
add_action('created_category', 'save_term_image_field', 10, 2);
add_action('edited_category', 'save_term_image_field', 10, 2);
add_action('created_post_tag', 'save_term_image_field', 10, 2);
add_action('edited_post_tag', 'save_term_image_field', 10, 2);

function enqueue_term_media_uploader() {
    if (isset($_GET['taxonomy'])) {
        wp_enqueue_media();
        wp_enqueue_script('term_image_script', get_template_directory_uri() . '/public/js/category-image.js', array('jquery'), null, true);
    }
}
add_action('admin_enqueue_scripts', 'enqueue_term_media_uploader');