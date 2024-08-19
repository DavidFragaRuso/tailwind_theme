<?php
function custom_breadcrumb($post) {
    if (!is_home()) {
        ?>
        <nav class="breadcrumb" aria-label="breadcrumb">
            <ol class="flex flex-wrap list-none p-0 m-0">
                <!-- Inicio -->
                <li class="me-4">
                    <a class="text-white text-shadow-sm hover:text-white" href="<?php echo esc_url(home_url('/')); ?>">
                        <?php _e('Inicio', 'tailtheme'); ?>
                    </a>
                    <span class="text-white text-shadow-sm mx-2">></span>
                </li>
                
                <?php
                // Si es una página
                if (is_page()) {
                    if ($post->post_parent) {
                        $parent_id = $post->post_parent;
                        $breadcrumbs = [];
                        while ($parent_id) {
                            $page = get_post($parent_id);
                            $breadcrumbs[] = '<li class="me-4"><a class="text-white text-shadow-sm hover:text-white" href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a><span class="text-white text-shadow-sm mx-2">></span></li>';
                            $parent_id = $page->post_parent;
                        }
                        $breadcrumbs = array_reverse($breadcrumbs);
                        foreach ($breadcrumbs as $crumb) echo $crumb . ' ';
                    }
                    //echo '<li class="me-4"><span class="text-white text-shadow-sm">' . get_the_title($post->ID) . '</span></li>';

                // Si es un post
                } elseif (is_single()) {
                    $categories = get_the_category($post->ID);
                    if ($categories) {
                        $category = $categories[0];
                        $category_link = get_category_link($category->term_id);
                        echo '<li class="me-4"><a class="text-white text-shadow-sm hover:text-white" href="' . esc_url($category_link) . '">' . esc_html($category->name) . '</a><span class="text-white text-shadow-sm mx-2">></span></li>';
                    }
                    //echo '<li class="me-4"><span class="text-white text-shadow-sm">' . get_the_title($post->ID) . '</span></li>';

                // Si es una categoría
                } elseif (is_category()) {
                    //echo '<li class="me-4"><span class="text-white text-shadow-sm">' . single_cat_title('', false) . '</span></li>';

                // Si es una página de archivo
                } elseif (is_archive()) {
                    //echo '<li class="me-4"><span class="text-white text-shadow-sm">' . post_type_archive_title('', false) . '</span></li>';

                // Si es una página de búsqueda
                } elseif (is_search()) {
                    echo '<li class="me-4"><span class="text-white text-shadow-sm">' . sprintf(__('Resultados de búsqueda para "%s"', 'tailtheme'), get_search_query()) . '</span></li>';
                }
                ?>
            </ol>
        </nav>
        <?php
    }
}
