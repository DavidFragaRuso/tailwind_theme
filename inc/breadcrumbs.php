<?php
function custom_breadcrumb($post) {
    if (!is_home()) {
        // Iniciamos la estructura JSON-LD
        $breadcrumbs_json = array(
            "@context" => "https://schema.org",
            "@type" => "BreadcrumbList",
            "itemListElement" => array()
        );

        // Array que contendrá los breadcrumbs
        $position = 1;
        $breadcrumbs = array();

        echo '<nav class="breadcrumb" aria-label="breadcrumb"><ol class="flex flex-wrap list-none p-0 m-0">';

        // Enlace al inicio
        echo '<li class="me-4"><a class="text-white text-shadow-sm hover:text-white" href="' . esc_url(home_url('/')) . '">' . __('Inicio', 'tailtheme') . '</a><span class="text-white text-shadow-sm mx-2">></span></li>';
        $breadcrumbs[] = array(
            "@type" => "ListItem",
            "position" => $position++,
            "name" => "Inicio",
            "item" => home_url('/')
        );

        if (is_page()) {
            if ($post->post_parent) {
                $parent_id = $post->post_parent;
                $page_breadcrumbs = array();
                while ($parent_id) {
                    $page = get_post($parent_id);
                    $page_breadcrumbs[] = '<li class="me-4"><a class="text-white text-shadow-sm hover:text-white" href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a><span class="text-white text-shadow-sm mx-2">></span></li>';
                    $breadcrumbs[] = array(
                        "@type" => "ListItem",
                        "position" => $position++,
                        "name" => get_the_title($page->ID),
                        "item" => get_permalink($page->ID)
                    );
                    $parent_id = $page->post_parent;
                }
                $page_breadcrumbs = array_reverse($page_breadcrumbs);
                foreach ($page_breadcrumbs as $crumb) echo $crumb;
            }
            //echo '<li class="me-4"><span class="text-white text-shadow-sm">' . get_the_title($post->ID) . '</span></li>';
            $breadcrumbs[] = array(
                "@type" => "ListItem",
                "position" => $position++,
                "name" => get_the_title($post->ID)
            );
        } elseif (is_single()) {
            $categories = get_the_category($post->ID);
            if ($categories) {
                $category = $categories[0];
                $category_link = get_category_link($category->term_id);
                echo '<li class="me-4"><a class="text-white text-shadow-sm hover:text-white" href="' . esc_url($category_link) . '">' . esc_html($category->name) . '</a><span class="text-white text-shadow-sm mx-2">></span></li>';
                $breadcrumbs[] = array(
                    "@type" => "ListItem",
                    "position" => $position++,
                    "name" => esc_html($category->name),
                    "item" => esc_url($category_link)
                );
            }
            //echo '<li class="me-4"><span class="text-white text-shadow-sm">' . get_the_title($post->ID) . '</span></li>';
            $breadcrumbs[] = array(
                "@type" => "ListItem",
                "position" => $position++,
                "name" => get_the_title($post->ID)
            );
        } elseif (is_category()) {
            //echo '<li class="me-4"><span class="text-white text-shadow-sm">' . single_cat_title('', false) . '</span></li>';
            $breadcrumbs[] = array(
                "@type" => "ListItem",
                "position" => $position++,
                "name" => single_cat_title('', false)
            );
        } elseif (is_archive()) {
            //echo '<li class="me-4"><span class="text-white text-shadow-sm">' . post_type_archive_title('', false) . '</span></li>';
            $breadcrumbs[] = array(
                "@type" => "ListItem",
                "position" => $position++,
                "name" => post_type_archive_title('', false)
            );
        } elseif (is_search()) {
            echo '<li class="me-4"><span class="text-white text-shadow-sm">' . sprintf(__('Resultados de búsqueda para "%s"', 'tailtheme'), get_search_query()) . '</span></li>';
            $breadcrumbs[] = array(
                "@type" => "ListItem",
                "position" => $position++,
                "name" => sprintf(__('Resultados de búsqueda para "%s"', 'tailtheme'), get_search_query())
            );
        }

        echo '</ol></nav>';

        // Asignar los breadcrumbs generados a la estructura JSON-LD
        $breadcrumbs_json['itemListElement'] = $breadcrumbs;

        // Imprimir el script JSON-LD
        echo '<script type="application/ld+json">' . json_encode($breadcrumbs_json) . '</script>';
    }
}

