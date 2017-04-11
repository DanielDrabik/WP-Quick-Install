<?php

  // For example proposes of importing files to the new theme's directory

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
