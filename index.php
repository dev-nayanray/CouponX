<?php get_header(); ?>

<?php
if (have_posts()) :
    while (have_posts()) : the_post();
        if (!is_page(42)) { // Replace 42 with your specific Page ID
            ?>
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php
        }
        
        the_content();
        
    endwhile;
else :
    echo '<p>No content found.</p>';
endif;
?>

<?php get_footer(); ?>
