<?php
/**
 * Deal of the Day - Premium Modern FSE Version
 * Title: Ultra Modern Deal of the Day (FSE)
 * Slug: couponx/modern-deal-of-day-fse-pro
 * Categories: couponx
 */

// Enqueue assets with version control
function couponx_deal_of_day_pro_assets() {
    wp_enqueue_style(
        'couponx-deal-of-day-pro',
        get_template_directory_uri() . '/assets/css/deal-of-day-pro.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/deal-of-day-pro.css')
    );
    
    wp_enqueue_script(
        'couponx-countdown-pro',
        get_template_directory_uri() . '/assets/js/countdown-pro.js',
        array('wp-element', 'wp-components'),
        filemtime(get_template_directory() . '/assets/js/countdown-pro.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'couponx_deal_of_day_pro_assets');

$content = <<<CONTENT
<!-- wp:group {"align":"full","className":"deal-pro","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}}} -->
<div class="wp-block-group alignfull deal-pro">
    
    <!-- wp:cover {"dimRatio":50,"minHeight":100,"minHeightUnit":"vh","isDark":false,"align":"full","style":{"color":{"gradient":"linear-gradient(135deg,rgb(15,12,41) 0%,rgb(48,43,99) 50%,rgb(36,36,62) 100%)"},"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}} -->
    <div class="wp-block-cover alignfull is-light has-custom-content-position" style="min-height:100vh;padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);background:linear-gradient(135deg,rgb(15,12,41) 0%,rgb(48,43,99) 50%,rgb(36,36,62) 100%)">
        <div class="wp-block-cover__inner-container">
            
            <!-- wp:group {"className":"deal-pro-content","layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
            <div class="wp-block-group deal-pro-content">
                
                <!-- wp:heading {"textAlign":"center","level":1,"className":"deal-pro-title","fontSize":"xxx-large"} -->
                <h1 class="has-text-align-center deal-pro-title has-xxx-large-font-size">Flash Sale</h1>
                <!-- /wp:heading -->
                
                <!-- wp:paragraph {"align":"center","className":"deal-pro-subtitle","fontSize":"medium"} -->
                <p class="has-text-align-center deal-pro-subtitle has-medium-font-size">Limited time offer ending in:</p>
                <!-- /wp:paragraph -->
                
                <!-- wp:countdown {"align":"center","dateTime":"2024-12-31","className":"deal-pro-countdown","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}}} -->
                <div class="wp-block-countdown aligncenter deal-pro-countdown" data-date="2024-12-31T23:59:59">
                    <div class="countdown-pro-container">
                        <div class="countdown-pro-item">
                            <div class="countdown-number days">00</div>
                            <div class="countdown-label">Days</div>
                        </div>
                        <div class="countdown-pro-separator">:</div>
                        <div class="countdown-pro-item">
                            <div class="countdown-number hours">00</div>
                            <div class="countdown-label">Hours</div>
                        </div>
                        <div class="countdown-pro-separator">:</div>
                        <div class="countdown-pro-item">
                            <div class="countdown-number minutes">00</div>
                            <div class="countdown-label">Minutes</div>
                        </div>
                        <div class="countdown-pro-separator">:</div>
                        <div class="countdown-pro-item">
                            <div class="countdown-number seconds">00</div>
                            <div class="countdown-label">Seconds</div>
                        </div>
                    </div>
                </div>
                <!-- /wp:countdown -->
                
                <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"blockGap":"var:preset|spacing|40"}}} -->
                <div class="wp-block-buttons">
                    <!-- wp:button {"className":"deal-pro-cta is-style-fill","style":{"color":{"text":"var(--wp--preset--color--light)","background":"var(--wp--preset--color--primary)"},"border":{"radius":"50px"},"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}}} -->
                    <div class="wp-block-button deal-pro-cta is-style-fill">
                        <a class="wp-block-button__link has-light-color has-primary-background-color has-text-color has-background wp-element-button" style="border-radius:50px;padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50)">Claim Exclusive Offer</a>
                    </div>
                    <!-- /wp:button -->
                </div>
                <!-- /wp:buttons -->
                
            </div>
            <!-- /wp:group -->
            
        </div>
    </div>
    <!-- /wp:cover -->
    
</div>
<!-- /wp:group -->
CONTENT;

register_block_pattern(
    'couponx/modern-deal-of-day-fse-pro',
    array(
        'title'       => esc_html__('Ultra Modern Deal of the Day (FSE Pro)', 'couponx'),
        'description' => esc_html__('Premium full-screen animated countdown with dynamic gradients and micro-interactions', 'couponx'),
        'content'     => $content,
        'categories'  => array('couponx'),
    )
);
