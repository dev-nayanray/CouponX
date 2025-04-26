<?php
// Disable emoji loading
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Clean up header
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');