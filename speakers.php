<?php


echo 'spekaers ';

echo '<pre/>';
print_r(get_query_var('list'));
print_r(get_query_var('archive_taxonomy'));
echo '<br>';
print_r(get_query_var('archive_term'));
echo '<br>';
print_r(get_query_var('archive_year'));
echo '<br>';
print_r(get_query_var('archive_month'));


// $id=47; 
// $post = get_post($id); 
// $content = apply_filters('the_content', $post->post_content); 
// echo $content;  

/*
example 1 
echo get_post_meta( get_the_ID(), 'my-info', true );
// You can also call it from the global, as the query refers to the current single page
echo get_post_meta( $GLOBALS['post']->ID, 'my-info', true );

*/


/*
example 2 
  @global / $post
 
 global $post;
$meta = get_post_meta($post->ID,'myinfo-box1', true); 
if ($meta != '') {
    echo $meta;
} else { 
    echo "Can't Display The Content";
} 
 */


$id = get_query_var('list');


$speaker_list_db = get_post_meta($id, 'tvsDebateMB_speakerList', true);

if ($speaker_list_db != '') {
    echo $speaker_list_db;

//[{"speaker":"4136","introduction":" Cultural commentator and broadcaster ","opinions":"1"},{"speaker":"4138","introduction":" Writer, columnist and broadcaster ","opinions":"2"}]

$post = get_post($id); 
$content = apply_filters('the_content', $post->post_content); 

echo $title= the_title();

echo $content;  


$json_speaker_list = json_decode($speaker_list_db, true);
// echo "<pre>";
// print_r($json_speaker_list);
if ($json_speaker_list):
    echo '<ul style="border:1px solid black">';
    foreach ($json_speaker_list as $key => $json_speaker) {

        if (1 == $json_speaker["opinions"])
            $opinions = "FOR";

        if (2 == $json_speaker["opinions"])
            $opinions = "AGAINST";
$speakerId=$json_speaker["speaker"]; //https://stackoverflow.com/questions/11261883/how-to-get-the-wordpress-post-thumbnail-featured-image-url
        echo '<li><strong>' . get_the_title($speakerId) . '</strong> ' . $json_speaker["introduction"] . ' <span style="color:red"> ' . $opinions . '  </span> </li>';
        $speaker_post = get_post($speakerId); 
        $speaker_content = apply_filters('the_content', $speaker_post->post_content); 
        echo  $speaker_content;
//         $url = wp_get_attachment_url( get_post_thumbnail_id($speakerId), 'thumbnail' ); 
// echo '<img src="'. $url.'" />';





    if (has_post_thumbnail( $speakerId ) ):
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $speakerId ), 'thumbnail' );
?>
        <img width="300" height="300" src="<?php echo $image[0]; ?>">  
<?php endif;  ?>
<hr>
<?php   }
    echo '</ul>';
endif;



} else {
    //    echo "Can't Display The Content";
    wp_redirect("/", 301);
    exit();
}
