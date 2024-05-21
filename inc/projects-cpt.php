<?php
if (!defined('ABSPATH')) {
    exit;
}

function create_project_post_type() {
    $labels = array(
        'name'                  => _x('Projects', 'Post type general name', 'textdomain'),
        'singular_name'         => _x('Project', 'Post type singular name', 'textdomain'),
        'menu_name'             => _x('Projects', 'Admin Menu text', 'textdomain'),
        'name_admin_bar'        => _x('Project', 'Add New on Toolbar', 'textdomain'),
        'add_new'               => __('Add New', 'textdomain'),
        'add_new_item'          => __('Add New Project', 'textdomain'),
        'new_item'              => __('New Project', 'textdomain'),
        'edit_item'             => __('Edit Project', 'textdomain'),
        'view_item'             => __('View Project', 'textdomain'),
        'all_items'             => __('All Projects', 'textdomain'),
        'search_items'          => __('Search Projects', 'textdomain'),
        'parent_item_colon'     => __('Parent Projects:', 'textdomain'),
        'not_found'             => __('No projects found.', 'textdomain'),
        'not_found_in_trash'    => __('No projects found in Trash.', 'textdomain'),
        'featured_image'        => _x('Project Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain'),
        'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'archives'              => _x('Project archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain'),
        'insert_into_item'      => _x('Insert into project', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain'),
        'uploaded_to_this_item' => _x('Uploaded to this project', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain'),
        'filter_items_list'     => _x('Filter projects list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain'),
        'items_list_navigation' => _x('Projects list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain'),
        'items_list'            => _x('Projects list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'project'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => array('title', 'editor', 'thumbnail'),
        'taxonomies'         => array('project_category'),
    );

    register_post_type('project', $args);
}
add_action('init', 'create_project_post_type');

function create_project_taxonomy() {
    $labels = array(
        'name'              => _x('Project Categories', 'taxonomy general name', 'textdomain'),
        'singular_name'     => _x('Project Category', 'taxonomy singular name', 'textdomain'),
        'search_items'      => __('Search Project Categories', 'textdomain'),
        'all_items'         => __('All Project Categories', 'textdomain'),
        'parent_item'       => __('Parent Project Category', 'textdomain'),
        'parent_item_colon' => __('Parent Project Category:', 'textdomain'),
        'edit_item'         => __('Edit Project Category', 'textdomain'),
        'update_item'       => __('Update Project Category', 'textdomain'),
        'add_new_item'      => __('Add New Project Category', 'textdomain'),
        'new_item_name'     => __('New Project Category Name', 'textdomain'),
        'menu_name'         => __('Project Categories', 'textdomain'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'project-category'),
    );

    register_taxonomy('project_category', array('project'), $args);
}
add_action('init', 'create_project_taxonomy');

function add_project_meta_boxes() {
    add_meta_box(
        'project_details_meta_box',
        'Project Details',
        'display_project_details_meta_box',
        'project',
        'normal',
        'high'
    );

    add_meta_box(
        'project_images_meta_box',
        'Project Images',
        'display_project_images_meta_box',
        'project',
        'side',
        'low'
    );

    add_meta_box(
        'project_icon_meta_box',
        'Project Icon',
        'display_project_icon_meta_box',
        'project',
        'side',
        'low'
    );

    add_meta_box(
        'project_design_meta_box',
        'Project Design',
        'display_project_design_meta_box',
        'project',
        'side',
        'low'
    );

    add_meta_box(
        'project_scratch_meta_box',
        'Project Scratch',
        'display_project_scratch_meta_box',
        'project',
        'side',
        'low'
    );
}
add_action('add_meta_boxes', 'add_project_meta_boxes');

function display_project_details_meta_box($post) {
    $time_of_design = get_post_meta($post->ID, 'time_of_design', true);
    $current_state = get_post_meta($post->ID, 'current_state', true);
    $client = get_post_meta($post->ID, 'client', true);
    $location = get_post_meta($post->ID, 'location', true);

    wp_nonce_field('save_project_details_meta_box_data', 'project_details_meta_box_nonce');
    ?>

    <p>
        <label for="time_of_design">Time of Design</label>
        <input type="text" id="time_of_design" name="time_of_design" value="<?php echo esc_attr($time_of_design); ?>" />
    </p>
    <p>
        <label for="current_state">Current State</label>
        <input type="text" id="current_state" name="current_state" value="<?php echo esc_attr($current_state); ?>" />
    </p>
    <p>
        <label for="client">Client</label>
        <input type="text" id="client" name="client" value="<?php echo esc_attr($client); ?>" />
    </p>
    <p>
        <label for="location">Location</label>
        <input type="text" id="location" name="location" value="<?php echo esc_attr($location); ?>" />
    </p>
    <?php
}

function display_project_images_meta_box($post) {
    $project_images = get_post_meta($post->ID, 'project_images', true);
    $project_images = is_array($project_images) ? $project_images : array('');

    wp_nonce_field('save_project_images_meta_box_data', 'project_images_meta_box_nonce');
    ?>

    <div id="project_images_wrapper">
        <?php foreach ($project_images as $index => $image_id): 
            $image_url = wp_get_attachment_url($image_id);
        ?>
            <p>
                <label for="project_images[<?php echo $index; ?>]">Image</label>
                <input type="hidden" class="project-image-id" id="project_images[<?php echo $index; ?>]" name="project_images[]" value="<?php echo esc_attr($image_id); ?>" />
                <img src="<?php echo esc_attr($image_url); ?>" alt="" style="max-width: 100px; display: block; margin-bottom: 10px;" />
                <button type="button" class="button remove-image-button">Remove Image</button>
            </p>
        <?php endforeach; ?>
    </div>
    <button type="button" id="add_image_button" class="button">Add Image</button>

    <script>
        jQuery(document).ready(function($) {
            var mediaUploader;
            $('#add_image_button').click(function(e) {
                e.preventDefault();
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'Choose Image',
                    button: {
                        text: 'Choose Image'
                    }, multiple: false });

                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    var index = $('#project_images_wrapper p').length;
                    var newImageHtml = '<p><label for="project_images[' + index + ']">Image</label><input type="hidden" class="project-image-id" id="project_images[' + index + ']" name="project_images[]" value="' + attachment.id + '" /><img src="' + attachment.url + '" alt="" style="max-width: 100px; display: block; margin-bottom: 10px;" /><button type="button" class="button remove-image-button">Remove Image</button></p>';
                    $('#project_images_wrapper').append(newImageHtml);
                });
                mediaUploader.open();
            });
            $('body').on('click', '.remove-image-button', function() {
                $(this).closest('p').remove();
            });
        });
    </script>
    <?php
}

function display_project_icon_meta_box($post) {
    $project_icon = get_post_meta($post->ID, 'project_icon', true);
    $project_icon_url = wp_get_attachment_url($project_icon);

    wp_nonce_field('save_project_icon_meta_box_data', 'project_icon_meta_box_nonce');
    ?>

    <p>
        <label for="project_icon">Project Icon</label>
        <input type="hidden" id="project_icon" name="project_icon" value="<?php echo esc_attr($project_icon); ?>" />
        <img src="<?php echo esc_attr($project_icon_url); ?>" alt="" style="max-width: 100px; display: block; margin-bottom: 10px;" />
        <button type="button" id="upload_icon_button" class="button">Upload Icon</button>
    </p>

    <script>
        jQuery(document).ready(function($) {
            var mediaUploader;
            $('#upload_icon_button').click(function(e) {
                e.preventDefault();
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'Choose Icon',
                    button: {
                        text: 'Choose Icon'
                    }, multiple: false });

                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#project_icon').val(attachment.id);
                    $('#project_icon').siblings('img').attr('src', attachment.url);
                });
                mediaUploader.open();
            });
        });
    </script>
    <?php
}

function display_project_design_meta_box($post) {
    $project_design = get_post_meta($post->ID, 'project_design', true);
    $project_design_url = wp_get_attachment_url($project_design);

    wp_nonce_field('save_project_design_meta_box_data', 'project_design_meta_box_nonce');
    ?>

    <p>
        <label for="project_design">Project Design</label>
        <input type="hidden" id="project_design" name="project_design" value="<?php echo esc_attr($project_design); ?>" />
        <img src="<?php echo esc_attr($project_design_url); ?>" alt="" style="max-width: 100px; display: block; margin-bottom: 10px;" />
        <button type="button" id="upload_design_button" class="button">Upload Design</button>
    </p>

    <script>
        jQuery(document).ready(function($) {
            var mediaUploader;
            $('#upload_design_button').click(function(e) {
                e.preventDefault();
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'Choose Design',
                    button: {
                        text: 'Choose Design'
                    }, multiple: false });

                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#project_design').val(attachment.id);
                    $('#project_design').siblings('img').attr('src', attachment.url);
                });
                mediaUploader.open();
            });
        });
    </script>
    <?php
}

function display_project_scratch_meta_box($post) {
    $project_scratch = get_post_meta($post->ID, 'project_scratch', true);
    $project_scratch = is_array($project_scratch) ? $project_scratch : array('');

    wp_nonce_field('save_project_scratch_meta_box_data', 'project_scratch_meta_box_nonce');
    ?>

    <div id="project_scratch_wrapper">
        <?php foreach ($project_scratch as $index => $scratch_id): 
            $scratch_url = wp_get_attachment_url($scratch_id);
        ?>
            <p>
                <label for="project_scratch[<?php echo $index; ?>]">Scratch</label>
                <input type="hidden" class="project-scratch-id" id="project_scratch[<?php echo $index; ?>]" name="project_scratch[]" value="<?php echo esc_attr($scratch_id); ?>" />
                <img src="<?php echo esc_attr($scratch_url); ?>" alt="" style="max-width: 100px; display: block; margin-bottom: 10px;" />
                <button type="button" class="button remove-scratch-button">Remove Scratch</button>
            </p>
        <?php endforeach; ?>
    </div>
    <button type="button" id="add_scratch_button" class="button">Add Scratch</button>

    <script>
        jQuery(document).ready(function($) {
            var mediaUploader;
            $('#add_scratch_button').click(function(e) {
                e.preventDefault();
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'Choose Scratch',
                    button: {
                        text: 'Choose Scratch'
                    }, multiple: false });

                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    var index = $('#project_scratch_wrapper p').length;
                    var newScratchHtml = '<p><label for="project_scratch[' + index + ']">Scratch</label><input type="hidden" class="project-scratch-id" id="project_scratch[' + index + ']" name="project_scratch[]" value="' + attachment.id + '" /><img src="' + attachment.url + '" alt="" style="max-width: 100px; display: block; margin-bottom: 10px;" /><button type="button" class="button remove-scratch-button">Remove Scratch</button></p>';
                    $('#project_scratch_wrapper').append(newScratchHtml);
                });
                mediaUploader.open();
            });
            $('body').on('click', '.remove-scratch-button', function() {
                $(this).closest('p').remove();
            });
        });
    </script>
    <?php
}

function save_project_meta_boxes_data($post_id) {
    if (!isset($_POST['project_details_meta_box_nonce']) || !wp_verify_nonce($_POST['project_details_meta_box_nonce'], 'save_project_details_meta_box_data')) {
        return;
    }

    if (!isset($_POST['project_images_meta_box_nonce']) || !wp_verify_nonce($_POST['project_images_meta_box_nonce'], 'save_project_images_meta_box_data')) {
        return;
    }

    if (!isset($_POST['project_icon_meta_box_nonce']) || !wp_verify_nonce($_POST['project_icon_meta_box_nonce'], 'save_project_icon_meta_box_data')) {
        return;
    }

    if (!isset($_POST['project_design_meta_box_nonce']) || !wp_verify_nonce($_POST['project_design_meta_box_nonce'], 'save_project_design_meta_box_data')) {
        return;
    }

    if (!isset($_POST['project_scratch_meta_box_nonce']) || !wp_verify_nonce($_POST['project_scratch_meta_box_nonce'], 'save_project_scratch_meta_box_data')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['time_of_design'])) {
        update_post_meta($post_id, 'time_of_design', sanitize_text_field($_POST['time_of_design']));
    }

    if (isset($_POST['current_state'])) {
        update_post_meta($post_id, 'current_state', sanitize_text_field($_POST['current_state']));
    }

    if (isset($_POST['client'])) {
        update_post_meta($post_id, 'client', sanitize_text_field($_POST['client']));
    }

    if (isset($_POST['location'])) {
        update_post_meta($post_id, 'location', sanitize_text_field($_POST['location']));
    }

    if (isset($_POST['project_images'])) {
        $project_images = array_map('sanitize_text_field', $_POST['project_images']);
        update_post_meta($post_id, 'project_images', $project_images);
    }

    if (isset($_POST['project_icon'])) {
        update_post_meta($post_id, 'project_icon', sanitize_text_field($_POST['project_icon']));
    }

    if (isset($_POST['project_design'])) {
        update_post_meta($post_id, 'project_design', sanitize_text_field($_POST['project_design']));
    }

    if (isset($_POST['project_scratch'])) {
        $project_scratch = array_map('sanitize_text_field', $_POST['project_scratch']);
        update_post_meta($post_id, 'project_scratch', $project_scratch);
    }
}
add_action('save_post', 'save_project_meta_boxes_data');

function display_projects_shortcode($atts) {
    $atts = shortcode_atts(array(
        'count' => 10,
        'category' => '',
    ), $atts, 'display_projects');

    $args = array(
        'post_type' => 'project',
        'posts_per_page' => intval($atts['count']),
        'tax_query' => !empty($atts['category']) ? array(
            array(
                'taxonomy' => 'project_category',
                'field' => 'slug',
                'terms' => $atts['category'],
            ),
        ) : '',
    );

    $projects_query = new WP_Query($args);
    ob_start();
    if ($projects_query->have_posts()) {
        echo '<div class="projects-grid">';
        while ($projects_query->have_posts()) {
            $projects_query->the_post();
            $project_icon_id = get_post_meta(get_the_ID(), 'project_icon', true);
            $project_icon_url = wp_get_attachment_url($project_icon_id);
            $project_image_id = get_post_meta(get_the_ID(), 'project_images', true);
            $project_image_url = !empty($project_image_id) ? wp_get_attachment_url($project_image_id[0]) : '';

            ?>
            <a href="<?php the_permalink(); ?>" class="project-link">
                <div class="project-item">
                    <?php if ($project_icon_url): ?>
                        <img src="<?php echo esc_url($project_icon_url); ?>" alt="<?php the_title(); ?>" class="project-icon" />
                    <?php endif; ?>
                    <div class="project-hover-content">
                        <?php if ($project_image_url): ?>
                            <img src="<?php echo esc_url($project_image_url); ?>" alt="<?php the_title(); ?>" class="project-image" />
                        <?php endif; ?>
                        <h2 class="project-title"><?php the_title(); ?></h2>
                    </div>
                </div>
            </a>
            <?php
        }
        echo '</div>';
    } else {
        echo '<p>No projects found.</p>';
    }
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('display_projects', 'display_projects_shortcode');
