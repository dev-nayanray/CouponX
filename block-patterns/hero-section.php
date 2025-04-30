<?php
/**
 * Modern Gradient Hero
 * Title: Modern Animated Hero
 * Slug: couponx/modern-hero
 * Categories: couponx
 */
$hero_content = <<<CONTENT
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"100px","bottom":"100px"}},"color":{"gradient":"linear-gradient(135deg,rgb(0,102,204) 0%,rgb(204,0,153) 100%)"}},"className":"modern-hero","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull modern-hero has-background" style="background:linear-gradient(135deg,rgb(0,102,204) 0%,rgb(204,0,153) 100%);padding-top:100px;padding-bottom:100px">
    <div class="wp-block-group__inner-container">
        <!-- wp:heading {"textAlign":"center","level":1,"style":{"color":{"text":"#ffffff"},"typography":{"fontSize":"4.5rem","lineHeight":"1.2"},"elements":{"link":{"color":{"text":"var:preset|color|background"}}}},"className":"animate-pop"} -->
        <h1 class="has-text-align-center has-text-color animate-pop" style="color:#ffffff;font-size:4.5rem;line-height:1.2">Unlock Exclusive<br>Deals &amp; Discounts</h1>
        <!-- /wp:heading -->
        
        <!-- wp:search {"label":"","showLabel":false,"placeholder":"Search 15,000+ Offers...","width":75,"align":"center","buttonText":"Find Deals","buttonPosition":"button-outside","className":"is-style-modern-search","backgroundColor":"white","textColor":"dark"} /-->
        
        <!-- wp:group {"align":"center","layout":{"type":"flex","justifyContent":"center","orientation":"horizontal"},"style":{"spacing":{"blockGap":"20px"}}} -->
        <div class="wp-block-group aligncenter">
            <!-- wp:image {"sizeSlug":"full","className":"trust-badge shimmer"} -->
            <figure class="wp-block-image size-full trust-badge shimmer">
                <img src="' . esc_url(get_template_directory_uri()) . '/assets/images/trust-badge.png" alt="Verified"/>
            </figure>
            <!-- /wp:image -->
            <!-- wp:paragraph {"style":{"color":{"text":"#ffffff"},"typography":{"fontSize":"1.1rem"}} -->
            <p class="has-text-color" style="color:#ffffff;font-size:1.1rem">Trusted by 1M+ Users Worldwide · 24/7 Support</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->
    </div>
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"hero-stats","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull hero-stats">
    <!-- wp:columns {"align":"wide"} -->
    <div class="wp-block-columns alignwide">
        <!-- wp:column {"backgroundColor":"white","className":"stat-box shadow-pop"} -->
        <div class="wp-block-column stat-box shadow-pop has-white-background-color has-background">
            <!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"2.5rem"},"color":{"text":"#2b2b2b"}}} -->
            <h3 class="has-text-align-center has-text-color" style="color:#2b2b2b;font-size:2.5rem">500K+</h3>
            <!-- /wp:heading -->
            <!-- wp:paragraph {"align":"center","style":{"color":{"text":"#666"},"typography":{"fontSize":"1rem"}}} -->
            <p class="has-text-align-center has-text-color" style="color:#666;font-size:1rem">Monthly Savings</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:column -->
        
        <!-- wp:column {"backgroundColor":"white","className":"stat-box shadow-pop"} -->
        <div class="wp-block-column stat-box shadow-pop has-white-background-color has-background">
            <!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"2.5rem"},"color":{"text":"#2b2b2b"}}} -->
            <h3 class="has-text-align-center has-text-color" style="color:#2b2b2b;font-size:2.5rem">10K+</h3>
            <!-- /wp:heading -->
            <!-- wp:paragraph {"align":"center","style":{"color":{"text":"#666"},"typography":{"fontSize":"1rem"}}} -->
            <p class="has-text-align-center has-text-color" style="color:#666;font-size:1rem">Active Deals</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:column -->
        
        <!-- wp:column {"backgroundColor":"white","className":"stat-box shadow-pop"} -->
        <div class="wp-block-column stat-box shadow-pop has-white-background-color has-background">
            <!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"2.5rem"},"color":{"text":"#2b2b2b"}}} -->
            <h3 class="has-text-align-center has-text-color" style="color:#2b2b2b;font-size:2.5rem">95%</h3>
            <!-- /wp:heading -->
            <!-- wp:paragraph {"align":"center","style":{"color":{"text":"#666"},"typography":{"fontSize":"1rem"}}} -->
            <p class="has-text-align-center has-text-color" style="color:#666;font-size:1rem">Success Rate</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->
CONTENT;

register_block_pattern(
    'couponx/modern-hero',
    array(
        'title'       => esc_html__('Modern Animated Hero', 'couponx'),
        'description' => esc_html__('Modern hero section with gradient background, animated elements, and statistics', 'couponx'),
        'content'     => $hero_content,
        'categories'  => array('couponx'),
    )
);

/**
 * Premium Deals Carousel
 * Title: Deals Carousel
 * Slug: couponx/deals-carousel
 * Categories: couponx
 */
$carousel_content = <<<CONTENT
<!-- wp:group {"align":"full","className":"premium-carousel","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull premium-carousel">
    <!-- wp:heading {"textAlign":"center","style":{"spacing":{"margin":{"bottom":"40px"}},"fontSize":"xl"} -->
    <h2 class="has-text-align-center has-xl-font-size" style="margin-bottom:40px">Today's Top Deals</h2>
    <!-- /wp:heading -->
    
    <!-- wp:html -->
    <div class="swiper-container premium-deals-carousel">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="deal-card">
                    <div class="deal-badge">50% OFF</div>
                    <img src="' . esc_url(get_template_directory_uri()) . '/assets/images/deal-1.jpg" alt="Deal">
                    <div class="deal-content">
                        <h3>Premium Fashion Store</h3>
                        <p class="expires">Expires in 2 days</p>
                        <div class="deal-cta">
                            <a href="#" class="wp-block-button__link">Get Code</a>
                            <span class="used">1.2k used</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="deal-card">
                    <div class="deal-badge">$100 Cashback</div>
                    <img src="' . esc_url(get_template_directory_uri()) . '/assets/images/deal-2.jpg" alt="Deal">
                    <div class="deal-content">
                        <h3>Electronics Mega Sale</h3>
                        <p class="expires">Limited Time Offer</p>
                        <div class="deal-cta">
                            <a href="#" class="wp-block-button__link">Shop Now</a>
                            <span class="used">890 used</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Navigation -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
    <!-- /wp:html -->
</div>
<!-- /wp:group -->
CONTENT;

register_block_pattern(
    'couponx/deals-carousel',
    array(
        'title'       => esc_html__('Premium Deals Carousel', 'couponx'),
        'description' => esc_html__('Premium swiper carousel with deal cards and interactive elements', 'couponx'),
        'content'     => $carousel_content,
        'categories'  => array('couponx'),
    )
);