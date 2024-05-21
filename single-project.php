<?php
get_header();
?>

<div class="container">
    <?php
    while (have_posts()) :
        the_post();
    ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div>
                <header class="entry-header">
                    <div>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="project-thumbnail">
                                <?php the_post_thumbnail(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="project-meta">
                        <div>
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                            <p class="project-location"><?php echo esc_html(get_post_meta(get_the_ID(), 'location', true)); ?></p>
                        </div>
                        <ul>
                            <li>Category :
                                <?php
                                $terms = get_the_terms(get_the_ID(), 'project_category');
                                if ($terms && !is_wp_error($terms)) {
                                    $term_names = wp_list_pluck($terms, 'name');
                                    echo esc_html(implode(', ', $term_names));
                                }
                                ?>
                            </li>
                            <li>Time of Design : <?php echo esc_html(get_post_meta(get_the_ID(), 'time_of_design', true)); ?></li>
                            <li>Current State : <?php echo esc_html(get_post_meta(get_the_ID(), 'current_state', true)); ?></li>
                            <li>Client : <?php echo esc_html(get_post_meta(get_the_ID(), 'client', true)); ?></li>
                        </ul>
                        <div class="project-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </header>

                <div class="entry-content">
                    <div class="project-images">
                        <?php
                        $project_images = get_post_meta(get_the_ID(), 'project_images', true);
                        if (!empty($project_images)) {
                            foreach ($project_images as $image_id) {
                                echo wp_get_attachment_image($image_id, 'medium');
                            }
                        }
                        ?>
                    </div>



                    <div class="project-design">

                        <?php
                        $project_design = get_post_meta(get_the_ID(), 'project_design', true);
                        if (!empty($project_design)) {
                            echo wp_get_attachment_image($project_design, 'medium');
                        }
                        ?>
                    </div>

                    <div class="project-scratch">
                        <?php
                        $project_scratch = get_post_meta(get_the_ID(), 'project_scratch', true);
                        if (!empty($project_scratch)) {
                            foreach ($project_scratch as $image_id) {
                                echo wp_get_attachment_image($image_id, 'medium');
                            }
                        }
                        ?>
                    </div>
                </div>
        </article>
    <?php
    endwhile;
    ?>
</div>

<?php
get_footer();
?>