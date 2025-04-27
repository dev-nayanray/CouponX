<?php
/**
 * Masonry Coupon Layout (Premium)
 * Title: Premium Coupon Masonry
 * Slug: couponx/coupon-masonry-premium
 * Categories: couponx, grid, featured
 */
$content = <<<CONTENT
<!-- wp:group {"align":"wide","className":"premium-coupon-masonry","layout":{"type":"grid","columnCount":3}} -->
<div class="wp-block-group alignwide premium-coupon-masonry">
    <!-- wp:group {"className":"masonry-item coupon-card","layout":{"type":"constrained"},"style":{"border":{"radius":"12px"},"spacing":{"padding":{"top":"20px","right":"20px","bottom":"20px","left":"20px"}}}} -->
    <div class="wp-block-group masonry-item coupon-card">
        <!-- wp:group {"className":"coupon-header","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
        <div class="wp-block-group coupon-header">
            <!-- wp:image {"width":"100px","height":"40px","sizeSlug":"full","className":"store-logo"} -->
            <figure class="wp-block-image size-full is-resized store-logo">
                <img src="' . esc_url(get_template_directory_uri()) . '/assets/images/store-logo.png" alt="Store Logo" width="100" height="40"/>
            </figure>
            <!-- /wp:image -->
            <!-- wp:paragraph {"className":"expiration-date","fontSize":"small"} -->
            <p class="expiration-date has-small-font-size">Exp: 2023-12-31</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->
        
        <!-- wp:separator {"className":"coupon-divider"} -->
        <hr class="wp-block-separator has-alpha-channel-opacity coupon-divider"/>
        <!-- /wp:separator -->
        
        <!-- wp:paragraph {"align":"center","className":"coupon-code","fontSize":"large"} -->
        <p class="has-text-align-center coupon-code has-large-font-size"><code>SAVE10</code></p>
        <!-- /wp:paragraph -->
        
        <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
        <div class="wp-block-buttons">
            <!-- wp:button {"className":"is-style-premium-reveal"} -->
            <div class="wp-block-button is-style-premium-reveal">
                <a class="wp-block-button__link wp-element-button" href="#">
                    Reveal Code
                    <i class="fas fa-chevron-down"></i>
                </a>
            </div>
            <!-- /wp:button -->
        </div>
        <!-- /wp:buttons -->
        
        <!-- wp:paragraph {"align":"center","className":"coupon-terms","fontSize":"small"} -->
        <p class="has-text-align-center coupon-terms has-small-font-size">* Terms & Conditions Apply</p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->
    
    <!-- Add more masonry items -->
</div>
<!-- /wp:group -->
CONTENT;

register_block_pattern(
    'couponx/coupon-masonry-premium',
    array(
        'title'       => esc_html__('Premium Coupon Masonry', 'couponx'),
        'description' => esc_html__('Modern masonry layout with dynamic coupon cards and reveal functionality', 'couponx'),
        'content'     => $content,
        'categories'  => array('couponx', 'featured'),
    )
);

// Enqueue styles and scripts
function couponx_premium_masonry_scripts() {
    wp_enqueue_style(
        'couponx-premium-masonry',
        get_template_directory_uri() . '/assets/css/premium-masonry.css',
        array(),
        '1.0.0'
    );
    
    wp_enqueue_script(
        'couponx-masonry-init',
        get_template_directory_uri() . '/assets/js/masonry-init.js',
        array('jquery', 'masonry'),
        '1.0.0',
        true
    );
    
    wp_enqueue_style(
        'couponx-font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
        array(),
        '6.4.0'
    );
}
add_action('wp_enqueue_scripts', 'couponx_premium_masonry_scripts');