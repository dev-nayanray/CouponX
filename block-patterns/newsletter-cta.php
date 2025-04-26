<?php
/**
 * Newsletter Signup
 * Title: Newsletter CTA
 * Slug: couponx/newsletter-cta
 * Categories: couponx
 */
$content = <<<CONTENT
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}},"color":{"background":"#1a1a1a"}} -->
<div class="wp-block-group alignfull has-background" style="background-color:#1a1a1a;padding-top:4rem;padding-bottom:4rem">
    <!-- wp:columns {"align":"wide"} -->
    <div class="wp-block-columns alignwide">
        <!-- wp:column {"width":"60%"} -->
        <div class="wp-block-column" style="flex-basis:60%">
            <!-- wp:heading {"textColor":"white"} -->
            <h2 class="has-white-color has-text-color">Get Exclusive Deals First!</h2>
            <!-- /wp:heading -->
            <!-- wp:paragraph {"textColor":"white"} -->
            <p class="has-white-color has-text-color">Join 100,000+ subscribers for daily coupon alerts</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:column -->
        
        <!-- wp:column {"width":"40%"} -->
        <div class="wp-block-column" style="flex-basis:40%">
            <!-- wp:jetpack/mailchimp {"borderColor":"accent","buttonBackgroundColor":"accent","textColor":"light"} -->
            <div class="wp-block-jetpack-mailchimp">[jetpack_subscription_form]</div>
            <!-- /wp:jetpack/mailchimp -->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->
CONTENT;

register_block_pattern(
    'couponx/newsletter-cta',
    array(
        'title'       => esc_html__('Newsletter CTA', 'couponx'),
        'description' => esc_html__('Full-width newsletter signup section with dark background', 'couponx'),
        'content'     => $content,
        'categories'  => array('couponx'),
    )
);