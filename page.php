<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tailwind_theme
 */

get_header();
?>

<main id="primary" class="site-main">

	<?php while ( have_posts() ) :	?>
	<?php 
	if( !is_front_page() ) {
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
		<div class="container pt-12 pb-16">
		<?php
			if (function_exists('custom_breadcrumb')) custom_breadcrumb($post);
				
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title text-white text-shadow mt-0">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title text-white"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;
		?>
		</div>
				
	</header>
	<?php	
	} else {
		?>
		<header class="web-hero bg-gray-400 shadow-md">
			<div class="container flex">
				<div class="hero-content">
					<h1>Recursos de Diseño, Desarrollo Web y SEO para Pymes y Emprendedores</h1>
					<p class="text-lg">Me llamo David Fraga y tengo más de 10 años de experiencia en proyectos de Diseño, Desarrollo Web con wordPress y optimización SEO.</p>
					<a class="btn-primary inline-block mb-16 bg-primary text-white hover:text-secondary p-6">Saber más sobre mí.</a>
				</div>
			</div>
		</header>
		<div class="container py-8">
			<h2>Estamos en 2024 y toda empresa y emprendedor deberia tener una web.</h2>
			<p>En 2013 inicié esta web de manera local en mi ordenador como registro de lo que aprendia. Con el tiempo la puse online para tenerla como manual de consulta, y la utilizé para dar soporte a mis clientes mediante entradas en el blog resolviendo problemas o dudas comunes a mas de uno.</p>
			<p>Este 2024 me he decidido a actualizar los contenidos y ponerlos a disposición de todo emprendedor que quiera iniciar o mejorar su presencia online.</p>
			<a class="btn-primary inline-block mb-16 bg-primary text-white hover:text-secondary p-6" href="/blog/">Artículos y tutoriales</a>
			<h3>Si no tienes tiempo o necesitas un profesional también puedo ayudarte</h3>
			<p>Mi enfoque está en crear soluciones web personalizadas y altamente eficientes, adaptadas a las necesidades de autónomos, pequeñas empresas y particulares que buscan iniciar o mejorar su presencia online.</p>
			<a class="btn-primary inline-block mb-16 bg-primary text-white hover:text-secondary p-6">Solicita una consulta gratuita.</a>
		</div>
		<?php
	}	
	?>
	<div class="block my-8 md:container">
		<?php
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			//if ( comments_open() || get_comments_number() ) :
				//comments_template();
			//endif;
		?>
	</div>
	<?php endwhile; // End of the loop. ?>
</main><!-- #main -->

<?php
//get_sidebar();
get_footer();
