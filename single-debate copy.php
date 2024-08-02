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
          <?php  if (has_post_thumbnail()) :  ?>
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
              <?php   endif   ?>
          </div>
  

            <div class="accordion" id="accordionSpeaker">
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    Speakers
                  </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                  data-bs-parent="#accordionSpeaker">
                  <div class="accordion-body">

                    <?php
                    $speaker_list_db = get_post_meta($debateID, 'tvsDebateMB_speakerList', true);

                    $speaker_list_json = json_decode($speaker_list_db, true);
                    // echo "<pre>";
// print_r($speaker_list_json);
                    if ($speaker_list_json):
                      echo '<ul style="  list-style-type: none; padding:2px ">';
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
                <h2 class="accordion-header" id="headingTwo">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#accordionVideos" aria-expanded="false" aria-controls="accordionVideos">
                    Videos
                  </button>
                </h2>
                <div id="accordionVideos" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                  data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    

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