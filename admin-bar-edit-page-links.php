<?php
/*
Plugin Name: Admin Bar Edit Page Links
Plugin URI: http://www.brettshumaker.com
Description: Adds edit page links to the WordPress admin bar so you can quickly jump between editing pages. Very helpful if you're doing a lot of content editing.
Version: 1.04
Author: Brett Shumaker
Author URI: http://www.brettshumaker.com/
License: GPL2
*/

define( 'BS_ABEP_PATH', plugin_dir_url(__FILE__) );

/**
 * Load any translations
 */
load_plugin_textdomain( 'bs_abep', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );

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
	wp_register_style( 'bs-abep-style', BS_ABEP_PATH . '_css/bs-abep-style.css' );
	wp_enqueue_style( 'bs-abep-style' );
}

/**
 * Adds links to the bar.
 */
function bs_abep_admin_bar_links() {
	global $wp_admin_bar;
	
	$wp_ver = get_bloginfo('version');
	
	if (floatval($wp_ver) >= 3.8) {
		$title = '<span class="ab-icon"></span><span class="ab-label">' . __('Edit Pages', 'bs_abep') . '</span>';
		$img = '';
	} else {
		$title = '<span class="ab-icon"><img src="'. BS_ABEP_PATH . '/images/edit-page-icon.png" /></span><span class="ab-label">' . __('Edit Pages', 'bs_abep') . '</span>';
		$img = '_no_dashicon';
	}
	
	$admin_url = admin_url();
	
	// Add the Parent link.
	$wp_admin_bar->add_menu( array(
		'title' => $title,
		'href' => false,
		'id' => 'bs_abep_links'.$img,
		'href' => $admin_url.'edit.php?post_type=page'
	));
		
	$args = array(
		'sort_order' => 'ASC',
		'sort_column' => 'menu_order',
		'hierarchical' => 1,
		'exclude' => '',
		'include' => '',
		'meta_key' => '',
		'meta_value' => '',
		'authors' => '',
		'child_of' => 0,
		'parent' => -1,
		'exclude_tree' => '',
		'number' => '',
		'offset' => 0,
		'post_type' => 'page',
		'post_status' => 'publish'
	); 
	$pages = get_pages($args);
	
	foreach ($pages as $page) {
		
		if ($page->post_parent != 0){
			$label = '&nbsp;&nbsp;&ndash; '.ucwords($page->post_title);
			$parent_id = $page->post_parent;
			if ( ( count( get_post_ancestors($parent_id) ) ) >= 1 ) {
				$label = '&nbsp;&nbsp;&nbsp;'.$label;
			}
		} else {
			$label = ucwords($page->post_title);
		}
		$page_id	= $page->ID;
		$url		= get_edit_post_link($page_id);
		
		$wp_admin_bar->add_menu( array(
					'title' => $label,
					'href' => $url,
					'id' => $page_id,
					'parent' => 'bs_abep_links'.$img
				));
	}
}
?>