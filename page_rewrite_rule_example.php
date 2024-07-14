<?php
/**
 * Template Name: Taxonomy Date Archive.
 *
 */

echo 'Hello World';

echo '<pre/>';
print_r(get_query_var( 'job-name' ));
print_r(get_query_var( 'archive_taxonomy' ));
echo '<br>';
print_r(get_query_var( 'archive_term' ));
echo '<br>';
print_r(get_query_var( 'archive_year' ));
echo '<br>';
print_r(get_query_var( 'archive_month' ));


