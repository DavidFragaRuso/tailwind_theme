<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tailwind_theme
 */

global $theme_customizer;

?>

<footer id="colophon" class="site-footer">
	<div class="container">
		<div class="border-t-2 border-primary py-8 flex flex-wrap">
			<div class="footer-widget px-4 mb-8">
				<?php 
				if( has_custom_logo() ) {
					the_custom_logo();
				} else {
					?>
					<span class="footer-site-title text-primary block mb-4"><?php echo bloginfo('name'); ?><br/>
					<?php echo bloginfo('description') ?></span>
					<?php
				}
				?>
				<?php $theme_customizer->tailtheme_render_rrss_links(); ?>
			</div>
			<div class="footer-widget px-4 mb-8">
				<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
					<?php dynamic_sidebar( 'sidebar-2' ); ?>
				<?php endif; ?>
			</div>
			<div class="footer-widget px-4 mb-8">
				<?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
					<?php dynamic_sidebar( 'sidebar-3' ); ?>
				<?php endif; ?>	
			</div>
			<div class="footer-widget px-4 mb-8">
				<?php if ( is_active_sidebar( 'sidebar-4' ) ) : ?>
					<?php dynamic_sidebar( 'sidebar-4' ); ?>
				<?php endif; ?>	
			</div>
		</div>
	</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
