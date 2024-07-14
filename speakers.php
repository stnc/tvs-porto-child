<?php get_header();
require_once ("functions-tvs.php");

?>
<div class="row">
	<div class="col-lg-3">
		<?php dynamic_sidebar('tvs-special-debates'); ?>
	</div>


	<div class="col-lg-9">

		<div id="content" role="main">



			<div class="page-debates clearfix">
				<div class="row debate-row archive-debate-row">

					<div
						class="col-lg-12  col-md-12 offset-lg-0 offset-md-2 custom-sm-margin-bottom-1 p-b-lg single-debate">

						<?php
						$opinionPage = get_post_meta(get_the_ID(), 'tvsDebateMB_opinion', true);
						$transcriptPage = get_post_meta(get_the_ID(), 'tvsDebateMB_transcript', true);
						?>
						<article id="post-<?php the_ID(); ?>">
							<!-- Post meta before content -->

							<div class="row">
								<div class="col-lg-7">
									<div class="post-content">
										<h2 class="entry-title"><a
												href="<?php //the_permalink(); ?>"><?php //the_title(); ?></a></h2>
										tyututyu
									</div>
								</div>
							</div>
							<!-- Post meta after content -->
							<?php
							if (isset($porto_settings['post-meta-position']) && 'before' !== $porto_settings['post-meta-position']) {
								echo porto_filter_output($post_meta);
							}
							?>
						</article>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
get_footer();