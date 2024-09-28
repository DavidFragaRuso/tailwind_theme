<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package tailwind_theme
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php 
	while ( have_posts() ): the_post();
	?>
	
	<header class="entry-header bg-gray-400 shadow-md">
		<!--<div class="post-img">
			<?php 
			//if ( has_post_thumbnail() ) {
				//$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
				//if ( ! empty( $thumb[0] ) ) {
					//echo get_the_post_thumbnail( $post->ID, 'full', array( 'class' => 'post-thumbnail' ) ); 
				//}
				//the_post_thumbnail('full');
			//}else{
				//?><!--<img class="post-thumbnail" width="900px" height="650px" alt="" src="<?php //echo get_template_directory_uri(); ?>/src/imgs/dummy.jpg">--><?php
			//}
			?>
		<!--</div>-->
		<div class="">
			<div class="container pt-12 pb-16">
			<?php 
				if (function_exists('custom_breadcrumb')) custom_breadcrumb($post);
				
				if ( is_singular() ) :
					the_title( '<h1 class="entry-title text-white text-shadow mt-0 mb-0">', '</h1>' );
				else :
					the_title( '<h2 class="entry-title text-white"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif;
				?>
			</div>
			
		</div>	
	</header>
	<div class="block pb-8 md:container lg:grid lg:grid-flow-col lg:gap-8 lg:grid-cols-8">
			<div class="post-content lg:col-span-5 mb-8">
				<?php
				get_template_part( 'template-parts/content', get_post_type() );
				?>
				<div class="my-8">
					<?php 
					$related_posts = get_related_posts(get_the_ID());
					if ($related_posts->have_posts()) :
						?>
						<section class="related-posts px-8">
							<h2><?php _e('Related Posts', 'tailtheme'); ?></h2>
							<div id="related-grid" class="flex flex-col md:grid md:grid-cols-2 md:gap-4 xl:grid-cols-3">
								<?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
									<!--<li><a href="<?php //the_permalink(); ?>"><?php //the_title(); ?></a></li>-->
									<?php get_template_part( 'template-parts/content', 'grid' ); ?>
								<?php endwhile; ?>
							</div>
						</section>
						<?php
					endif;
					?>
				</div>
				<div class="post-navigation md:px-8 my-8">
					<h2><?php _e( 'Post navigation', 'tailtheme' ); ?></h2>
					<?php
					the_post_navigation(
						array(
							'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'tailtheme' ) . '</span> <span class="nav-title">%title</span>',
							'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'tailtheme' ) . '</span> <span class="nav-title">%title</span>',
						)
					);
					?>				
				</div>
				<!--<div class="post-comments">-->
					<h2><?php //_e( 'Comments', 'tailtheme' ); ?></h2>
					<?php 
					// If comments are open or we have at least one comment, load up the comment template.
					//if ( comments_open() || get_comments_number() ) :
						//comments_template();
					//endif;
					?>
				<!--</div>-->
			</div>
			<div class="my-8 mx-4 lg:col-span-3">
				<?php get_sidebar(); ?>
			</div>
		</div>
	<?php
	endwhile;	
	?>	
</main><!-- #main -->

<?php
get_sidebar();
get_footer();
