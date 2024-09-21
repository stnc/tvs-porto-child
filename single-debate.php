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
              else:
                $url = wp_get_attachment_url(get_post_thumbnail_id($debateID), 'full'); ?>
                <img src="<?php echo $url ?>" />
              <?php endif ?>
            </div>

            <ul class="list-group" style="margin-bottom:10px">
              <li class="list-group-item text-center"> <strong>Related Categories</strong> </li>
              <?php
              $terms = wp_get_post_terms(get_the_id(), 'topics', array('orderby' => 'term_order'));
              //nested group 
              //      $terms = json_decode(json_encode($terms), true);
              //      $group = array();
              // foreach ( $terms as $value ) {
              //     $group[$value['parent']][] = $value;
              // }
              //  print_r($terms);     
              // print_r($group);     
              foreach ($terms as $value):
                if ($value->parent == 0):
                  ?>
                  <li class="list-group-item"> <a
                      href="<?php get_permalink($value->term_id); ?>"><?php echo $value->name; ?></a>
                  </li>
                <?php endif ?>
              <?php endforeach ?>


            </ul>

            <div class="accordion accordion-flush------" id="accordionSingleDebate">
              <?php
              $speaker_list_db = get_post_meta(get_the_ID(), 'tvsDebateMB_speakerList', true);
              $speaker_list_json = json_decode($speaker_list_db, true);
              if ($speaker_list_json):
                if ($speaker_list_json[0]["speaker"] != "0" || $speaker_list_json[0]["speaker"] != 0): ?>
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
                        echo '<ul style="list-style-type: none; padding:2px ">';
                        foreach ($speaker_list_json as $key => $json_speaker) {
                          $spekerLink = get_the_permalink($json_speaker["speaker"]);
                          $spekerLink = '<a style="color:#777777;text-decoration: underline;" href="' . $spekerLink . '">' . get_the_title($json_speaker["speaker"]) . '</a>';
                          if (1 == $json_speaker["opinions"])
                            $opinions = "FOR";

                          if (2 == $json_speaker["opinions"])
                            $opinions = "AGAINST";

                          echo '<hr style="margin:5px"><li><strong>' . $spekerLink . '</strong> ' . $json_speaker["introduction"] . ' <span style="color:red"> ' . $opinions . '  </span> </li>';
                        }
                        echo '</ul>';

                        ?>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
              <?php endif; ?>




              <?php
              $video_list_db = get_post_meta(get_the_ID(), 'tvsDebateMB_videoList', true);
              $json_video_list = json_decode($video_list_db, true);
              if (!$json_video_list || $json_video_list[0]["title"] != "Later (Not Clear Yet)"):
                ?>
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
                      <div class="row row-cols-2 row-cols-sm-4 row-cols-md-3 g-3">
                        <?php
                        foreach ($json_video_list as $key => $video):
                          $src = wp_get_attachment_image_src($video["youtubePicture"], 'thumbnail', false, '');
                          ?>
                          <div class="col">
                            <div class="card- shadow-sm-">
                              <a href="#inline-video<?php echo $key ?>" class="debateBox"
                                data-glightbox="width: 700; height: auto;">
                                <?php if (!empty($src)): ?>
                                  <img src="<?php echo $src[0] ?>"
                                    style="max-width:none!important; height: 120px !important; width: 120px !important; padding:2px"
                                    alt="<?php echo $video["title"] ?>" />
                                <?php endif ?>
                                <span class="w-100  float-left"> <?php echo $video["title"] ?> </span>
                              </a>

                              <div id="inline-video<?php echo $key ?>" style="display: none">
                                <div class="inline-inner">
                                  <h4 class="text-center"> <?php echo $video["title"] ?> </h4>
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


                    </div>
                  </div>
                </div>
              <?php endif; ?>
            </div>

          </div>
          <div class="col-lg-7">
            <?php the_content(); ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
  <?php } ?>
  </div>
  
  <script src="<?php echo get_stylesheet_directory_uri() ?>/assets/js/glightbox.min.js"
    id="jquery-glightbox-js"></script>

  <script>
    var lightboxInlineIframe = GLightbox({
      selector: '.debateBox'
    });
  </script>
  <?php get_footer(); ?>