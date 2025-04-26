<?php
/**
 * Full-width Hero
 * Title: Hero Section
 * Slug: couponx/hero-section
 * Categories: couponx
 */
$content = <<<CONTENT
<!-- wp:cover {"url":"' . esc_url(get_template_directory_uri()) . '/assets/images/hero-bg.jpg","dimRatio":30,"minHeight":600,"align":"full","className":"couponx-hero"} -->
<div class="wp-block-cover alignfull has-background-dim couponx-hero" style="min-height:600px">
    <div class="wp-block-cover__inner-container">
        <!-- wp:heading {"textAlign":"center","level":1,"style":{"color":{"text":"#ffffff"},"typography":{"fontSize":"4rem"}}} -->
        <h1 class="has-text-align-center has-text-color" style="color:#ffffff;font-size:4rem">Find Your Perfect Coupon</h1>
        <!-- /wp:heading -->
        
        <!-- wp:search {"label":"","showLabel":false,"placeholder":"Search 10,000+ Deals...","width":75,"align":"center","buttonText":"Search","buttonPosition":"button-outside","className":"is-style-hero-search"} /-->
        
        <!-- wp:group {"align":"center","layout":{"type":"flex","justifyContent":"center"} -->
        <div class="wp-block-group aligncenter">
            <!-- wp:image {"sizeSlug":"thumbnail","className":"trust-badge"} -->
            <figure class="wp-block-image size-thumbnail trust-badge">
                <img src="' . esc_url(get_template_directory_uri()) . '/assets/images/secure-badge.png" alt="Secure"/>
            </figure>
            <!-- /wp:image -->
            <!-- wp:paragraph {"style":{"color":{"text":"#ffffff"}}} -->
            <p class="has-text-color" style="color:#ffffff">Trusted by 500,000+ Shoppers</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->
    </div>
</div>
<!-- /wp:cover -->
CONTENT;

register_block_pattern(
    'couponx/hero-section',
    array(
        'title'       => esc_html__('Hero Section', 'couponx'),
        'description' => esc_html__('Full-width hero section with search and trust badges', 'couponx'),
        'content'     => $content,
        'categories'  => array('couponx'),
    )
);