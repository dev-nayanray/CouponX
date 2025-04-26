<?php
/**
 * Masonry Coupon Layout
 * Title: Coupon Masonry
 * Slug: couponx/coupon-masonry
 * Categories: couponx
 */
$content = <<<CONTENT
<!-- wp:group {"align":"wide","className":"coupon-masonry","layout":{"type":"grid","columnCount":3}} -->
<div class="wp-block-group alignwide coupon-masonry">
    <!-- wp:group {"className":"masonry-item","layout":{"type":"constrained"}} -->
    <div class="wp-block-group masonry-item">
        <!-- wp:image {"sizeSlug":"full","className":"store-badge"} -->
        <figure class="wp-block-image size-full store-badge">
            <img src="' . esc_url(get_template_directory_uri()) . '/assets/images/store-badge.png" alt="Store Badge"/>
        </figure>
        <!-- /wp:image -->
        <!-- wp:paragraph {"align":"center"} -->
        <p class="has-text-align-center">EXTRA 10% OFF WITH CODE: <strong>SAVE10</strong></p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->
    
    <!-- Add more masonry items -->
</div>
<!-- /wp:group -->
CONTENT;

register_block_pattern(
    'couponx/coupon-masonry',
    array(
        'title'       => esc_html__('Coupon Masonry', 'couponx'),
        'description' => esc_html__('Pinterest-style masonry layout for coupon display', 'couponx'),
        'content'     => $content,
        'categories'  => array('couponx'),
    )
);