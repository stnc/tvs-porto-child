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
       $opinionID = $post->ID;
      ?>

      <?php porto_render_rich_snippets(); ?>

      <div class="single-debate-content">
        <div class="row">
          <div   class="col-lg-5 sidebar porto-alternative-default left-sidebar <?php echo !$mobile_sidebar ? '' : ' mobile-sidebar'; ?>">

            <?php
 
            $tvsDebateMB_relatedDebateID = get_post_meta($opinionID, 'tvsDebateMB_relatedDebateID', true );
          //   print_r($tvsDebateMB_relatedDebateID);
        //  var_dump($tvsDebateMB_relatedDebateID);
            ?>

            <div class="pin-wrapper">
              <div <?php echo $sticky ?>
                data-plugin-options="<?php echo esc_attr('{"autoInit": true, "minWidth": 992, "containerSelector": ".main-content-wrap","autoFit":true, "paddingOffsetBottom": 10}'); ?>">
                <?php if ($mobile_sidebar && (!isset($porto_mobile_toggle) || false !== $porto_mobile_toggle)): ?>
                  <div class="sidebar-toggle"><i class="fa"></i></div>
                <?php endif; ?>
                <div class="sidebar-content">


                  <?php if ($tvsDebateMB_relatedDebateID != "0" ): ?>
                    <div id="main-sidebar-menu" class="widget_sidebar_menu main-sidebar-menu">
                      <?php
                      $ssidebarMenu = get_post_meta($tvsDebateMB_relatedDebateID, 'tvsDebateMB_sidebar', true);
                      if ($ssidebarMenu) {
                        wp_nav_menu(array("menu" => $ssidebarMenu, 'theme_location' => 'header-top-menu'));
                      }
                      //dynamic_sidebar('tvs-main-sidebar'); ?>
                    </div>
                  <?php endif; ?>

                  <?php if ($tvsDebateMB_relatedDebateID != "0"): ?>
                    <?php
                    $tvsDebateCommonSettings = get_option('tvsDebate_CommonSettings');
                    $tvsDebate_usedAjax = $tvsDebateCommonSettings["tvsDebate_usedAjax"];
                    ?>
                    <div class="post-meta ">
                      <ul class="buttons">
                          <li><a  href=" <?php echo get_permalink($tvsDebateMB_relatedDebateID)  ?>">Debate Page</a></li>
                        <?php echo tvs_frontpage_metabox($tvsDebateMB_relatedDebateID, $tvsDebate_usedAjax); ?>
                      </ul>
                    </div>
                  <?php endif; ?>


                  <!-- featured-image starts-->
                  <div class="featured-image" style="margin-bottom: 10px">
                    <?php if (has_post_thumbnail()): ?>
                      <?php
                      the_post_thumbnail('large', array('class' => 'alignleft-'));
                      ?>
                    <?php else: ?>
                      <?php $url = wp_get_attachment_url(get_post_thumbnail_id($opinionID), 'full'); ?>
                      <img src="<?php echo $url ?>" />
                    <?php endif ?>
                  </div>
                  <!-- featured-image ends-->



                  <?php if ($tvsDebateMB_relatedDebateID != "0"): ?>
                    <?php
                    $tvsDebateCommonSettings = get_option('tvsDebate_CommonSettings');
                    $tvsDebateShowVideoSpeaker = $tvsDebateCommonSettings["ShowVideoSpeakerForTranscript"];
                    if ($tvsDebateShowVideoSpeaker == "yes"):
                      ?>
                      <!-- accordion starts-->
                      <div class="accordion accordion-flush------" id="accordionSingleDebate">
                        <?php
                        $speaker_list_db = get_post_meta($tvsDebateMB_relatedDebateID, 'tvsDebateMB_speakerList', true);
                        $speaker_list_json = json_decode($speaker_list_db, true);
                        if ($speaker_list_json):
                          if ($speaker_list_json[0]["speaker"] != "0" || $speaker_list_json[0]["speaker"] != 0): ?>
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                  data-bs-target="#flush-collapseSpeaker" aria-expanded="false"
                                  aria-controls="flush-collapseSpeaker">
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

                        <?php if ($tvsDebateMB_relatedDebateID != "0"): ?>
                          <?php
                          $video_list_db = get_post_meta($tvsDebateMB_relatedDebateID, 'tvsDebateMB_videoList', true);
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
                        <!-- accordion ends-->
                      <?php endif; ?>

                    <?php endif; ?>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-7">
            
            <?php
            $date = get_post_meta($tvsDebateMB_relatedDebateID, 'tvsDebateMB_date', true);
            $WpDateFormat = get_option('date_format');
            $WpDateFormat = date($WpDateFormat, strtotime($date));
            ?>
            <div class="datetime"><strong><?php echo $WpDateFormat ?></strong></div>


            <?php
            $motionPassed = get_post_meta($tvsDebateMB_relatedDebateID, 'tvsDebateMB_motionPassed', true);
            if ($motionPassed != ""): ?>
              <strong>MOTION PASSED : </strong><?php echo $motionPassed ?> <br>
            <?php endif ?>
            
            <?php the_content(); ?>
            <?php if (is_user_logged_in() && current_user_can("edit_post", get_the_ID())) {
              edit_post_link("Edit");
            } ?>

            <?php include "social-share.php" ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
  <?php } ?>
</div>

<?php require_once("footerJs.php"); ?>
<?php get_footer(); ?>