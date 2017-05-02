<?php
  	// For example proposes of importing files to the new theme's directory

	// Shortening functions to get CMB2's output
	function get_the_field($field_id, $id = null)
	{
		if ( empty( $id ) && isset( $GLOBALS['post'] ) ) {
        	$post = $GLOBALS['post'];
        	return get_post_meta($post->ID, $field_id, true);        	
		}
		if (is_integer($id))
			return get_post_meta($id, $field_id, true); 

		if(is_object($id)) 
			return get_post_meta($id->ID, $field_id, true);  

		return false;
	}

	function the_field($field_id, $id = null)
	{
		echo get_the_field($field_id, $id);
	}

	function the_option($option_key, $option_id) {

		echo cmb2_get_option($option_key, $option_id);
	}

	function get_the_option($option_key, $option_id) {

		return cmb2_get_option($option_key, $option_id);
	}

	// Added more things that I usually need during theme developing
	require_once('wp_bootstrap_navwalker.php');

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'headmenu' ),
	) );

	add_theme_support( 'post-thumbnails');
	add_theme_support( 'title-tag' );

	include 'cmb/settings.php';
