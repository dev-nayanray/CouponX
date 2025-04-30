<?php
/**
 * Masonry Coupon Layout (Premium)
 * Title: Premium Coupon Masonry with Load More
 * Slug: couponx/coupon-masonry-premium
 * Categories: couponx, grid, featured
 */
$content = <<<CONTENT
<!-- wp:group {"align":"wide","className":"premium-coupon-masonry","layout":{"type":"grid","columnCount":3}} -->
<div class="wp-block-group alignwide premium-coupon-masonry">
    <!-- wp:query {"queryId":1,"query":{"perPage":6,"pages":0,"offset":0,"postType":"coupon","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false}} -->
    <div class="wp-block-query">
        <!-- wp:post-template -->
            <!-- wp:group {"className":"masonry-item coupon-card premium-card","layout":{"type":"constrained"},"style":{"border":{"radius":"12px"},"spacing":{"padding":{"top":"20px","right":"20px","bottom":"20px","left":"20px"}}}} -->
            <div class="wp-block-group masonry-item coupon-card premium-card">
                <!-- wp:group {"className":"top-rated-badge","layout":{"type":"flex","justifyContent":"center"}} -->
                <div class="wp-block-group top-rated-badge">
                    <!-- wp:post-terms {"term":"coupon_rating","className":"rating-stars","fontSize":"small"} /-->
                </div>
                <!-- /wp:group -->
                
                <!-- wp:group {"className":"coupon-header","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
                <div class="wp-block-group coupon-header">
                    <!-- wp:post-featured-image {"width":"100px","height":"40px","sizeSlug":"full","className":"store-logo"} /-->
                    <!-- wp:post-date {"className":"expiration-date premium-expiry","fontSize":"small"} /-->
                </div>
                <!-- /wp:group -->
                
                <!-- wp:separator {"className":"coupon-divider premium-divider"} -->
                <hr class="wp-block-separator has-alpha-channel-opacity coupon-divider premium-divider"/>
                <!-- /wp:separator -->
                
                <!-- wp:paragraph {"align":"center","className":"coupon-code premium-code","fontSize":"x-large"} -->
                <p class="has-text-align-center coupon-code premium-code has-x-large-font-size">
                    <code class="coupon-value">[coupon code="POST_META"][/coupon]</code>
                </p>
                <!-- /wp:paragraph -->
                
                <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
                <div class="wp-block-buttons">
                    <!-- wp:button {"className":"is-style-premium-reveal glitter-effect","width":100} -->
                    <div class="wp-block-button is-style-premium-reveal has-custom-width wp-block-button__width-100">
                        <a class="wp-block-button__link wp-element-button" href="#">
                            <span class="reveal-text">Reveal Exclusive Code</span>
                            <i class="fas fa-chevron-down reveal-icon"></i>
                        </a>
                    </div>
                    <!-- /wp:button -->
                </div>
                <!-- /wp:buttons -->
                
                <!-- wp:paragraph {"align":"center","className":"coupon-terms premium-terms","fontSize":"small"} -->
                <p class="has-text-align-center coupon-terms premium-terms has-small-font-size">
                    <i class="fas fa-gem"></i> <!-- wp:post-excerpt /-->
                </p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->
        <!-- /wp:post-template -->
    </div>
    <!-- /wp:query -->
</div>
<!-- /wp:group -->

<!-- wp:buttons {"align":"center","className":"load-more-wrapper"} -->
<div class="wp-block-buttons aligncenter load-more-wrapper">
    <!-- wp:button {"className":"is-style-load-more"} -->
    <div class="wp-block-button is-style-load-more">
        <a class="wp-block-button__link wp-element-button">Load More</a>
    </div>
    <!-- /wp:button -->
</div>
<!-- /wp:buttons -->
CONTENT;

register_block_pattern(
    'couponx/coupon-masonry-premium',
    array(
        'title'       => esc_html__('Premium Coupon Masonry', 'couponx'),
        'description' => esc_html__('Premium masonry layout with load more functionality', 'couponx'),
        'content'     => $content,
        'categories'  => array('couponx', 'featured'),
    )
);

// Enhanced Styles
if ( ! function_exists( 'couponx_premium_styles' ) ) {
    function couponx_premium_styles() {
        wp_enqueue_style('couponx-premium', get_stylesheet_directory_uri() . '/premium-style.css', array(), '1.2');
        wp_enqueue_script('couponx-masonry', get_stylesheet_directory_uri() . '/js/masonry-init.js', array('jquery', 'masonry'), '1.2', true);
        wp_enqueue_style('font-awesome-pro', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome-pro/6.4.0/css/all.min.css');
    }
    add_action('wp_enqueue_scripts', 'couponx_premium_styles');
}


// AJAX Load More
add_action('wp_ajax_load_more_coupons', 'couponx_load_more_coupons');
add_action('wp_ajax_nopriv_load_more_coupons', 'couponx_load_more_coupons');

function couponx_load_more_coupons() {
    $paged = $_POST['page'] + 1;
    $args = array(
        'post_type' => 'coupon',
        'posts_per_page' => 6,
        'paged' => $paged
    );

    $query = new WP_Query($args);
    
    if($query->have_posts()) :
        while($query->have_posts()) : $query->the_post();
            // Output your coupon card HTML here
        endwhile;
    endif;
    wp_reset_postdata();
    die();
}