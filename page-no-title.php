<?php
/**
 * Template Name: No Title Landing Page
 * Description: A custom template for landing pages without a page title.
 */
get_header(); 
?>

<?php
if (have_posts()) :
    while (have_posts()) : the_post();
        // DO NOT DISPLAY the_title();
        the_content();
    endwhile;
endif;
?>

<?php get_footer(); ?>
