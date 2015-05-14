<?php
add_action( 'admin_menu', 'bs_abep_add_admin_menu' );
add_action( 'admin_init', 'bs_abep_settings_init' );


function bs_abep_add_admin_menu(  ) { 
	add_options_page( 'Admin Bar Edit Content Links', 'Admin Bar Edit Content Links', 'manage_options', 'admin_bar_edit_page_links', 'bs_abep_options_page' );
}


function bs_abep_settings_init(  ) { 
	register_setting( 'bs_abep_settings_page', 'bs_abep_settings' );

	add_settings_section(
		'bs_abep_settings_page_section', 
		__( 'Post Types', 'bs_abep' ), 
		'bs_abep_settings_section_callback', 
		'bs_abep_settings_page'
	);
	
	$post_types = bs_abep_get_post_types();
	
	foreach ($post_types as $name => $post_type) {
		$args = array('name' => $name, 'nice_name' => $post_type);
		
		add_settings_field(
			'bs_abep_types[' . $name . ']',
			$post_type,
			'bs_abep_checkbox_render',
			'bs_abep_settings_page',
			'bs_abep_settings_page_section',
			$args
		);
	}
}


function bs_abep_checkbox_render( $post_type ) { 
	$options = get_option( 'bs_abep_settings' );
	$options = $options['types'];
	
	if ( isset($options[$post_type['name']]) ) {
		$checked = checked( $options[$post_type['name']], $post_type['nice_name'], false );
	} elseif ( $post_type['name'] == 'page' ) {
		$checked = 'checked';
	}
	
	?>
	<input type='checkbox' name='bs_abep_settings[types][<?php echo $post_type['name']; ?>]' <?php echo $checked; ?> value='<?php echo $post_type['nice_name']; ?>'>
	<?php
}


function bs_abep_settings_section_callback(  ) { 
	echo __( 'Which post types do you want to show in the menu?', 'bs_abep' );
}


function bs_abep_options_page(  ) { 
	?>
	<form action='options.php' method='post'>
		
		<h2>Admin Bar Edit Content Links</h2>
		
		<?php
		settings_fields( 'bs_abep_settings_page' );
		do_settings_sections( 'bs_abep_settings_page' );
		submit_button();
		?>
		
	</form>
	<?php
}

function bs_abep_get_post_types( $excluded_post_types = array('Media') ) {
	$post_type_objs = get_post_types(array('show_ui' => true), 'objects');
	$return = array();
	
	$excluded_post_types = apply_filters('abepl-exclude-post-types', $excluded_post_types);
	// Make sure excluded_post_types is an array
	if (!is_array($excluded_post_types)) $excluded_post_types = array('Media');
	
	if (!empty($post_type_objs)) {
		foreach ($post_type_objs as $post_type) {
			if ($post_type->labels->name !== '' && !in_array($post_type->labels->name, $excluded_post_types) ) {
				$return[$post_type->name] = $post_type->labels->name;
			}
		}
	}
	
	if (empty($return)) {
		$return = '-1';
	}
	
	return $return;
}

?>