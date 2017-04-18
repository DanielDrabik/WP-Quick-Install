<?php
	
	add_action( 'tf_create_options', 'custom_options' );

	function custom_options() {
		$titan = TitanFramework::getInstance( 'themename' );

		header_($titan);
		footer_($titan);

	}

	function header_($titan) {

		$prefix = __FUNCTION__;

		$panel = $titan->createAdminPanel( array(
		'name' => 'Header',
		'parent' => 'themes.php',
		) );

		$panel->createOption( array(
			'type' => 'save',
			) );
		
	}

	function footer_($titan) {

		$prefix = __FUNCTION__;

		$panel = $titan->createAdminPanel( array(
		'name' => 'Footer',
		'parent' => 'themes.php',
		) );

		$panel->createOption( array(
			'type' => 'save',
			) );
		
	}
