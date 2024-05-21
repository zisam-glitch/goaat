<?php get_header(); ?>
<div id="loader" onclick="navigateToNewPage()">
    <img class="loading" src="<?php echo get_template_directory_uri(); ?>/img/loading.gif" alt="Loading...">
</div>

<script>
    function navigateToNewPage() {
        window.location.href = '/wordpress/projects'; // Replace with your desired URL
    }
</script>

