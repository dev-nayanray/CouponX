<?php
/**
 * User Testimonials
 * Title: Testimonial Slider Section
 * Slug: couponx/testimonial-slider-section
 * Categories: couponx
 */
$content = <<<CONTENT
<!-- wp:group {"align":"full","className":"testimonial-slider-section","style":{"spacing":{"padding":{"top":"6rem","bottom":"6rem"},"margin":{"top":"0","bottom":"0"}},"backgroundColor":"light-gray"} -->
<div class="wp-block-group alignfull testimonial-slider-section has-light-gray-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:6rem;padding-bottom:6rem">
    
    <!-- Section Header -->
    <!-- wp:group {"align":"wide","className":"section-header","layout":{"type":"constrained"}} -->
    <div class="wp-block-group alignwide section-header">
        <!-- wp:heading {"textAlign":"center","level":2,"className":"section-title","fontSize":"xx-large"} -->
        <h2 class="wp-block-heading has-text-align-center section-title has-xx-large-font-size">Trusted by Thousands of Savvy Shoppers</h2>
        <!-- /wp:heading -->
        
        <!-- wp:paragraph {"align":"center","className":"section-description","fontSize":"large"} -->
        <p class="has-text-align-center section-description has-large-font-size">Discover how CouponX helps people save money every single day</p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->
    
    <!-- Slider Container -->
    <!-- wp:group {"align":"full","className":"testimonials-slider swiper","layout":{"type":"constrained"}} -->
    <div class="wp-block-group alignfull testimonials-slider swiper">
        <!-- Slider Wrapper -->
        <!-- wp:group {"className":"swiper-wrapper","layout":{"type":"flex","flexWrap":"nowrap"}} -->
        <div class="wp-block-group swiper-wrapper">
            
            <!-- Slide 1 -->
            <!-- wp:group {"className":"testimonial-card swiper-slide"} -->
            <div class="wp-block-group testimonial-card swiper-slide">
                <!-- wp:paragraph {"className":"testimonial-text"} -->
                <p class="testimonial-text">"CouponX completely transformed how I shop online. Saved over $2,500 last year using their deals!"</p>
                <!-- /wp:paragraph -->
                
                <!-- wp:group {"className":"testimonial-author","layout":{"type":"flex","flexWrap":"nowrap"}} -->
                <div class="wp-block-group testimonial-author">
                    <!-- wp:image {"width":64,"height":64,"sizeSlug":"full","className":"testimonial-avatar"} -->
                    <figure class="wp-block-image size-full is-resized testimonial-avatar">
                        <img src="https://picsum.photos/64/64?random=1" alt="Sarah M." width="64" height="64"/>
                    </figure>
                    <!-- /wp:image -->
                    
                    <!-- wp:group -->
                    <div class="wp-block-group">
                        <!-- wp:paragraph {"className":"testimonial-name"} -->
                        <p class="testimonial-name">Sarah M.</p>
                        <!-- /wp:paragraph -->
                        <!-- wp:paragraph {"className":"testimonial-role"} -->
                        <p class="testimonial-role">Digital Marketer</p>
                        <!-- /wp:paragraph -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:group -->
                
                <!-- wp:paragraph {"className":"testimonial-rating"} -->
                <p class="testimonial-rating">★★★★★</p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->
            
            <!-- Slide 2 -->
            <!-- wp:group {"className":"testimonial-card swiper-slide"} -->
            <div class="wp-block-group testimonial-card swiper-slide">
                <!-- wp:paragraph {"className":"testimonial-text"} -->
                <p class="testimonial-text">"The browser extension applies coupon codes automatically. Saved $120 last month!"</p>
                <!-- /wp:paragraph -->
                
                <!-- wp:group {"className":"testimonial-author","layout":{"type":"flex","flexWrap":"nowrap"}} -->
                <div class="wp-block-group testimonial-author">
                    <!-- wp:image {"width":64,"height":64,"sizeSlug":"full","className":"testimonial-avatar"} -->
                    <figure class="wp-block-image size-full is-resized testimonial-avatar">
                        <img src="https://picsum.photos/64/64?random=2" alt="James L." width="64" height="64"/>
                    </figure>
                    <!-- /wp:image -->
                    
                    <!-- wp:group -->
                    <div class="wp-block-group">
                        <!-- wp:paragraph {"className":"testimonial-name"} -->
                        <p class="testimonial-name">James L.</p>
                        <!-- /wp:paragraph -->
                        <!-- wp:paragraph {"className":"testimonial-role"} -->
                        <p class="testimonial-role">Freelance Designer</p>
                        <!-- /wp:paragraph -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:group -->
                
                <!-- wp:paragraph {"className":"testimonial-rating"} -->
                <p class="testimonial-rating">★★★★★</p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->
            
            <!-- Slide 3 -->
            <!-- wp:group {"className":"testimonial-card swiper-slide"} -->
            <div class="wp-block-group testimonial-card swiper-slide">
                <!-- wp:paragraph {"className":"testimonial-text"} -->
                <p class="testimonial-text">"Price comparison tool saved me $300 on a new laptop purchase!"</p>
                <!-- /wp:paragraph -->
                
                <!-- wp:group {"className":"testimonial-author","layout":{"type":"flex","flexWrap":"nowrap"}} -->
                <div class="wp-block-group testimonial-author">
                    <!-- wp:image {"width":64,"height":64,"sizeSlug":"full","className":"testimonial-avatar"} -->
                    <figure class="wp-block-image size-full is-resized testimonial-avatar">
                        <img src="https://picsum.photos/64/64?random=3" alt="Emma K." width="64" height="64"/>
                    </figure>
                    <!-- /wp:image -->
                    
                    <!-- wp:group -->
                    <div class="wp-block-group">
                        <!-- wp:paragraph {"className":"testimonial-name"} -->
                        <p class="testimonial-name">Emma K.</p>
                        <!-- /wp:paragraph -->
                        <!-- wp:paragraph {"className":"testimonial-role"} -->
                        <p class="testimonial-role">Business Owner</p>
                        <!-- /wp:paragraph -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:group -->
                
                <!-- wp:paragraph {"className":"testimonial-rating"} -->
                <p class="testimonial-rating">★★★★☆</p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->
            
        </div>
        <!-- /wp:group -->
        
        <!-- Slider Navigation -->
        <div class="testimonial-swiper-button-prev"></div>
        <div class="testimonial-swiper-button-next"></div>
        <div class="testimonial-swiper-pagination"></div>
    </div>
    <!-- /wp:group -->
    
</div>
<!-- /wp:group -->
CONTENT;

register_block_pattern(
    'couponx/testimonial-slider-section',
    array(
        'title'       => esc_html__('Testimonial Slider Section', 'couponx'),
        'description' => esc_html__('Full-width testimonial slider with section header and navigation', 'couponx'),
        'content'     => $content,
        'categories'  => array('couponx'),
    )
);
