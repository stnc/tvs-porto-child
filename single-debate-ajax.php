<?php
$the_query = new WP_Query(
    array(
        'posts_per_page' => 4,
        'post_type' => 'debate',
        'post_status' => 'publish',
        'p' => get_query_var('debateid'),

        'paged' => get_query_var('paged') ? get_query_var('paged') : 1
    )
);
?>



<div id="content" role="main" class="modalbox-block">

    <?php
    if ($the_query->have_posts()):
        $the_query->the_post();
        ?>
        <div class="branch-content">
            <h2 class="tvs-modal-title"><strong><?php the_title(); ?></strong> </h2>
            <?php the_content(); ?>
        <?php endif; ?>
    </div>

    <a class="closeModallBTN" href="#">Close</a>


    <?php the_content(); ?>


    <script id="poll-maker-ays-ajax-public-js-extra">
        <?php
        $poll_maker_ajax_public = array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'alreadyVoted' => __("You have already voted", "poll-maker"),
            'day' => __('day', "poll-maker"),
            'days' => __('days', "poll-maker"),
            'hour' => __('hour', "poll-maker"),
            'hours' => __('hours', "poll-maker"),
            'minute' => __('minute', "poll-maker"),
            'minutes' => __('minutes', "poll-maker"),
            'second' => __('second', "poll-maker"),
            'seconds' => __('seconds', "poll-maker"),
            'thank_message' => __('Your answer has been successfully sent to the admin. Please wait for the approval.', "poll-maker"),
        );
       echo "var poll_maker_ajax_public = ".json_encode( $poll_maker_ajax_public,true);
    //    wp_localize_script(POLL_MAKER_AYS_NAME . '-ajax-public', 'poll_maker_ajax_public', array('ajax_url' => admin_url('admin-ajax.php')));
    ?>
    </script>
    <script src="<?php echo get_home_url(); ?>/wp-content/plugins/poll-maker/public/js/google-chart.js?ver=5.4.2" id="poll-maker-ays-charts-google-js"></script>
    <script src="<?php echo get_home_url(); ?>/wp-content/plugins/poll-maker/public/js/poll-maker-public-ajax.js?ver=5.4.2"  id="poll-maker-ays-ajax-public-js"></script>
    <script src="<?php echo get_home_url(); ?>/wp-content/plugins/poll-maker/public/js/poll-maker-ays-public.js?ver=5.4.2"  id="poll-maker-ays-js"></script>
    <script src="<?php echo get_home_url(); ?>/wp-content/plugins/poll-maker/public/js/poll-maker-public-category.js?ver=5.4.2" id="poll-maker-ays-category-js"></script>
    <script src="<?php echo get_home_url(); ?>/wp-content/plugins/poll-maker/public/js/poll-maker-autosize.js?ver=5.4.2" id="poll-maker-ays-autosize-js"></script>
</div>