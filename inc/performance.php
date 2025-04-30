<?php
// Disable emoji loading
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Clean up WordPress header
remove_action('wp_head', 'rsd_link'); // Removes the Really Simple Discovery (RSD) link
remove_action('wp_head', 'wp_generator'); // Removes the WordPress version number

// Remove the REST API link from the header
remove_action('wp_head', 'wp_oembed_add_discovery_links'); // Disables oEmbed discovery links
remove_action('wp_head', 'wp_oembed_add_host_js'); // Disables oEmbed javascript

// Disable WordPress Emoji script and style enqueues
remove_action('wp_footer', 'print_emoji_detection_script'); // Disables Emoji script in footer
remove_action('wp_footer', 'print_emoji_styles'); // Disables Emoji styles in footer

// Remove WordPress API link in the header
remove_action('wp_head', 'feed_links', 2); // Remove feed links
remove_action('wp_head', 'feed_links_extra', 3); // Remove extra feed links
?>
