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



            <?php $url = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'full'); ?>
            <img src="<?php echo $url ?>" />



            <div class="accordion" id="accordionExample">
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    Speakers
                  </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                  data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <?php
                    $speaker_list_db = get_post_meta($debateID, 'tvsDebateMB_speakerList', true);

                    $json_speaker_list = json_decode($speaker_list_db, true);
                    // echo "<pre>";
// print_r($json_speaker_list);
                    if ($json_speaker_list):
                      echo '<ul>';
                      foreach ($json_speaker_list as $key => $json_speaker) {

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
                <h2 class="accordion-header" id="headingTwo">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Videos
                  </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                  data-bs-parent="#accordionExample">
                  <div class="accordion-body">



                    <?php
                    $video_list_db = get_post_meta($debateID, 'tvsDebateMB_videoList', true);

                    $json_video_list = json_decode($video_list_db, true);
                    // echo "<pre>";
// print_r($json_speaker_list);
                    if ($json_video_list):
                      echo '<ul>';
                      foreach ($json_video_list as $key => $video) {
                        echo '<li> <a target="_blank" href="' . $video["youtube"] . '"> <img src="' . $video["youtubePicture"] . '" alt="" width="500" height="600">    Click</a> </li>';
                      }
                      echo '</ul>';
                    endif;
                    ?>


                  </div>
                </div>
              </div>



            </div>








          </div>
          <div class="col-lg-7">



            <?php the_content(); ?>
            <div class="tabs">
              <ul class="nav nav-tabs nav-justified flex-column flex-md-row" role="tablist">
                <li class="nav-item " role="presentation">
                  <a class="nav-link " href="#camp-ua" data-bs-toggle="tab" aria-selected="false" role="tab">Speakers</a>
                </li>

                <li class="nav-item active" role="presentation">
                  <a class="nav-link active" href="#contact-ua" data-bs-toggle="tab" aria-selected="true" role="tab"
                    tabindex="-1">Videos</a>
                </li>
              </ul>

              <div class="tab-content">
                <div id="camp-ua" class="tab-pane " role="tabpanel">
                  <?php
                  $speaker_list_db = get_post_meta($debateID, 'tvsDebateMB_speakerList', true);

                  $json_speaker_list = json_decode($speaker_list_db, true);
                  // echo "<pre>";
// print_r($json_speaker_list);
                  if ($json_speaker_list):
                    echo '<ul>';
                    foreach ($json_speaker_list as $key => $json_speaker) {

                      if (1 == $json_speaker["opinions"])
                        $opinions = "FOR";

                      if (2 == $json_speaker["opinions"])
                        $opinions = "AGAINST";

                      echo '<li><strong>' . get_the_title($json_speaker["speaker"]) . '</strong> ' . $json_speaker["introduction"] . ' <span style="color:red"> ' . $opinions . '  </span> <li>';

                    }
                    echo '</ul>';
                  endif;
                  ?>
                </div>

                <div id="contact-ua" class="tab-pane active show" role="tabpanel">
                  <?php
                  $video_list_db = get_post_meta($debateID, 'tvsDebateMB_videoList', true);

                  $json_video_list = json_decode($video_list_db, true);
                  // echo "<pre>";
// print_r($json_speaker_list);
                  if ($json_video_list):
                    echo '<ul>';
                    foreach ($json_video_list as $key => $video) {

                      echo '<li> <a target="_blank" href="' . $video["youtube"] . '"> <img src="' . $video["youtubePicture"] . '" alt="" width="500" height="600">    Click</a> <li>';

                    }
                    echo '</ul>';
                  endif;
                  ?>
                </div>

              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  <?php } ?>
  <?php get_footer(); ?>