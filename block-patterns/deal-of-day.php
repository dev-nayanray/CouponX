<?php
/**
 * Deal of the Day - Modern Premium Version with FSE Support
 * Title: Modern Deal of the Day (FSE)
 * Slug: couponx/modern-deal-of-day-fse
 * Categories: couponx
 */

// Enqueue assets with corrected file paths
function couponx_deal_of_day_assets() {
    wp_enqueue_style(
        'couponx-deal-of-day',
        get_template_directory_uri() . '/assets/css/deal-of-day.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/deal-of-day.css')
    );
    
    wp_enqueue_script(
        'couponx-countdown',
        get_template_directory_uri() . '/assets/js/countdown.js',
        array(),
        filemtime(get_template_directory() . '/assets/js/countdowns.js'), // Fixed typo in filename
        true
    );
}
add_action('wp_enqueue_scripts', 'couponx_deal_of_day_assets');

$content = <<<CONTENT
<!-- wp:group {"align":"full","className":"deal-of-day-modern-fse","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull deal-of-day-modern-fse">
    
    <!-- wp:cover {"dimRatio":50,"overlayColor":"dark","minHeight":100,"minHeightUnit":"vh","isDark":false,"align":"full","style":{"color":{"duotone":"unset"}}} -->
    <div class="wp-block-cover alignfull is-light has-custom-content-position has-dark-background-color has-background-dim" style="min-height:100vh">
        <div class="wp-block-cover__inner-container">
            
            <!-- wp:group {"className":"deal-content","layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
            <div class="wp-block-group deal-content">
                
                <!-- wp:heading {"textAlign":"center","level":1,"className":"deal-title","fontSize":"xx-large"} -->
                <h1 class="has-text-align-center deal-title has-xx-large-font-size">Limited Time Offer</h1>
                <!-- /wp:heading -->
                
                <!-- wp:paragraph {"align":"center","className":"deal-subtitle","fontSize":"large"} -->
                <p class="has-text-align-center deal-subtitle has-large-font-size">Don't miss out on this exclusive deal!</p>
                <!-- /wp:paragraph -->
                
                <!-- wp:countdown {"align":"center","dateTime":"2024-12-31","className":"modern-countdown-fse","style":{"color":{"background":"var(--wp--preset--color--accent)","text":"var(--wp--preset--color--light)"}}} -->
                <div class="wp-block-countdown aligncenter modern-countdown-fse" data-date="2024-12-31T23:59:59">
                    <div class="countdown-container">
                        <div class="countdown-item">
                            <span class="days">00</span>
                            <span class="countdown-label">Days</span>
                        </div>
                        <div class="countdown-separator">:</div>
                        <div class="countdown-item">
                            <span class="hours">00</span>
                            <span class="countdown-label">Hours</span>
                        </div>
                        <div class="countdown-separator">:</div>
                        <div class="countdown-item">
                            <span class="minutes">00</span>
                            <span class="countdown-label">Minutes</span>
                        </div>
                        <div class="countdown-separator">:</div>
                        <div class="countdown-item">
                            <span class="seconds">00</span>
                            <span class="countdown-label">Seconds</span>
                        </div>
                    </div>
                </div>
                <!-- /wp:countdown -->
                
                <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
                <div class="wp-block-buttons">
                    <!-- wp:button {"className":"deal-cta-fse","style":{"color":{"text":"var(--wp--preset--color--light)","background":"var(--wp--preset--color--primary)"}}} -->
                    <div class="wp-block-button deal-cta-fse">
                        <a class="wp-block-button__link has-light-color has-primary-background-color has-text-color has-background wp-element-button">Claim Offer Now</a>
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
    'couponx/modern-deal-of-day-fse',
    array(
        'title'       => esc_html__('Modern Deal of the Day (FSE)', 'couponx'),
        'description' => esc_html__('Full-screen animated countdown section with FSE support and dynamic background', 'couponx'),
        'content'     => $content,
        'categories'  => array('couponx'),
    )
);