<?php

add_action( 'wp_ajax_vc_action_save_settings_preset', 'vc_action_save_settings_preset' );
add_action( 'wp_ajax_vc_action_set_as_default_settings_preset', 'vc_action_set_as_default_settings_preset' );
add_action( 'wp_ajax_vc_action_delete_settings_preset', 'vc_action_delete_settings_preset' );
add_action( 'wp_ajax_vc_action_restore_default_settings_preset', 'vc_action_restore_default_settings_preset' );
add_action( 'wp_ajax_vc_action_get_settings_preset', 'vc_action_get_settings_preset' );
add_action( 'wp_ajax_vc_action_render_settings_preset_popup', 'vc_action_render_settings_preset_popup' );
add_action( 'wp_ajax_vc_action_render_settings_preset_title_prompt', 'vc_action_render_settings_preset_title_prompt' );

/**
 * Get mime type for specific shortcode
 *
 * @since 4.7
 *
 * @param $shortcode_name
 *
 * @return string
 */
function vc_construct_shortcode_mime_type( $shortcode_name ) {
	return 'vc-settings-preset/' . str_replace( '_', '-', $shortcode_name );
}

/**
 * Get shortcode name from post's mime type
 *
 * @since 4.7
 *
 * @param string $post_mime_type
 *
 * @return string
 */
function vc_extract_shortcode_mime_type( $post_mime_type ) {
	$chunks = explode( '/', $post_mime_type );

	if ( 2 !== count( $chunks ) ) {
		return '';
	}

	return str_replace( '-', '_', $chunks[1] );
}

/**
 * Get default preset id for specific shortcode
 *
 * @since 4.7
 *
 * @param string $shortcode_name
 *
 * @return mixed int|null
 */
function vc_get_default_settings_preset_id( $shortcode_name = null ) {
	if ( ! $shortcode_name ) {
		return null;
	}

	$args = array(
		'post_type' => 'vc_settings_preset',
		'post_mime_type' => vc_construct_shortcode_mime_type( $shortcode_name ),
		'posts_per_page' => - 1,
		'meta_key' => '_vc_default',
		'meta_value' => true
	);

	$posts = get_posts( $args );

	if ( ! $posts ) {
		return null;
	}

	return $posts[0]->ID;
}

/**
 * Get all default presets
 *
 * @since 4.7
 *
 * @return array E.g. array(shortcode_name => value, shortcode_name => value, ...)
 */
function vc_list_default_settings_presets() {
	$list = array();

	$args = array(
		'post_type' => 'vc_settings_preset',
		'posts_per_page' => - 1,
		'meta_key' => '_vc_default',
		'meta_value' => true
	);

	$posts = get_posts( $args );
	foreach ( $posts as $post ) {
		$shortcode_name = vc_extract_shortcode_mime_type( $post->post_mime_type );
		$list[ $shortcode_name ] = (array) json_decode( $post->post_content );
	}

	return $list;
}

/**
 * Save shortcode preset
 *
 * @since 4.7
 *
 * @param string $shortcode_name
 * @param string $title
 * @param string $content
 * @param boolean $is_default
 *
 * @return mixed int|false Post ID
 */
function vc_save_settings_preset( $shortcode_name, $title, $content, $is_default = false ) {
	$post_id = wp_insert_post( array(
		'post_title' => $title,
		'post_content' => $content,
		'post_status' => 'publish',
		'post_type' => 'vc_settings_preset',
		'post_mime_type' => vc_construct_shortcode_mime_type( $shortcode_name )
	), false );

	if ( $post_id && $is_default ) {
		vc_set_as_default_settings_preset( $post_id, $shortcode_name );
	}

	return $post_id;
}

/**
 * Get list of all presets for specific shortcode
 *
 * @since 4.7
 *
 * @param string $shortcode_name
 *
 * @return array E.g. array(id1 => title1, id2 => title2, ...)
 */
function vc_list_settings_presets( $shortcode_name = null ) {
	$list = array();

	if ( ! $shortcode_name ) {
		return $list;
	}

	$args = array(
		'post_type' => 'vc_settings_preset',
		'orderby' => array( 'post_date' => 'DESC' ),
		'posts_per_page' => - 1,
		'post_mime_type' => vc_construct_shortcode_mime_type( $shortcode_name )
	);

	$posts = get_posts( $args );
	foreach ( $posts as $post ) {
		$list[ $post->ID ] = $post->post_title;
	}

	return $list;
}

/**
 * Get specific shortcode preset
 *
 * @since 4.7
 *
 * @param int $id
 * @param bool $array If true, return array instead of string
 *
 * @return mixed string?array Post content
 */
function vc_get_settings_preset( $id, $array = false ) {
	$post = get_post( $id );

	if ( ! $post ) {
		return false;
	}

	return $array ? (array) json_decode( $post->post_content ) : $post->post_content;
}

/**
 * Delete shortcode preset
 *
 * @since 4.7
 *
 * @param int $post_id Post must be of type 'vc_settings_preset'
 *
 * @return bool
 */
function vc_delete_settings_preset( $post_id ) {
	$args = array(
		'ID' => $post_id,
		'post_type' => 'vc_settings_preset'
	);

	$posts = get_posts( $args );

	if ( ! $posts ) {
		return false;
	}

	return (bool) wp_delete_post( $post_id, true );
}

/**
 * Return rendered popup menu
 *
 * @since 4.7
 *
 * @param string $shortcode_name
 *
 * @return string
 */
function vc_get_rendered_settings_preset_popup( $shortcode_name ) {
	$list_presets = vc_list_settings_presets( $shortcode_name );
	$default_id = vc_get_default_settings_preset_id( $shortcode_name );

	ob_start();
	vc_include_template( apply_filters( 'vc_render_settings_preset_popup',
		'editors/partials/settings_presets_popup.tpl.php' ), array(
		'list_presets' => $list_presets,
		'default_id' => $default_id
	) );

	$html = ob_get_clean();

	return $html;
}

/**
 * Save settings preset for specific shortcode
 *
 * Include freshly rendered html in response
 *
 * Required _POST params:
 * - shortcode_name string
 * - title string
 * - data string params in json
 * - is_default
 *
 * @since 4.7
 */
function vc_action_save_settings_preset() {
	$id = vc_save_settings_preset(
		vc_post_param( 'shortcode_name' ),
		vc_post_param( 'title' ),
		vc_post_param( 'data' ),
		vc_post_param( 'is_default' )
	);

	$response = array(
		'success' => (bool) $id,
		'html' => vc_get_rendered_settings_preset_popup( vc_post_param( 'shortcode_name' ) ),
		'id' => $id
	);

	wp_send_json( $response );
}

/**
 * Set existing preset as default
 *
 * @param int $id If falsy, no default will be set
 * @param string $shortcode_name
 *
 * @return boolean
 *
 * @since 4.7
 */
function vc_set_as_default_settings_preset( $id, $shortcode_name ) {
	$post_id = vc_get_default_settings_preset_id( $shortcode_name );
	if ( $post_id ) {
		delete_post_meta( $post_id, '_vc_default' );
	}

	if ( $id ) {
		update_post_meta( $id, '_vc_default', true );
	}

	return true;
}

/**
 * Set existing preset as default
 *
 * Include freshly rendered html in response
 *
 * Required _POST params:
 * - id int
 * - shortcode_name string
 *
 * @since 4.7
 */
function vc_action_set_as_default_settings_preset() {
	$id = vc_post_param( 'id' );
	$shortcode_name = vc_post_param( 'shortcode_name' );

	$status = vc_set_as_default_settings_preset( $id, $shortcode_name );

	$response = array(
		'success' => $status,
		'html' => vc_get_rendered_settings_preset_popup( $shortcode_name )
	);

	wp_send_json( $response );
}

/**
 * Unmark current default preset as default
 *
 * Include freshly rendered html in response
 *
 * Required _POST params:
 * - shortcode_name string
 *
 * @since 4.7
 */
function vc_action_restore_default_settings_preset() {
	$shortcode_name = vc_post_param( 'shortcode_name' );

	$status = vc_set_as_default_settings_preset( null, $shortcode_name );

	$response = array(
		'success' => $status,
		'html' => vc_get_rendered_settings_preset_popup( $shortcode_name )
	);

	wp_send_json( $response );
}

/**
 * Delete specific settings preset
 *
 * Include freshly rendered html in response
 *
 * Required _POST params:
 * - shortcode_name string
 * - id int
 *
 * @since 4.7
 */
function vc_action_delete_settings_preset() {
	$default = get_post_meta( vc_post_param( 'id' ), '_vc_default', true );

	$status = vc_delete_settings_preset(
		vc_post_param( 'id' )
	);

	$response = array(
		'success' => $status,
		'default' => $default,
		'html' => vc_get_rendered_settings_preset_popup( vc_post_param( 'shortcode_name' ) )
	);

	wp_send_json( $response );
}

/**
 * Get data for specific settings preset
 *
 * Required _POST params:
 * - id int
 *
 * @since 4.7
 */
function vc_action_get_settings_preset() {
	$data = vc_get_settings_preset(
		vc_post_param( 'id' ), true
	);

	if ( false !== $data ) {
		$response = array(
			'success' => true,
			'data' => $data
		);
	} else {
		$response = array(
			'success' => false
		);
	}

	wp_send_json( $response );
}

/**
 * Respond with rendered popup menu
 *
 * Required _POST params:
 * - shortcode_name string
 *
 * @since 4.7
 */
function vc_action_render_settings_preset_popup() {
	$html = vc_get_rendered_settings_preset_popup( vc_post_param( 'shortcode_name' ) );

	$response = array(
		'success' => true,
		'html' => $html
	);

	wp_send_json( $response );
}


/**
 * Return rendered title prompt
 *
 * @since 4.7
 *
 * @return string
 */
function vc_action_render_settings_preset_title_prompt() {
	ob_start();
	vc_include_template( apply_filters( 'vc_render_settings_preset_title_prompt', 'editors/partials/prompt.tpl.php' ) );
	$html = ob_get_clean();

	$response = array(
		'success' => true,
		'html' => $html
	);

	wp_send_json( $response );
}