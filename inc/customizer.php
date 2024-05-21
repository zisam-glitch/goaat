<?php
// functions.php or a custom file included in functions.php

function theme_customizer_logo_size($wp_customize) {
    $wp_customize->add_setting('logo_size', array(
        'default' => 'medium', // Default logo size
        'sanitize_callback' => 'theme_sanitize_logo_size', // Callback function for sanitization
    ));

    $wp_customize->add_control('logo_size', array(
        'type' => 'select',
        'section' => 'title_tagline', // Customize section where the control will appear
        'label' => __('Logo Size', 'theme_name'),
        'choices' => array(
            'small' => __('Small', 'theme_name'),
            'medium' => __('Medium', 'theme_name'),
            'large' => __('Large', 'theme_name'),
        ),
    ));
}

// Sanitize logo size option
function theme_sanitize_logo_size($value) {
    if (!in_array($value, array('small', 'medium', 'large'))) {
        $value = 'medium'; // Default to medium if invalid value
    }
    return $value;
}
add_action('customize_register', 'theme_customizer_logo_size');
?>
