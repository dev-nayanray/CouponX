<?php
/**
 * Store Directory Grid
 * Title: Store Directory
 * Slug: couponx/store-directory
 * Categories: couponx
 */
$content = <<<CONTENT
<!-- wp:group {"align":"wide","className":"store-directory"} -->
<div class="wp-block-group alignwide store-directory">
    <!-- wp:heading {"textAlign":"center"} -->
    <h2 class="has-text-align-center">Popular Stores</h2>
    <!-- /wp:heading -->
    
    <!-- wp:columns {"columns":4} -->
    <div class="wp-block-columns has-4-columns">
        <!-- wp:column -->
        <div class="wp-block-column">
            <!-- wp:image {"sizeSlug":"full","className":"store-logo"} -->
            <figure class="wp-block-image size-full store-logo">
                <img src="' . esc_url(get_template_directory_uri()) . '/assets/images/store-logo1.png" alt="Store Name"/>
            </figure>
            <!-- /wp:image -->
        </div>
        <!-- /wp:column -->
        
        <!-- Add more store logos -->
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->
CONTENT;

register_block_pattern(
    'couponx/store-directory',
    array(
        'title'       => esc_html__('Store Directory', 'couponx'),
        'description' => esc_html__('4-column grid of popular store logos with hover effects', 'couponx'),
        'content'     => $content,
        'categories'  => array('couponx'),
    )
);