<?php
function tvs_meta_tags($title)
{
    echo '  <title>' . $title . '</title>      <meta name="description" content="' . $title . 'php">';
}
add_action('wp_head', 'tvs_meta_tags');

require_once("functions-tvs-porto-child.php");
$id = get_query_var('list');
?>
<div id="content" class="modalbox-block" role="main">
    <div class="page-debates clearfix">
        <div class="row debate-row archive-debate-row">
            <div class="col-lg-12  col-md-12  custom-sm-margin-bottom-1 p-b-lg single-debate--">
                <?php
                $opinionPage = get_post_meta($id, 'tvsDebateMB_opinion', true);
                $transcriptPage = get_post_meta($id, 'tvsDebateMB_transcript', true);
                ?>
                <article id="post-<?php $id ?>">
                    <!-- Post meta before content -->
                    <div class="post-content">
                        <?php

                        $post = get_post($id);
                        // print_r($post);
                        $title = apply_filters('the_title', $post->post_title);
                        echo '<h2 class="entry-title tvs-modal-title"> <strong> Speakers</strong> </h2>';
                        tvs_meta_tags("Speakers List - " . $title);

                        $speaker_list_db = get_post_meta($id, 'tvsDebateMB_speakerList', true);
                        if ($speaker_list_db != '') {

                            $speaker_list_json = json_decode($speaker_list_db, true);

                            if ($speaker_list_json):

                                foreach ($speaker_list_json as $key => $json_speaker):

                                    if (1 == $json_speaker["opinions"])
                                        $opinions = "FOR";

                                    if (2 == $json_speaker["opinions"])
                                        $opinions = "AGAINST";
                                    $speakerId = $json_speaker["speaker"];

                                    $speakerName = '<strong>' . get_the_title($speakerId) . '</strong>';
                                    $speakerDesc = $json_speaker["introduction"] . ' <span style="color:red"> ' . $opinions . '  </span> </li>';
                                    $speaker_post = get_post($speakerId);
                                    $speaker_content = apply_filters('the_content', $speaker_post->post_content)
                                        ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div
                                                class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                                                <div class="col p-4 d-flex flex-column position-static">

                                                    <h3 class="mb-0"> <a style="color:black"
                                                            href="<?php echo get_permalink($speakerId) ?>"><?php echo $speakerName; ?>
                                                        </a></h3>
                                                    <strong
                                                        class="d-inline-block mb-2 text-primary-emphasis"><?php echo $speakerDesc ?></strong>
                                                    <div class="mb-1 text-body-secondary"></div>
                                                    <p class="card-text mb-auto"><?php echo $speaker_content; ?></p>
                                                    <!--	<a href="#" class="icon-link gap-1 icon-link-hover stretched-link">
                                                  Continue reading
                                                  <svg class="bi"><use xlink:href="#chevron-right"></use></svg>
                                                </a> -->
                                                </div>
                                                <div class="col-auto d-none d-lg-block">
                                                    <?php if (has_post_thumbnail($speakerId)):
                                                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($speakerId), 'medium');
                                                        ?>
                                                        <img width="300" height="300" src="<?php echo $image[0]; ?>">
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                <?php endforeach;
                            endif;
                        } else {
                            echo "Can't Display The Content";
                            // wp_redirect("/", 301);
                            //exit();
                        }
                        ?>
                    </div>
                </article>
            </div>
        </div>


    </div>
    <a class="closeModallBTN" href="#">Close</a>
</div>