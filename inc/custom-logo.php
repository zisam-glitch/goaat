<?php
// functions.php or a custom file included in functions.php

function theme_custom_logo_setup() {
    add_theme_support('custom-logo');
}
add_action('after_setup_theme', 'theme_custom_logo_setup');
?>
