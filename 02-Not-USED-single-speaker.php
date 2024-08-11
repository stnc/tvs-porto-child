<?php get_header(); ?>
<?php
/**
 * IMPORtant -- this is only experiment 
 * Please  use  speaker.php  in tvs-debate plugin
 */
$builder_id = porto_check_builder_condition( 'single' );
if ( $builder_id ) {
	echo do_shortcode( '[porto_block id="' . esc_attr( $builder_id ) . '" tracking="layout-single-' . esc_attr( $builder_id ) . '"]' );
} else {
	?>
	<div class="full-width">
	</div>
	<?php
	wp_reset_postdata();

	global $porto_settings, $porto_layout;

	// check portfolio ajax modal
	if ( porto_is_ajax() && isset( $_POST['ajax_action'] ) && 'portfolio_ajax_modal' == $_POST['ajax_action'] ) {
		$porto_settings['portfolio-zoom'] = false;
	}

	add_action( 'porto_after_main', 'porto_display_related_portfolios' );
	?>

	<div id="content" role="main" class="porto-single-page">

		<?php
		if ( have_posts() ) :
			the_post();
			global $post;
			//$portfolio_layout = get_post_meta( $post->ID, 'portfolio_layout', true );
			//$portfolio_layout = ( 'default' == $portfolio_layout || ! $portfolio_layout ) ? ( isset( $porto_settings['portfolio-content-layout'] ) ? $porto_settings['portfolio-content-layout'] : 'medium' ) : $portfolio_layout;
			?>

			<?php 
			// get_template_part( 'content', 'speaker-' . sanitize_file_name( $portfolio_layout ) ); 
			get_template_part( 'content', 'speaker-medium'  ); 
			?>

		<?php endif; ?>
	</div>
<?php 
// Show tooltip to build with Porto Template Builder
porto_add_block_tooltip( 'single' );
} ?>
<?php get_footer(); ?>