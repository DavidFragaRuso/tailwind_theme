<?php
/**
 * Template part for displaying posts grid
 *
 * @package Tail_Theme
 */

?>
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'block border-1 rounded-lg overflow-hidden border-gray-200 shadow-md bg-white' ); ?>>
        <a href="<?php echo the_permalink(); ?>" rel="bookmark">
            <div class="entry-header">
            <?php

            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
            if ( ! empty( $thumb[0] ) ) {
                echo get_the_post_thumbnail( $post->ID, 'full', array( 'class' => 'post-thumbnail' ) ); 
            }else{
                ?><img class="post-thumbnail" width="900px" height="300px" alt="" src="<?php echo get_template_directory_uri(); ?>/public/imgs/dummy.jpg" /><?php
            }

            ?>    
            </div><!-- .entry-header -->
        </a>
        <div class="p-4">
            <?php
            $tags = get_the_tags();
            if ( $tags ):
            ?>
            <div class="mb-2">
                <?php 
                foreach ( $tags as $tag ){
                    $tag_link = get_tag_link( $tag->term_id );
                    //var_dump( $tag_link );
                    echo '<a class="bg-black px-2 text-white text-xs mr-2 p-1 hover:no-underline bg-secondary hover:text-white hover:bg-primary" href="' . $tag_link . '" rel="tag">' . $tag->name . '</a>'; 
                }
                ?>
            </div>
            <?php
            endif;
            //if ( is_singular() ) :
                //the_title( '<h1 class="entry-title">', '</h1>' );
            //else :
                the_title( '<h2 class="entry-title text-primary text-base leading-[22px] font-medium mt-0 mb-2"><a class="hover:no-underline text-primary hover:text-secondary" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            //endif;

            if ( 'post' === get_post_type() ) :
                ?>
                <div class="entry-meta posted-on text-sm">
                    <?php //dfrwp_posted_on(); ?>
                </div><!-- .entry-meta -->
            <?php endif; ?>
            <?php 
            $excerpt = '';
            if (has_excerpt()) {
                $excerpt = wp_strip_all_tags(get_the_excerpt());
            }
            echo '<p class="text-sm mb-2">' . $excerpt . '</p>';
            ?>   
        </div>
                    
    </article>
