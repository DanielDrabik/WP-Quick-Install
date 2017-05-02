    <?php

// add action to hook option page creation to
add_action( 'cmb2_admin_init', 'gloo_settings' );

/**
 * Callback for 'cmb2_admin_init'.
 *
 * In this example, 'boxes' and 'tabs' call functions simply to separate "normal" CMB2 configuration
 * from unique CMO configuration.
 */
function gloo_settings() {
    
    header_();    
    footer_();
}

function header_() {

    $options_key = __FUNCTION__;
        
    // configuration array
    $args = array(
        'key'      => $options_key,
        'title'    => 'Header',
        'topmenu'  => 'themes.php',
        'cols'     => 1,
        'boxes'    => header_boxes( $options_key ),
        //'tabs'     => cmb2_metatabs_options_add_tabs(),
        'menuargs' => array(
            'menu_title' => 'Header',
        ),
    );
    
    // create the options page
    new Cmb2_Metatabs_Options( $args );
}

function header_boxes( $options_key ) {
    
    // holds all CMB2 box objects
    $boxes = array();
    
    // we will be adding this to all boxes
    $show_on = array(
        'key'   => 'options-page',
        'value' => array( $options_key ),
    );

    $prefix = $options_key;

    // Header Image
    $cmb = new_cmb2_box( array(
        'id'      => $prefix . 'box',
        'title'   => __( 'Header', 'cmb2' ),
        'show_on' => $show_on, // critical, see wiki for why
        'closed'  => false
    ) );   

    // Custom fields here

    $cmb->object_type( 'options-page' );  // critical, see wiki for why
    $boxes[] = $cmb;
        
    return $boxes;
}


function footer_() {

    $options_key = __FUNCTION__;
        
    // configuration array
    $args = array(
        'key'      => $options_key,
        'title'    => 'Footer',
        'topmenu'  => 'themes.php',
        'cols'     => 1,
        'boxes'    => footer_boxes( $options_key ),
        //'tabs'     => cmb2_metatabs_options_add_tabs(),
        'menuargs' => array(
            'menu_title' => 'Footer',
        ),
    );
    
    // create the options page
    new Cmb2_Metatabs_Options( $args );
}

function footer_boxes( $options_key ) {
    
    // holds all CMB2 box objects
    $boxes = array();
    
    // we will be adding this to all boxes
    $show_on = array(
        'key'   => 'options-page',
        'value' => array( $options_key ),
    );

    $prefix = $options_key;

    $cmb = new_cmb2_box( array(
        'id'      => $prefix . 'box',
        'title'   => __( 'Footer', 'cmb2' ),
        'show_on' => $show_on, // critical, see wiki for why
        'closed'  => false
    ) );

    // Custom fields here

    $cmb->object_type( 'options-page' );  // critical, see wiki for why
    $boxes[] = $cmb;
        
    return $boxes;
}
