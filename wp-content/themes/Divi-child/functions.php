<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array(  ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );

// END ENQUEUE PARENT ACTION

/* Enable Divi Builder on all post types with an editor box */
function myprefix_add_post_types($post_types) {
	foreach(get_post_types() as $pt) {
		if (!in_array($pt, $post_types) and post_type_supports($pt, 'editor')) {
			$post_types[] = $pt;
		}
	} 
	return $post_types;
}
add_filter('et_builder_post_types', 'myprefix_add_post_types');

/* Add Divi Custom Post Settings box */
function myprefix_add_meta_boxes() {
	foreach(get_post_types() as $pt) {
		if (post_type_supports($pt, 'editor') and function_exists('et_single_settings_meta_box')) {
			add_meta_box('et_settings_meta_box', __('Divi Custom Post Settings', 'Divi'), 'et_single_settings_meta_box', $pt, 'side', 'high');
		}
	} 
}
add_action('add_meta_boxes', 'myprefix_add_meta_boxes');

/* Ensure Divi Builder appears in correct location */
function myprefix_admin_js() { 
	$s = get_current_screen();
	if(!empty($s->post_type) and $s->post_type!='page' and $s->post_type!='post') { 
?>
<script>
jQuery(function($){
	$('#et_pb_layout').insertAfter($('#et_pb_main_editor_wrap'));
});
</script>
<style>
#et_pb_layout { margin-top:20px; margin-bottom:0px }
</style>
<?php
	}
}
add_action('admin_head', 'myprefix_admin_js');

// Ensure that Divi Builder framework is loaded - required for some post types when using Divi Builder plugin
add_filter('et_divi_role_editor_page', 'myprefix_load_builder_on_all_page_types');
function myprefix_load_builder_on_all_page_types($page) { 
	return isset($_GET['page'])?$_GET['page']:$page; 
}
add_filter( 'et_pb_show_all_layouts_built_for_post_type', 'myprefix_et_pb_show_all_layouts_built_for_post_type' );

function myprefix_et_pb_show_all_layouts_built_for_post_type() {
    return 'page';
}
  
add_filter( 'FHEE__EE_Ticket_Selector__display_ticket_selector_submit__btn_text', 'my_custom_button_text', 10, 2 );
function my_custom_button_text( $btn_text, $event ) {
	//~ if ( $event->ID() == 51803 ) { // change this ID to match your event ID
		$btn_text = 'register for this course'; // change button text here
	//~ }
	return $btn_text;
}
