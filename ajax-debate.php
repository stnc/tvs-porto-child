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

<div id="content" role="main" class="white-popup-block">
    <?php
    if ($the_query->have_posts()):
        $the_query->the_post();
        ?>
        <div class="branch-content">    
                 <strong><?php the_title(); ?></strong>   
                    <?php the_content(); ?>
        <?php endif; ?>
    </div>
</div>




<?php

// echo 'Hello World';

// echo '<pre/>';
// print_r(get_query_var('job-name'));
// print_r(get_query_var('debateid'));
// print_r(get_query_var('archive_taxonomy'));
// echo '<br>';
// print_r(get_query_var('archive_term'));
// echo '<br>';
// print_r(get_query_var('archive_year'));
// echo '<br>';
// print_r(get_query_var('archive_month'));


