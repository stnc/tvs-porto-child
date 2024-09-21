<?php
$the_query = new WP_Query(
    array(
        'posts_per_page' => 4,
        'post_type' => 'transcript',
        'post_status' => 'publish',
        'p' => get_query_var('transcriptid'),

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
        <h2 class="tvs-modal-title"><strong><?php the_title(); ?></strong>   </h2> 

                    <?php the_content(); ?>
        <?php endif; ?>
    </div>
    <a class="closeModallBTN" href="#">Close</a>
</div>
