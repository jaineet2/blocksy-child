<?php
/**
 * Blocksy Child Theme functions and definitions.
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

add_action('init', 'services_repair');
function services_repair() {
    $args = array(
        'label'        => __('Services',),
        'public'       => true,
        'has_archive'  => true,
        'supports'     => array('title', 'editor', 'thumbnail'),
        // 'show_in_rest' => true,
        'rewrite'      => array('slug' => 'services'), // Ensures clean URLs
    );
    register_post_type('services_repair', $args);
}

add_action('acf/init', function () {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key'      => 'group_service_fields',
            'title'    => 'Service Fields',
            'fields'   => array(
                array(
                    'key'           => 'field_service_price',
                    'label'         => 'Price',
                    'name'          => 'service_price',
                    'type'          => 'number',
                    'instructions'  => 'price',
                    'required'      => 1,
                    'prepend'       => '$', // Adds a dollar sign before the input
                    'min'           => 0, // Prevents negative values
                ),
                array(
                    'key'           => 'field_service_extra_image',
                    'label'         => 'Extra Image',
                    'name'          => 'service_image',
                    'type'          => 'image',
                    'instructions'  => 'Upload service',
                    'required'      => 0,
                    'return_format' => 'array', // Returns full image array (URL, ID, alt, etc.)
                    'preview_size'  => 'medium',
                ),
				array(
                    'key'           => 'field_product_id',
                    'label'         => 'Product ID',
                    'name'          => 'product_id', // Field name for WooCommerce Product ID
                    'type'          => 'number',  // Ensure the field is a number
                    'instructions'  => 'Enter the related WooCommerce product ID.',
                    'required'      => 1, // Make sure this field is required
                ),
            ),
            
            'location' => array(
                array(
                    array(
                        'param'    => 'post_type',
                        'operator' => '==',
                        'value'    => 'services_repair', // Attach fields to Services CPT
                    ),
                ),
            ),
            'menu_order'            => 0,
            'position'              => 'normal',
            'style'                 => 'default',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen'        => '',
            'active'                => true,
            'description'           => '',
        ));
    }
});



?>

