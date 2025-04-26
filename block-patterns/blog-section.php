<?php
/**
 * Blog Posts Grid - Premium Modern Cards
 * Title: Premium Modern Blog Grid
 * Slug: couponx/premium-modern-blog-grid
 * Categories: couponx
 */
$content = <<<CONTENT
<!-- wp:group {"align":"wide","className":"premium-blog-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide premium-blog-section">

    <!-- wp:heading {"textAlign":"center","level":2,"className":"section-heading","fontSize":"xx-large"} -->
    <h2 class="has-text-align-center section-heading has-xx-large-font-size">Money Saving Insights</h2>
    <!-- /wp:heading -->

    <!-- wp:query {"queryId":2,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"displayLayout":{"type":"flex","columns":3},"align":"wide","className":"modern-card-grid"} -->
    <div class="wp-block-query alignwide modern-card-grid">
        <!-- wp:post-template -->

        <!-- wp:group {"className":"post-card","layout":{"type":"constrained"}} -->
        <div class="wp-block-group post-card">
            <!-- wp:group {"className":"card-media","layout":{"type":"constrained"}} -->
            <div class="wp-block-group card-media">
                <!-- wp:post-featured-image {"isLink":true,"className":"card-image","style":{"spacing":{"padding":{"bottom":"0"},"margin":{"bottom":"0"}}}} /-->
                
                <!-- wp:post-terms {"term":"category","className":"post-category","separator":"","fontSize":"small"} /-->
                
                <!-- wp:group {"className":"image-overlay","layout":{"type":"default"}} -->
                <div class="wp-block-group image-overlay"></div>
                <!-- /wp:group -->
            </div>
            <!-- /wp:group -->

            <!-- wp:group {"className":"card-content","layout":{"type":"constrained"}} -->
            <div class="wp-block-group card-content">
                <!-- wp:post-title {"level":3,"isLink":true,"className":"post-title","fontSize":"x-large"} /-->
                
                <!-- wp:post-excerpt {"moreText":"Read More","excerptLength":20,"className":"post-excerpt","fontSize":"medium"} /-->
                
                <!-- wp:group {"className":"post-meta","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
                <div class="wp-block-group post-meta">
                    <!-- wp:post-date {"className":"post-date","fontSize":"small"} /-->
                    <!-- wp:paragraph {"className":"reading-time","fontSize":"small"} -->
                    <p class="reading-time has-small-font-size">⏳ 5 min read</p>
                    <!-- /wp:paragraph -->
                </div>
                <!-- /wp:group -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:group -->
        <!-- /wp:post-template -->
    </div>
    <!-- /wp:query -->

    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"className":"section-cta"} -->
    <div class="wp-block-buttons section-cta">
        <!-- wp:button {"className":"is-style-premium-cta"} -->
        <div class="wp-block-button is-style-premium-cta">
            <a class="wp-block-button__link wp-element-button">Discover More Strategies</a>
        </div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->

</div>
<!-- /wp:group -->
CONTENT;

register_block_pattern(
    'couponx/premium-modern-blog-grid',
    array(
        'title'       => esc_html__('Premium Modern Blog Grid', 'couponx'),
        'description' => esc_html__('Ultra-modern blog grid with gradient overlays, hover animations, and enhanced metadata', 'couponx'),
        'content'     => $content,
        'categories'  => array('couponx'),
    )
);