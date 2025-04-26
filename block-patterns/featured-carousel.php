<?php
/**
 * Featured Coupon Carousel
 * Title: Featured Carousel
 * Slug: couponx/featured-carousel
 * Categories: couponx
 */
$content = <<<CONTENT
<!-- wp:group {"align":"full","style":{"color":{"background":"#f8f9fa"},"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}} -->
<div class="wp-block-group alignfull has-background" style="background-color:#f8f9fa;padding-top:4rem;padding-bottom:4rem">
    <!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"2.5rem"}}} -->
    <h2 class="has-text-align-center" style="font-size:2.5rem">Today's Top Deals</h2>
    <!-- /wp:heading -->
    
    <!-- wp:columns {"align":"wide"} -->
    <div class="wp-block-columns alignwide">
        <!-- wp:column -->
        <div class="wp-block-column">
            <!-- wp:cover {"overlayColor":"primary","minHeight":300,"isDark":false} -->
            <div class="wp-block-cover is-light" style="min-height:300px">
                <!-- Content -->
            </div>
            <!-- /wp:cover -->
        </div>
        <!-- /wp:column -->
        
        <!-- Add more columns -->
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->
CONTENT;

register_block_pattern(
    'couponx/featured-carousel',
    array(
        'title'       => esc_html__('Featured Coupon Carousel', 'couponx'),
        'description' => esc_html__('Full-width carousel of featured coupons with gradient overlays', 'couponx'),
        'content'     => $content,
        'categories'  => array('couponx'),
    )
);