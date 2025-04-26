<?php
/**
 * User Testimonials
 * Title: Testimonial Slider
 * Slug: couponx/testimonial-slider
 * Categories: couponx
 */
$content = <<<CONTENT
<!-- wp:group {"align":"full","style":{"color":{"background":"#f8f9fa"}},"className":"testimonial-slider"} -->
<div class="wp-block-group alignfull has-background testimonial-slider" style="background-color:#f8f9fa">
    <!-- wp:columns {"align":"wide"} -->
    <div class="wp-block-columns alignwide">
        <!-- wp:column -->
        <div class="wp-block-column">
            <!-- wp:group {"className":"testimonial-card"} -->
            <div class="wp-block-group testimonial-card">
                <!-- wp:paragraph {"className":"testimonial-text"} -->
                <p class="testimonial-text">"Saved over $500 last month using CouponX deals!"</p>
                <!-- /wp:paragraph -->
                <!-- wp:image {"width":60,"height":60,"sizeSlug":"full","className":"is-style-rounded"} -->
                <figure class="wp-block-image size-full is-style-rounded">
                    <img src="' . esc_url(get_template_directory_uri()) . '/assets/images/user1.jpg" alt="User" width="60" height="60"/>
                </figure>
                <!-- /wp:image -->
                <!-- wp:paragraph {"align":"center"} -->
                <p class="has-text-align-center"><strong>Sarah J.</strong></p>
                <!-- /wp:paragraph -->
                <!-- wp:star-rating {"rating":5,"className":"is-style-filled"} -->
                <div class="wp-block-star-rating is-style-filled">★★★★★</div>
                <!-- /wp:star-rating -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:column -->
        
        <!-- Add more testimonial columns -->
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->
CONTENT;

register_block_pattern(
    'couponx/testimonial-slider',
    array(
        'title'       => esc_html__('Testimonial Slider', 'couponx'),
        'description' => esc_html__('User success stories carousel with ratings', 'couponx'),
        'content'     => $content,
        'categories'  => array('couponx'),
    )
);