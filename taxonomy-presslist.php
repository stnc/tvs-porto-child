<?php get_header();
global $porto_mobile_toggle;
$sticky_sidebar = porto_meta_sticky_sidebar();
$sticky = "";
if ($sticky_sidebar) {
	$sticky = "data-plugin-sticky";
}

$mobile_sidebar = porto_get_meta_value('mobile_sidebar');
if ('yes' == $mobile_sidebar) {
	$mobile_sidebar = true;
} elseif ('no' == $mobile_sidebar) {
	$mobile_sidebar = false;
} else {
	$mobile_sidebar = !empty($porto_settings['show-mobile-sidebar']) ? true : false;
}

?>

<div class="row">
	<div
		class="col-lg-3 sidebar porto-alternative-default left-sidebar <?php echo !$mobile_sidebar ? '' : ' mobile-sidebar'; ?>">
		<div class="pin-wrapper">
			<div <?php echo $sticky ?>
				data-plugin-options="<?php echo esc_attr('{"autoInit": true, "minWidth": 992, "containerSelector": ".main-content-wrap","autoFit":true, "paddingOffsetBottom": 10}'); ?>">
				<?php if ($mobile_sidebar && (!isset($porto_mobile_toggle) || false !== $porto_mobile_toggle)): ?>
					<div class="sidebar-toggle"><i class="fa"></i></div>
				<?php endif; ?>
				<div class="sidebar-content">
					<div id="main-sidebar-menu" class="widget_sidebar_menu main-sidebar-menu">
						<?php
						//	https://paulund.co.uk/get-all-categories-in-wordpress
						//  $category_id = $categories[0]->cat_ID;
						$current_category = get_queried_object();
						$ssidebarMenu = get_term_meta($current_category->term_id, 'tvsPressMB_SidebarMenu', true);
						$ssidebarMenu = sanitize_text_field($ssidebarMenu);
						if ($ssidebarMenu) {
							wp_nav_menu(array("menu" => $ssidebarMenu, 'theme_location' => 'header-top-menu'));
						}
						//dynamic_sidebar('tvs-main-sidebar'); ?>
					</div>
				</div>
			</div>
		</div>


	</div>
	<div class="col-lg-9 main-content">
		<div id="content" role="main">
			<?php if (category_description()): ?>
				<div class="page-content row debate-row archive-debate-row  cat-stnc">
					<?php echo category_description(); ?>
				</div>
			<?php endif; ?>




			<?php if (have_posts()): ?>
				<div class="page-presslist clearfix">
					<div class="row presslist-row archive-presslist-row">
						<?php
						$news_count = 0;
						while (have_posts()):
							$news_count++;
							the_post();
							?>
							<div
								class="col-lg-12  col-md-12 offset-lg-0 offset-md-2 custom-sm-margin-bottom-1 single-presslist">
								<?php
								global $porto_settings;
								$post_layout = 'medium';
								$featured_images = porto_get_featured_images();

								$post_class = array();
								$post_class[] = 'post post-' . $post_layout;
								if (isset($porto_settings['post-title-style']) && 'without-icon' == $porto_settings['post-title-style']) {
									$post_class[] = 'post-title-simple';
								}
								?>
								<article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>
									<div class="row">
										<?php if (count($featured_images)): ?>
											<div class="col-lg-5">
												<div class="featured-image" style="margin-bottom: 10px">
													<?php if (has_post_thumbnail()):
														the_post_thumbnail('large', array('class' => 'alignleft-'));
													else:
														$url = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()), 'full'); ?>
														<img src="<?php echo $url ?>" />
													<?php endif ?>
												</div>
											</div>
											<div class="col-lg-7">
											<?php else: ?>
												<div class="col-lg-12">
												<?php endif; ?>

												<div class="post-content">
													<?php
													if (is_sticky() && is_home() && !is_paged()) {
														printf('<span class="sticky-post">%s</span>', esc_html__('Featured', 'porto'));
													}
													?>

													<!-- <h2 class="entry-title"><a href="<?php //the_permalink(); ?>"><?php //the_title(); ?></a></h2> -->
													<h2 class="entry-title"><a target="_blank"
															href="<?php echo get_post_meta(get_the_ID(), 'tvsPressMB_pressUrl', true); ?>"><?php the_title(); ?></a>
													</h2>


													<?php
													$date = get_post_meta(get_the_ID(), 'tvsPressMB_pressDate', true);
													$WpDateFormat = get_option('date_format');
													$WpDateFormat = wp_date($WpDateFormat, strtotime($date));
													?>
													<div class="datetime"><strong><?php echo $WpDateFormat ?></strong></div>


													<?php
													$pressPublication = get_post_meta(get_the_ID(), 'tvsPressMB_pressPublication', true);
													if ($pressPublication != ""): ?>
														<strong> <?php echo $pressPublication ?> </strong> <br>
													<?php endif;


													if (is_user_logged_in() && current_user_can("edit_post", get_the_ID())) {
														edit_post_link("Edit");
													} ?>
													<?php
													porto_render_rich_snippets(false);
													if (!empty($porto_settings['blog-excerpt'])) {
														echo porto_get_excerpt($porto_settings['blog-excerpt-length'], false);

													} else {

														echo '<div class="entry-content">';
														echo porto_the_content();

														wp_link_pages(
															array(
																'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__('Pages:', 'porto') . '</span>',
																'after' => '</div>',
																'link_before' => '<span>',
																'link_after' => '</span>',
																'pagelink' => '<span class="screen-reader-text">' . esc_html__('Page', 'porto') . ' </span>%',
																'separator' => '<span class="screen-reader-text">, </span>',
															)
														);
														echo '</div>';
													}
													?>
													<!-- <div style="float:right">
														<span class="d-block float-sm-end mt-3 mt-sm-0">
														   <a class="btn btn-xs btn-default text-xs text-uppercase" href="<?php //echo get_post_meta(get_the_ID(), 'tvsPressMB_pressUrl', true); ?>">Read more...</a>
														</span>
													</div> -->
												</div>
											</div>
										</div>
										<!-- Post meta after content -->




								</article>


							</div>
						<?php endwhile ?>

					</div>
					<?php porto_pagination(); ?>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php else: ?>
				<p><?php esc_html_e('Apologies, but no results were found for the requested archive.', 'porto'); ?></p>
			<?php endif; ?>

		</div>
	</div>
</div>
<script src="<?php echo get_stylesheet_directory_uri() ?>/assets/js/glightbox.min.js" id="jquery-glightbox-js"></script>

<script>
	var lightboxInlineIframe = GLightbox({
		selector: '.debateBox'
	});
</script>
<?php
get_footer();