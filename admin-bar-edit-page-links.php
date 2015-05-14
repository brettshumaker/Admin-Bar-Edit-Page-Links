<?php
/*
Plugin Name: Admin Bar Edit Content Links
Plugin URI: http://www.brettshumaker.com
Description: Adds an Edit Content link to the WordPress admin bar so you can quickly jump between editing pages, posts, and other custom post types. Very helpful if you're doing a lot of content editing.
Version: 1.1.1
Author: Brett Shumaker
Author URI: http://www.brettshumaker.com/
License: GPL2
*/

define( 'BS_ABEP_URL', plugin_dir_url(__FILE__) );
define( 'BS_ABEP_PATH', plugin_dir_path(__FILE__) );

register_activation_hook( __FILE__, 'bs_abep_activation_callback' );

/**
 * Load any translations
 */
load_plugin_textdomain( 'bs_abep', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );


/**
 * Load options page
 */
include_once( BS_ABEP_PATH . '/admin/settings.php' );

/**
 * Checks if we should add links to the bar.
 */
function bs_abep_admin_bar_init() {
	// Is the user sufficiently leveled, or has the bar been disabled?
	if (!is_super_admin() || !is_admin_bar_showing() )
		return;
 
	// Good to go, lets do this!
	add_action('admin_bar_menu', 'bs_abep_admin_bar_links', 500);
	
	// Load our admin style
	add_action('admin_enqueue_scripts','load_admin_styles');
	add_action('wp_enqueue_scripts','load_admin_styles');
}

// Get things running!
add_action('admin_bar_init', 'bs_abep_admin_bar_init');

/**
 * Add Admin Style
 */
function load_admin_styles() {
	wp_register_style( 'bs-abep-style', BS_ABEP_URL . 'css/bs-abep-style.css' );
	wp_enqueue_style( 'bs-abep-style' );
}

/**
 * Adds links to the bar.
 */
function bs_abep_admin_bar_links() {
	global $wp_admin_bar;
	$options = get_option('bs_abep_settings');
	$options = $options['types'];
	
	$wp_ver = get_bloginfo('version');
	
	if (floatval($wp_ver) >= 3.8) {
		$title = '<span class="ab-icon"></span><span class="ab-label">' . __('Edit Content', 'bs_abep') . '</span>';
		$img = '';
	} else {
		$title = '<span class="ab-icon"><img src="'. BS_ABEP_URL . '/images/edit-page-icon.png" /></span><span class="ab-label">' . __('Edit Content', 'bs_abep') . '</span>';
		$img = '_no_dashicon';
	}
	
	$admin_url = admin_url();
	
	// Add the Parent link.
	$wp_admin_bar->add_menu( array(
		'title' => $title,
		'href' => false,
		'id' => 'bs_abep_links'.$img,
	));
	
	$args = array(
		'order' => 'ASC',
		'orderby' => 'menu_order',
		'post_status' => 'publish',
		'posts_per_page' => -1,
	);
	
	foreach ($options as $post_type => $nice_name){
		$args['post_type'] = $post_type;
		
		// Filter the args now
		if (has_filter('bs_abep_query_args')) {
			$args = apply_filters('bs_abep_query_args', $args);
			
			// Let's reset the post type in case the user inadvertently changed it - there's really no reaon to change it.
			$args['post_type'] = $post_type;
		}
		
		$bs_abep_query = get_posts( $args );
		
		if ( !empty($bs_abep_query) ) :
			
			// We have some posts, let's add a parent menu
			$wp_admin_bar->add_menu( array(
							'title' => $nice_name,
							'href' => $admin_url . 'edit.php?post_type=' . $post_type,
							'id' => $post_type,
							'parent' => 'bs_abep_links'.$img
						));
			
			foreach ($bs_abep_query as $post) {
				if ($post->post_parent != 0){
					$label = '&nbsp;&nbsp;&ndash; '.ucwords($post->post_title);
					$parent_id = $post->post_parent;
					if ( ( count( get_post_ancestors($parent_id) ) ) >= 1 ) {
						$label = '&nbsp;&nbsp;&nbsp;'.$label;
					}
				} else {
					$label = ucwords($post->post_title);
				}
				
				$url = get_edit_post_link($post->ID);
				
				$wp_admin_bar->add_menu( array(
							'title' => $label,
							'href' => $url,
							'id' => $post->ID,
							'parent' => $post_type
						));
			}
		endif;
	}
}

function bs_abep_activation_callback() {
	$options = get_option('bs_abep_settings', array());
	
	$default = array(
		'types' => array(
			'page' => 'Pages',
		),
	);
	
	if ( empty($options) ) {
		update_option('bs_abep_settings', $default );
	}
}
?>