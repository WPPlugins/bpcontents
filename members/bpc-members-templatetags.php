<?php

function oci_the_member_category_list($args = ''){
	$defaults = array('taxonomy' => OCI_SITE_WIDE_USER_CATEGORY_TAXONOMY);
	$args = wp_parse_args($args, $defaults);
	echo oci_list_categories($args);
}

function oci_the_member_dropdown_categories($args = ''){

	$defaults = array(
		'hierarchical' => true,
		'hide_empty' => false,
		'name' => 'parent',
		'taxonomy' => OCI_SITE_WIDE_USER_CATEGORY_TAXONOMY
	);
	$args = wp_parse_args($args, $defaults);

	echo oci_dropdown_categories($args);
}

// current=0 for no selected cats
function oci_the_member_category_checklist($args = ''){
	global $bp;

	$defaults = array('taxonomy' => OCI_SITE_WIDE_USER_CATEGORY_TAXONOMY, 'current' => true);
	$args = wp_parse_args($args, $defaults);
	extract($args);

	if ($current){
		$item_id = oci_get_member_item_id($bp->loggedin_user->id);
	}

	echo oci_category_checklist( $taxonomy, $item_id);
}

function oci_the_member_tag_cloud($args = ''){
	$defaults = array('taxonomy' => OCI_SITE_WIDE_USER_TAG_TAXONOMY);
	$args = wp_parse_args($args, $defaults);

	echo oci_get_tag_cloud($args);
}

function oci_profile_site_admin_header_tabs() {
	global $bp;
?>
	<li<?php if ( !isset($bp->action_variables[0]) || BP_MEMBERS_SLUG == $bp->action_variables[0] ) : ?> class="current"<?php endif; ?>><a href="<?php echo $bp->loggedin_user->domain . $bp->contents->slug . '/admin/' . BP_MEMBERS_SLUG ?>"><?php _e( 'Members', 'oci-contents' ) ?></a></li>
	<li<?php if ( BP_GROUPS_SLUG == $bp->action_variables[0] ) : ?> class="current"<?php endif; ?>><a href="<?php echo $bp->loggedin_user->domain . $bp->contents->slug . '/admin/' . BP_GROUPS_SLUG ?>"><?php _e( 'Groups', 'oci-contents' ) ?></a></li>
	<li<?php if ( BP_BLOGS_SLUG == $bp->action_variables[0] ) : ?> class="current"<?php endif; ?>><a href="<?php echo $bp->loggedin_user->domain . $bp->contents->slug . '/admin/' . BP_BLOGS_SLUG ?>"><?php _e( 'Blogs', 'oci-contents' ) ?></a></li>
	<li<?php if ( OCI_TERM == $bp->action_variables[0] ) : ?> class="current"<?php endif; ?>><a href="<?php echo $bp->loggedin_user->domain . $bp->contents->slug . '/admin/' . OCI_TERM ?>"><?php _e( 'Terms', 'oci-contents' ) ?></a></li>

<?php
	do_action( 'oci_profile_site_admin_header_tabs' );
}

function oci_profile_header_tabs() {
	global $bp;
?>
	<li<?php if ( !isset($bp->action_variables[0]) || OCI_TAG == $bp->action_variables[0] ) : ?> class="current"<?php endif; ?>><a href="<?php echo $bp->loggedin_user->domain . $bp->contents->slug . '/' . OCI_PROFILE . '/' . OCI_TAG ?>"><?php _e( 'Tags', 'oci-contents' ) ?></a></li>
	<li<?php if ( OCI_CATEGORY == $bp->action_variables[0] ) : ?> class="current"<?php endif; ?>><a href="<?php echo $bp->loggedin_user->domain . $bp->contents->slug . '/' . OCI_PROFILE . '/' . OCI_CATEGORY ?>"><?php _e( 'Categories', 'oci-contents' ) ?></a></li>

<?php
	do_action( 'oci_profile_header_tabs' );
}

function oci_the_profile_action($action = null){
	echo oci_get_the_profile_action($action);
}
function oci_get_the_profile_action($action = null){
	global $bp;

	if ($action)
		$action = '/' . $action;

	$path = $bp->loggedin_user->domain . $bp->contents->slug . '/' . $bp->current_action . $action;
	return apply_filters('oci_get_the_profile_action', $path);
}

// gets the existing member item rec, creates one if it doesn't exist
function oci_get_member_item_id($user_id){
	$user = new BP_Core_User($user_id);
	if (!$user->id)
		return false;

	$item = new OCI_Item_User($user);

	if (!$item->id)
		$item->save();

	return $item->id;
}

?>
