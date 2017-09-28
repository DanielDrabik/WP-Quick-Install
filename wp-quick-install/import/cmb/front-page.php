<?php 

add_action( 'load-post.php', 'gloo_front_page_hide' );

function gloo_front_page_hide() {
    
    if( get_option('page_on_front') == $_GET['post'] && 'edit' == $_GET['action'] ) {
        remove_post_type_support( 'page', 'editor' );
        remove_post_type_support( 'page', 'page-attributes' );
        remove_post_type_support( 'page', 'revisions' );
        remove_post_type_support( 'page', 'author' );
        remove_post_type_support( 'page', 'post-formats' );
    }
}

add_action('cmb2_admin_init', 'gloo_front_page');

function gloo_front_page() {

    front_page_();
}

function front_page_() {

    $prefix = __FUNCTION__;
    $type = array('page');
    $show_on = array('id' => array(get_option('page_on_front'),));

    $cmb_helper = new cmbField($prefix, 'Front Page', $type, $show_on);

    $cmb_helper->addTab('Section 1');
    $cmb_helper->addField('title_1', 'Title', 'text');
    /*  Metaterm id will be front_page_1_title_1
        front_page_ is a $prefix based on function name
        1_ is tab number (incrementing after adding each tab with AddTab() method
        title_1 by the field added id
    */    
    
    $cmb_helper->addTab('Section 2');
    $cmb_helper->addField('title_1', 'Title', 'text');
    $cmb_helper->addField('text_1', 'Main Text', 'wysiwyg');
    $cmb_helper->addField('group_1', 'Photos', 'group');
    $cmb_helper->addField('image', 'Photo', 'file', 'group_1'); // 4th Parameter is group id
    $cmb_helper->addField('text', 'Text above photo', 'wysiwyg', 'group_1');
    $cmb_helper->addField('text_2', 'Second Text', 'wysiwyg');

    $cmb = new_cmb2_box($cmb_helper->generateCMB());
    $cmb->add_field($cmb_helper->generateTabs());  

}
