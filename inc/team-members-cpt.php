<?php
function create_team_members_cpt() {
    $labels = array(
        'name' => _x('Team Members', 'Post Type General Name', 'textdomain'),
        'singular_name' => _x('Team Member', 'Post Type Singular Name', 'textdomain'),
        'menu_name' => __('Team Members', 'textdomain'),
        'name_admin_bar' => __('Team Member', 'textdomain'),
        'archives' => __('Team Member Archives', 'textdomain'),
        'attributes' => __('Team Member Attributes', 'textdomain'),
        'parent_item_colon' => __('Parent Team Member:', 'textdomain'),
        'all_items' => __('All Team Members', 'textdomain'),
        'add_new_item' => __('Add New Team Member', 'textdomain'),
        'add_new' => __('Add New', 'textdomain'),
        'new_item' => __('New Team Member', 'textdomain'),
        'edit_item' => __('Edit Team Member', 'textdomain'),
        'update_item' => __('Update Team Member', 'textdomain'),
        'view_item' => __('View Team Member', 'textdomain'),
        'view_items' => __('View Team Members', 'textdomain'),
        'search_items' => __('Search Team Member', 'textdomain'),
        'not_found' => __('Not found', 'textdomain'),
        'not_found_in_trash' => __('Not found in Trash', 'textdomain'),
        'featured_image' => __('Featured Image', 'textdomain'),
        'set_featured_image' => __('Set featured image', 'textdomain'),
        'remove_featured_image' => __('Remove featured image', 'textdomain'),
        'use_featured_image' => __('Use as featured image', 'textdomain'),
        'insert_into_item' => __('Insert into Team Member', 'textdomain'),
        'uploaded_to_this_item' => __('Uploaded to this Team Member', 'textdomain'),
        'items_list' => __('Team Members list', 'textdomain'),
        'items_list_navigation' => __('Team Members list navigation', 'textdomain'),
        'filter_items_list' => __('Filter Team Members list', 'textdomain'),
    );
    $args = array(
        'label' => __('Team Member', 'textdomain'),
        'description' => __('Post Type Description', 'textdomain'),
        'labels' => $labels,
        'supports' => array('title', 'thumbnail'), 
        'taxonomies' => array('role'), 
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-groups',
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'show_in_rest' => true, 
    );
    register_post_type('team_member', $args);
}
add_action('init', 'create_team_members_cpt', 0);

// Register 'role' taxonomy
function create_role_taxonomy() {
    $labels = array(
        'name' => _x('Roles', 'taxonomy general name', 'textdomain'),
        'singular_name' => _x('Role', 'taxonomy singular name', 'textdomain'),
        'search_items' => __('Search Roles', 'textdomain'),
        'all_items' => __('All Roles', 'textdomain'),
        'parent_item' => __('Parent Role', 'textdomain'),
        'parent_item_colon' => __('Parent Role:', 'textdomain'),
        'edit_item' => __('Edit Role', 'textdomain'),
        'update_item' => __('Update Role', 'textdomain'),
        'add_new_item' => __('Add New Role', 'textdomain'),
        'new_item_name' => __('New Role Name', 'textdomain'),
        'menu_name' => __('Role', 'textdomain'),
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'role'),
    );

    register_taxonomy('role', array('team_member'), $args);
}
add_action('init', 'create_role_taxonomy', 0);
