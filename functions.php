<?php
/**
 * tailwind_theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package tailwind_theme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function tailtheme_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on tailwind_theme, use a find and replace
		* to change 'tailtheme' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'tailtheme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary Menu', 'tailtheme' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'tailtheme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

		/**
	 * Add custom font sizes to editor
	 */
	add_theme_support('editor-font-sizes', array(
		array(
			'name' => __('Small', 'tailtheme'),
			'shortName' => __('S', 'tailtheme'),
			'size' => 13,
			'slug' => 'small'
		),
		array(
			'name' => __('Medium', 'tailtheme'),
			'shortName' => __('M', 'tailtheme'),
			'size' => 16,
			'slug' => 'medium'
		),
		array(
			'name' => __('Large', 'tailtheme'),
			'shortName' => __('L', 'tailtheme'),
			'size' => 24,
			'slug' => 'large'
		),
		array(
			'name' => __('Extra Large', 'tailtheme'),
			'shortName' => __('XL', 'tailtheme'),
			'size' => 32,
			'slug' => 'extra-large'
		)
	));

	// Add custom styles to the Gutenberg editor
    add_action('enqueue_block_editor_assets', function() {
        wp_add_inline_style('wp-block-library', '
            :root {
                --wp--preset--font-size--small: 13px;
                --wp--preset--font-size--medium: 16px;
                --wp--preset--font-size--large: 24px;
                --wp--preset--font-size--extra-large: 32px;
            }
        ');
    });

	/**
	 * Add support for align wide for gutenberg blocks
	 */
	add_theme_support('align-wide');

	/**
	 * Customize padding on blocks
	 */
	add_theme_support('custom-spacing');

}
add_action( 'after_setup_theme', 'tailtheme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function tailtheme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'tailtheme_content_width', 640 );
}
add_action( 'after_setup_theme', 'tailtheme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function tailtheme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'tailtheme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'tailtheme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Col Left', 'tailtheme' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here.', 'tailtheme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
		) 
	);
	register_sidebar( array(
        'name'          => esc_html__( 'Footer Col Center', 'tailtheme' ),
        'id'            => 'sidebar-3',
        'description'   => esc_html__( 'Add widgets here.', 'tailtheme' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
	register_sidebar( array(
        'name'          => esc_html__( 'Footer Col Right', 'tailtheme' ),
        'id'            => 'sidebar-4',
        'description'   => esc_html__( 'Add widgets here.', 'tailtheme' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'tailtheme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function tailtheme_scripts() {
	wp_enqueue_style( 'tailtheme-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'tailtheme-style', 'rtl', 'replace' );

	wp_enqueue_script( 'tailtheme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'tailtheme_scripts' );

/**
 * Add SVG files to mime type
 */

 function allow_svg_upload( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'allow_svg_upload' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

