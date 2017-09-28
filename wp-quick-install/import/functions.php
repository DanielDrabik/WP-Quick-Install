<?php
/**
 * Default functions.php for Wordpress Theme
 * @author 	Daniel Drabik (d.drabik@gloo.pl)
 * @version 0.6
 *
 * @todo Multilingual option - fields
 * 
 * Changelog: 
 * 0.1	- Added fields/options functions
 * 0.2	- Auto register main menu with wp_bootstrap_navwalker.php @link https://github.com/wp-bootstrap/wp-bootstrap-navwalker
 *		- Added support for post thumbnails
 *		- Added support for html title tag
 * 0.3	- Added update-remove functions
 * 0.4 	- Added custom term fields support
 * 		- Removed Welcome widget from dashboard
 * 		- Added languages support
 * 		- Added bittersweet_pagination @link https://github.com/talentedaamer/Bitter-Sweet/blob/master/functions.php#L172 	\
 * 0.5	- Added optional 'the_content' filter
 * 0.6	- Added is_field, is_option, is_term_field functions in order to check if the value is not empty
 *		- Removed WP Logo from toolbar
 *		- Added Enqueue Styles and Enqueue Script
 *		- Added functions to apply 'the_content' filters
 *		- Added short function to echo tempalte url
 *		- Remove Spans from Contact Form 7
 * 0.7 	- Moved wp_bootstrap_navwalker.php to inc directory
 * 		- Added cmbField class which provides easy field creation.
 */

	/**
	 * Add cmbField
	 */
	include 'inc/cmb_field.php';

	/**
	 * Enqueue Script & Styles
	 */
	function add_theme_scripts() {

	 	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', false, 1);
	 	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css', false, 1);
	 	wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/css/owl.carousel.css', false, 1);
	 	wp_enqueue_style( 'main', get_template_directory_uri() . '/css/main.css', false, 1);
	 
		wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array (), false, true);
		wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js/owl.carousel.js', array (), false, true);		
	}

	add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );

	/**
	 * Include custom fields templates
	 */

	include 'cmb/settings.php';
	include 'cmb/front-page.php';

	/**
	 * Returns post/page custom field value
	 * 
	 * @param string $field_id Unique identificator for custom field
	 * @param null|int|string|object(type post) $id Post identificator
	 * @return array|string|bool Returns saved field based on its ID or false if empty 
	 */
	function get_the_field($field_id, $id = null) {
		if ( empty( $id ) && isset( $GLOBALS['post'] ) ) {
        	$post = $GLOBALS['post'];
        	return get_post_meta($post->ID, $field_id, true);        	
		}

		if (is_integer($id))
			return get_post_meta($id, $field_id, true); 

		if(is_object($id)) 
			return get_post_meta($id->ID, $field_id, true);  

		if(is_string($id))
			return get_post_meta(intval($id), $field_id, true);		

		return false;
	}


	/**
	 * Displays formatted custom field value
	 * 
	 * @param string $field_id Unique identificator for custom field
	 * @param null|int|string|object(type post) $id Post identificator
	 * @param bool $filters Defines if function should add the_content filters
	 */
	function the_field($field_id, $id = null, $filters = false) {

		if($filters)
			echo apply_filters( 'the_content', get_the_field($field_id, $id) );		
		else
			echo get_the_field($field_id, $id);
	}


	/**
	 * Returns custom field from the options page
	 * 
	 * @param string $option_key Some kind of custom field prefix 
	 * @param string $option_id Unique identificator for custom field
	 * @return array|string Returns saved field based on its ID
	 */
	function get_the_option($option_key, $option_id) {

		if( get_locale() == "pl_PL" )
			return cmb2_get_option($option_key, $option_id);
		else
			return cmb2_get_option($option_key.'eng_', $option_id);
	}


	/**
	 * Displays formatted field from the options page
	 * 
	 * @param string $option_key Some kind of custom field prefix 
	 * @param string $option_id Unique identificator for custom field
	 * @param bool $filters Defines if function should add the_content filters
	 */
	function the_option($option_key, $option_id, $filters = false) {

		if($filters)
			echo apply_filters( 'the_content', get_the_option($option_key, $option_id) );
		else
			echo get_the_option($option_key, $option_id);
	}


	/**
	 * Returns term custom fields
	 * 
	 * @param int $term_id Identificator of term|category
	 * @param string $key Unique identificator for custom field
	 * @return array|string Returns saved field based on its ID
	 */
	function get_the_term($term_id, $key = '', $single = false) {

		$term_item = get_term_meta($term_id, $key, $single); 
		return $term_item[0];
	}


	/**
	 * Displays formatted term custom fields
	 * 
	 * @param int $term_id Identificator of term|category
	 * @param string $key Unique identificator for custom field
	 * @param bool $filters Defines if function should add the_content filters
	 */
	function the_term($term_id, $key = '', $single = false, $filters = false) {

		$term_item = get_term_meta($term_id, $key, $single); 

		if($filters)
			echo apply_filters( 'the_content', $term_item[0] );
		else
			echo $term_item[0];
	}


	function is_field($field_id, $post_id = null) {
		return !empty(get_the_field($field_id, $post_id));
	}

	function is_option($option_key, $option_id) {
		return !empty(get_the_option($option_key, $option_id));
	}

	function is_term_field($term_id, $key = '', $single = false) {
		$term_item = get_term_meta($term_id, $key, $single); 
		return !empty($term_item[0]);
	}

	function get_content_field($string) {
		return apply_filters( 'the_content', $string );
	}

	function content_field($string) {
		echo get_content_field($string);
	}

	/**
	 * Initialize menu
	 */
	require_once('inc/wp_bootstrap_navwalker.php');

	register_nav_menus( array(
		'primary' => 'Menu Główne',
	) );

	/**
	 * Add support for html title tag and post thumbnails
	 */
	add_theme_support( 'post-thumbnails');
	add_theme_support( 'title-tag' );

	/**
	 * Add support for languages
	 */
	//load_theme_textdomain( 'default', get_template_directory() . '/languages' );

	/**
	 * Remove Welcome widget
	 */
	remove_action('welcome_panel', 'wp_welcome_panel');

	/**
	 * Remove the Wordpress Logo from the Toolbar
	 */
	add_action( 'admin_bar_menu', 'remove_wp_logo', 999 );

	function remove_wp_logo( $wp_admin_bar ) {
		$wp_admin_bar->remove_node( 'wp-logo' );
	}

	/**
	 *	Echo template url
	 */
	function template_url() {
		echo get_template_directory_uri();
	}	

	/**
	 * Easy pagination implementation
	 */
	function bittersweet_pagination() {

		global $wp_query;

		$big = 999999999; // need an unlikely integer
		
		$pages = paginate_links( array(
		        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		        'format' => '?paged=%#%',
		        'current' => max( 1, get_query_var('paged') ),
		        'total' => $wp_query->max_num_pages,
		        'prev_text' => '<i class="fa fa-angle-left" aria-hidden="true"></i>',
    			'next_text' => '<i class="fa fa-angle-right" aria-hidden="true"></i>',
		        'type'  => 'array',
		    ) );
		    if( is_array( $pages ) ) {
		        $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
		        echo '<ul class="pagination">';
		        $iteration = 0;
		        foreach ( $pages as $page ) { 
	        		if(get_query_var('paged') == $iteration)		        		
	                	echo "<li class='active'>$page</li>";
	                else
	                	echo "<li>$page</li>";
	                $iteration++;
		        }
		       echo '</ul>';
	        }
	}

	function facebook_share_url($link) {
		if (strpos($link, 'https') !== false)
		    $link = substr($link, 8);
		else
			$link = substr($link, 7);

		return "https://www.facebook.com/sharer/sharer.php?u=" . $link; 
	}

	function twitter_share_url($link) {
		if (strpos($link, 'https') !== false)
		    $link = substr($link, 8);
		else
			$link = substr($link, 7);

		return "https://twitter.com/home?status=" . $link; 
	}

	/**
	 *	Remove spans from Contact Form 7
	 */
	add_filter('wpcf7_form_elements', function($content) {
	    $content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);

	    return $content;
	});

	add_image_size( '300', '300', '300' );
