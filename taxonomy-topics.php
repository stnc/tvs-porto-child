<?php get_header();
require_once("functions-tvs-porto-child.php");
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
						$ssidebarMenu = get_term_meta($current_category->term_id, 'tvsTopicsMB_SidebarMenu', true);
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
				<div class="page-debates clearfix">
					<div class="row debate-row archive-debate-row">
						<?php
						$tvsDebateCommonSettings = get_option('tvsDebate_CommonSettings');
						$tvsDebate_usedAjax = $tvsDebateCommonSettings["tvsDebate_usedAjax"];

						$debate_count = 0;
						while (have_posts()):
							$debate_count++;
							the_post();
							if ($tvsDebate_usedAjax == "yes") {
								$debate_link = '<li><a class="ajax-popup"  href="' . get_permalink() . '#tvs-modal" data-url="/debateModal?debateid=' . get_the_ID() . '#tvs-modal">Details</a></li>';
								//$debate_link = '<li><a class="ajax-popup"  href="/debateModal?debateid=' . get_the_ID() . '">Details</a></li>';
							} else {
								$debate_link = '<li><a  href="' . get_permalink() . '">Details</a></li>';
							}

							?>
							<div class="col-lg-12  col-md-12 custom-sm-margin-bottom-1 p-b-lg single-debate">
								<?php
						
								global $porto_settings;

								$post_layout = 'medium';
								$featured_images = porto_get_featured_images();

								$post_class = array();
								$post_class[] = 'post post-' . $post_layout;
								if (isset($porto_settings['post-title-style']) && 'without-icon' == $porto_settings['post-title-style']) {
									$post_class[] = 'post-title-simple';
								}
								$post_meta = '';
								$post_meta .= '<div class="post-meta ' . (empty($porto_settings['post-metas']) ? ' d-none' : '') . '">';

								$post_meta .= '<ul class="buttons">';
								$post_meta .= $debate_link;
								$post_meta .= tvs_frontpage_metabox(get_the_ID(), $tvsDebate_usedAjax);
								$post_meta .= '<li style="float:right"><span class="d-block float-sm-end mt-3 mt-sm-0"><a class="btn btn-xs btn-default text-xs text-uppercase" href="' . esc_url(apply_filters('the_permalink', get_permalink())) . '">' . esc_html__('Read more...', 'porto') . '</a></span></li>';
								$post_meta .= '</ul>';
								$post_meta .= '</div>';

								?>
								<article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>
									<!-- Post meta before content -->
									<?php
									if (isset($porto_settings['post-meta-position']) && 'before' === $porto_settings['post-meta-position']) {
										echo '<div class="row"><div class="col-12">' . porto_filter_output($post_meta) . '</div></div>';
									}
									?>
									<div class="row">
										<?php if (count($featured_images)): ?>
											<div class="col-lg-5">
												<div class="featured-image" style="margin-bottom: 10px">
													<?php if (has_post_thumbnail()):
														the_post_thumbnail('large', array('class' => 'alignleft-'));
													else:
														$url = wp_get_attachment_url(get_post_thumbnail_id($debateID), 'full'); ?>
														<img src="<?php echo $url ?>" />
													<?php endif ?>
													<br>
													<br>

													<?php 
													$motionPassed = get_post_meta( get_the_ID(), 'tvsDebateMB_motionPassed', true );
													if ($motionPassed != "") :  ?>
													<strong>MOTION PASSED : </strong><?php  echo $motionPassed  ?> <br>
													<?php endif ?>

													<?php 
													$broadcastDate = get_post_meta( get_the_ID(), 'tvsDebateMB_broadcast_date', true );
													if ($broadcastDate != "") :  ?>
													<strong>Broadcast:  </strong> <?php  echo $broadcastDate  ?>  <br>
													<?php endif ?>

													<?php 
													$venue = get_post_meta( get_the_ID(), 'tvsDebateMB_venue', true );
													if ($venue != "") :  ?>
													<strong>Venue:</strong> <?php  echo $venue  ?>   
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
												<?php //the_time('l, j F Y'); 
												 $date = get_post_meta( get_the_ID(), 'tvsDebateMB_date', true );
												 $WpDateFormat= get_option( 'date_format' );
												 $WpDateFormat= date($WpDateFormat, strtotime($date));
												?>

												<div class="datetime"><strong><?php echo  $WpDateFormat ?></strong></div>

										<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>


													<?php
													porto_render_rich_snippets(false);
													if (!empty($porto_settings['blog-excerpt'])) {
														echo porto_get_excerpt($porto_settings['blog-excerpt-length'], false);
														tvs_speakersTheme_metabox(get_the_ID());
														?>
									

											<?php
													} else {

														echo '<div class="entry-content">';
														echo porto_the_content();
														tvs_speakersTheme_metabox(get_the_ID());
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
												</div>
											</div>
										</div>
										<!-- Post meta after content -->
										<?php
										if (isset($porto_settings['post-meta-position']) && 'before' !== $porto_settings['post-meta-position']) {
											echo porto_filter_output($post_meta);
										}
										?>

										<?php tvs_videoTheme_metabox($debate_count, get_the_ID()); ?>
										<?php //include "social-share.php" ?>

								</article>

								<?php if (is_user_logged_in() && current_user_can("edit_post", get_the_ID())) {
            					  edit_post_link("Edit");
            					} ?>
							</div>
						<?php endwhile ?>

					</div>
					<?php porto_pagination(); ?>
					<?php // tvs_wp_pagination($the_query);	 ?>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php else: ?>
				<p><?php esc_html_e('Apologies, but no results were found for the requested archive.', 'porto'); ?></p>
			<?php endif; ?>

		</div>
	</div>


</div>


<?php require_once("footerJs.php"); ?>


<?php
get_footer();