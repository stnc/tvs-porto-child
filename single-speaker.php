<?php get_header(); ?>

<?php
global $porto_settings;
$builder_id = porto_check_builder_condition('single');
if ($builder_id && 'publish' == get_post_status($builder_id)) {
  echo do_shortcode('[porto_block id="' . esc_attr($builder_id) . '" tracking="layout-single-' . esc_attr($builder_id) . '"]');
} else {
  wp_reset_postdata();
  ?>

  <div id="content" role="main" class="porto-single-page">

    <?php
    if (have_posts()):
      the_post();
      $debateID = $post->ID;
      ?>

      <?php porto_render_rich_snippets(); ?>

      <div class="branch-content">
        <div class="row">
          <div class="col-lg-4">
            <div class="featured-image" style="margin-bottom: 10px">
              <?php if (has_post_thumbnail()): ?>
                <?php
                // Adding a few classes to the medium image
                the_post_thumbnail('large', array('class' => 'alignleft-'));
                ?>

                <?php
              else:
                $url = wp_get_attachment_url(get_post_thumbnail_id($debateID), 'full'); ?>
                <img src="<?php echo $url ?>" />
              <?php endif ?>
            </div>

       
          </div>
          <div class="col-lg-8">
            <?php the_content(); ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
  <?php } ?>

  <link rel='stylesheet' href='/wp-content/plugins/tvs-debate/assets/css/min/glightbox.min.css' media='all' />
  <script src="/wp-content/plugins/tvs-debate/assets/js/glightbox.min.js" id="jquery-mag-js"></script>
  <script>
    var lightboxInlineIframe = GLightbox({
      selector: '.debateBox'
    });
  </script>
  <?php get_footer(); ?>