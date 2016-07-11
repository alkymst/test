<?php

add_action('wp_footer','onefee_tracking',99);
function onefee_tracking() {

  // tracking code
  get_template_part('templates/facebook', 'retargeting');
  get_template_part('templates/google', 'analytics');
  get_template_part('templates/adroll', 'code');

}



if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Contact Settings',
		'menu_title'	=> 'Contact Settings',
		'menu_slug' 	=> 'contact-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}


add_action('wp_footer','onefee_contact_modal');
function onefee_contact_modal() {
  echo get_template_part('templates/contact', 'modal');
}


function onefee_scripts() {
  // wp_enqueue_script('googlemaps');
  wp_dequeue_script('googlemaps');
  wp_register_script( 'modal-scripts', get_stylesheet_directory_uri() . '/assets/js/modal.js', 'jquery' );
  wp_enqueue_script('modal-scripts');
}
add_action( 'wp_enqueue_scripts', 'onefee_scripts', 11);
