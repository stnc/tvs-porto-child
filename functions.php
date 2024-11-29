<?php

add_action( 'wp_enqueue_scripts', 'porto_child_css', 1001 );

if(site_url()=="http://debates.test"){
    define("TVSVERSION","time()");
}
else{
    // define("VERSION",wp_get_theme()->get("Version"));
    define("TVSVERSION","3.896");
}

// Load CSS
function porto_child_css() {
	// porto child theme styles
	wp_deregister_style( 'styles-child' );
	wp_register_style( 'styles-child', esc_url( get_stylesheet_directory_uri() ) . '/style.css' , array(), TVSVERSION );
	wp_enqueue_style( 'styles-child' );

	if ( is_rtl() ) {
		wp_deregister_style( 'styles-child-rtl' );
		wp_register_style( 'styles-child-rtl', esc_url( get_stylesheet_directory_uri() ) . '/style_rtl.css'  , array(), TVSVERSION );
		wp_enqueue_style( 'styles-child-rtl' );
	}
}


