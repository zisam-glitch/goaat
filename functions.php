<?php

// functions.php

require_once get_template_directory() . '/inc/custom-logo.php';
require_once get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/team-members-cpt.php';
require get_template_directory() . '/inc/projects-cpt.php';

add_theme_support('post-thumbnails');

function my_function_admin_bar() {
    return false;
}
add_filter('show_admin_bar', 'my_function_admin_bar');

function move_thumbnail_meta_box() {
    remove_meta_box('postimagediv', 'team_member', 'side');
    add_meta_box('postimagediv', __('Featured Image'), 'post_thumbnail_meta_box', 'team_member', 'normal', 'high');
}
add_action('do_meta_boxes', 'move_thumbnail_meta_box');

function enqueue_custom_fonts() {
    wp_enqueue_style('custom-fonts', get_template_directory_uri() . '/styles/style.css');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_fonts');

function register_my_menus() {
    register_nav_menus(
        array(
            'main-menu' => __('Main Menu')
        )
    );
}
add_action('init', 'register_my_menus');

class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = ($depth > 0 ? str_repeat("\t", $depth) : '');
        $display_depth = ($depth + 1);
        $classes = array(
            'sub-menu',
            'custom-sub-menu',
        );
        $class_names = implode(' ', $classes);

        $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
    }
}

function custom_admin_styles() {
    wp_enqueue_style('custom-admin-styles', get_template_directory_uri() . '/styles/admin-style.css');
}
add_action('admin_enqueue_scripts', 'custom_admin_styles');

function enqueue_custom_styles() {
    wp_enqueue_style('custom-styles', get_template_directory_uri() . '/styles/styles.css');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');
