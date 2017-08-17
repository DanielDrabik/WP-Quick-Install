<?php 

add_action( 'load-post.php', 'gloo_front_page_hide' );

function gloo_front_page_hide()
{
    // Change the ID
    if( '8' == $_GET['post'] && 'edit' == $_GET['action'] )
    {
        remove_post_type_support( 'page', 'editor' );
        remove_post_type_support( 'page', 'thumbnail' );
        remove_post_type_support( 'page', 'page-attributes' );
        remove_post_type_support( 'page', 'revisions' );
        remove_post_type_support( 'page', 'author' );
        remove_post_type_support( 'page', 'post-formats' );
    }
}


add_action('cmb2_admin_init', 'gloo_front_page');

function gloo_front_page()
{
    section_1_();
}

function section_1_() {

    $prefix = __FUNCTION__;

    $cmb = new_cmb2_box(array(
        'id' => $prefix . 'metabox',
        'title' => esc_html__('Sekcja 1', 'cmb2'),
        'object_types' => array('page',),
        'show_on' => array('id' => array(8,)),
        'closed' => false, // true to keep the metabox closed by default
    ));

    $cmb->add_field( array(
        'name' => 'URL',
        'id' => 'url',
        'type' => 'textarea_code',
    ));

    $group_field_id = $cmb->add_field(array(
        'id' => $prefix . 'group',
        'type' => 'group',
        // 'repeatable'  => false, // use false if you want non-repeatable group
        'options' => array(
            'group_title' => __('Element {#}', 'cmb2'), // since version 1.1.4, {#} gets replaced by row number
            'add_button' => __('Dodaj Kolejny Element', 'cmb2'),
            'remove_button' => __('Usuń Element', 'cmb2'),
            'sortable' => true, // beta
            'closed' => true, // true to have the groups closed by default
        ),
    ));

    // Id's for group's fields only need to be unique for the group. Prefix is not needed.
    $cmb->add_group_field($group_field_id, array(
        'name' => 'Logo',
        'id' => 'image',
        'type' => 'file',
    ));

    
}
