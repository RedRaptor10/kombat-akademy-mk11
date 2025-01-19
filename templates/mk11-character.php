<?php
/**
Template Name: Mortal Kombat 11 - Character
 * @package customify
 */

get_header(); ?>
	<div class="content-inner">
		<?php
		do_action( 'customify/content/before' );

		if ( ! customify_is_e_theme_location( 'single' ) ) {
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/mk11/character' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			endwhile; // End of the loop.
		}
		do_action( 'customify/content/after' );
		?>
	</div><!-- #.content-inner -->
<?php
get_footer();
