<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tailwind_theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
<header id="masthead" class="site-header bg-white absolute top-0 right-0 left-0 z-40 shadow-md">
	<div class="extra-head bg-secondary flex">
		<div class="container px-2">
			<span class="float-end text-primary font-bold">Test</span>
		</div>
	</div>
	<div class="container">
		<nav class="flex flex-wrap justify-between py-4 text-black md:flex-nowrap">
			<div id="site-branding" class="flex flex-nowrap items-center">
				<?php 
				if( has_custom_logo() ) {
					the_custom_logo();	
				} else {
					?><span class="text-lg"><a  class="text-primary text-lg font-display font-bold hover:text-secondary hover:no-underline" href="<?php echo esc_url( home_url('/') ) ?>"><?php echo bloginfo('name'); ?></a></span><?php
				}
				?>
			</div>
			<button id="toggle-btn" aria-label="Abrir Menú"  class="navbar-toggler-icon md:invisible">
				<svg class="w-7 h-7" id="menu_icon" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path class="fill-primary" d="M4,10h24c1.104,0,2-0.896,2-2s-0.896-2-2-2H4C2.896,6,2,6.896,2,8S2.896,10,4,10z M28,14H4c-1.104,0-2,0.896-2,2  s0.896,2,2,2h24c1.104,0,2-0.896,2-2S29.104,14,28,14z M28,22H4c-1.104,0-2,0.896-2,2s0.896,2,2,2h24c1.104,0,2-0.896,2-2  S29.104,22,28,22z"/></svg>
			</button>
			<div id="main-menu" class="w-full md:w-auto">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id' => 'primary-menu',
						'items_wrap' => '<ul id="%1$s" class="%2$s  px-2 md:px-0 py-2 md:py-0 md:w-auto md:flex md:flex-row list-none p-0">%3$s</ul>',
					)
				);
				?>	
			</div>
		</nav>
	</div>
</header><!-- #masthead -->
