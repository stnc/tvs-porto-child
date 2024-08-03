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
          <div class="col-lg-5">
            <div class="featured-image" style="margin-bottom: 10px">
              <?php if (has_post_thumbnail()): ?>
                <?php //the_post_thumbnail();            // just the image        ?>
                <?php //the_post_thumbnail('thumbnail'); // just the thumbnail    ?>
                <?php //the_post_thumbnail('medium');    // just the Medium Image ?>
                <?php //the_post_thumbnail('large');     // just the Medium Image ?>
                <?php
                //      https://stackoverflow.com/questions/9305040/how-can-i-check-for-a-thumbnail-in-wordpress
          
                // adding a 200x200 height and width along with a class to it.
                //  the_post_thumbnail(array( 200,200 ), array( 'class' => 'alignleft' )); 
                ?>
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

            <div class="accordion accordion-flush------" id="accordionSingleDebate">
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#flush-collapseSpeaker" aria-expanded="false" aria-controls="flush-collapseSpeaker">
                    Speakers
                  </button>
                </h2>
                <div id="flush-collapseSpeaker" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                  data-bs-parent="#accordionSingleDebate">
                  <div class="accordion-body">
                    <?php
                    $speaker_list_db = get_post_meta($debateID, 'tvsDebateMB_speakerList', true);

                    $speaker_list_json = json_decode($speaker_list_db, true);
                    if ($speaker_list_json):
                      echo '<ul style="list-style-type: none; padding:2px ">';
                      foreach ($speaker_list_json as $key => $json_speaker) {

                        if (1 == $json_speaker["opinions"])
                          $opinions = "FOR";

                        if (2 == $json_speaker["opinions"])
                          $opinions = "AGAINST";

                        echo '<li><strong>' . get_the_title($json_speaker["speaker"]) . '</strong> ' . $json_speaker["introduction"] . ' <span style="color:red"> ' . $opinions . '  </span> </li>';

                      }
                      echo '</ul>';
                    endif;
                    ?>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingTwo">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#flush-collapseVideo" aria-expanded="false" aria-controls="flush-collapseVideo">
                    Videos
                  </button>
                </h2>
                <div id="flush-collapseVideo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
                  data-bs-parent="#accordionSingleDebate">
                  <div class="accordion-body">
                    <?php
                    $video_list_db = get_post_meta($debateID, 'tvsDebateMB_videoList', true);

                    $json_video_list = json_decode($video_list_db, true);

                    if ($json_video_list):
                      ?>
                      <div class="row row-cols-2 row-cols-sm-4 row-cols-md-3 g-3">
                        <?php
                        foreach ($json_video_list as $key => $video):
                          $src = wp_get_attachment_image_src($video["youtubePicture"], 'thumbnail', false, '');
                          ?>
                          <div class="col">
                            <div class="card shadow-sm">
                              <a href="#inline-video<?php echo $key ?>" class="debateBox"
                                data-glightbox="width: 700; height: auto;">
                                <?php if (!empty($src)): ?>
                                  <img src="<?php echo $src[0] ?>"
                                    style="max-width:none!important; height: 120px !important; width: 120px !important; padding:2px" alt="featured-image<?php echo $key ?>"/>
                                <?php endif ?> </a>

                              <div id="inline-video<?php echo $key ?>" style="display: none">
                                <div class="inline-inner">
                                  <h4 class="text-center"><?php echo get_the_title($debateID) ?></h4>
                                  <div class="text-center">

                                    <iframe width="600" height="400"
                                      src="https://www.youtube.com/embed/<?php echo $video["youtube_link"] ?>?autoplay=0&mute=1"
                                      title="YouTube video player" frameborder="0"
                                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                      referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                    <p>
                                      <?php echo $video["description"] ?>
                                    </p>
                                  </div>
                                  <a class="gtrigger-close inline-close-btn" href="#">Close</a>
                                </div>
                              </div>
                            </div>

                          </div>
                        <?php endforeach;
                        ?>
                      </div>
                    <?php endif; ?>

                  </div>
                </div>
              </div>

            </div>


          </div>
          <div class="col-lg-7">
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