<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tailwind_theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php  
	if ( has_post_thumbnail() ) {
		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'featured-image' );
		//var_dump($thumb);
		if ( ! empty( $thumb[0] ) ) {
			//echo get_the_post_thumbnail( $post->ID, 'full', array( 'class' => 'post-thumbnail' ) );
			?>
			<div class="relative w-full mb-4"><img class="post-thumbnail w-full mx-auto shadow-md" width="1200px" height="675px" alt="<?php the_title(); ?>" src="<?php echo $thumb[0] ?>" decoding="async" /></div>
			<?php 
		}
	}else{
		?><div class="relative w-full"><img class="post-thumbnail w-full mx-auto shadow-md" width="1200px" height="675px" alt="" decoding="async" src="<?php echo get_template_directory_uri(); ?>/public/imgs/dummy.jpg" /></div><?php
	}
	
	?>
	<div class="entry-content bg-white px-4 md:px-0 py-8 mx-2 md:mx-0">
		<?php
		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<p class="text-sm">
					<?php tailtheme_posted_on(); ?> <?php tailtheme_posted_by(); ?>
				</p>
			</div><!-- .entry-meta -->
		<?php 
		endif;

		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'tailtheme' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'tailtheme' ),
				'after'  => '</div>',
			)
		);

		get_template_part( 'template-parts/share', 'social');

		?>
	</div><!-- .entry-content -->

	<!--<footer class="entry-footer border-[1px] border-gray px-4 py-8 rounded-lg shadow-md">
		<?php //tailtheme_entry_footer(); ?>
	</footer>-->
</article><!-- #post-<?php the_ID(); ?> -->
