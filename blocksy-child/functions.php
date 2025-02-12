<?php
/**
 * Blocksy-child Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package blocksy-child
 */

add_action( 'wp_enqueue_scripts', 'blocksy_parent_theme_enqueue_styles' );

/**
 * Enqueue scripts and styles.
 */
function blocksy_parent_theme_enqueue_styles() {
	wp_enqueue_style( 'blocksy-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'blocksy-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[ 'blocksy-style' ]
	);
}
function add_technician_registration_link() {
    if ( isset($_GET['technician_register']) ) {
        echo '<input type="hidden" name="user_role" value="technician">';
    } else {
        echo '<p><a href="' . esc_url( wp_registration_url() . '&technician_register=1' ) . '">Register as Technician</a></p>';
    }
}
add_action( 'register_form', 'add_technician_registration_link' );
function assign_technician_role_on_registration( $user_id ) {
    if ( isset( $_POST['user_role'] ) && $_POST['user_role'] === 'technician' ) {
        $user = new WP_User( $user_id );
        $user->set_role( 'technician' );
    }
}
add_action( 'user_register', 'assign_technician_role_on_registration' );

function modify_technician_role() {
    $role = get_role('technician'); // Get the technician role

    if (!$role) {
        add_role('technician', 'Technician', ['read' => true]); // Add role if not exists
    }

    // Add permissions (capabilities)
    $role->add_cap('read'); // Can read posts & basic WP content
    $role->add_cap('edit_posts'); // Can edit their own posts
    $role->add_cap('upload_files'); // Can upload media
}
add_action('init', 'modify_technician_role');

function hide_admin_menus_for_technician() {
    if (current_user_can('technician') && !current_user_can('manage_options')) {
        remove_menu_page('edit.php'); // Hide Posts
        remove_menu_page('edit-comments.php'); // Hide Comments
        remove_menu_page('tools.php'); // Hide Tools
    }
}
add_action('admin_menu', 'hide_admin_menus_for_technician');
