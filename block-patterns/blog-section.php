<?php
/**
 * Title: Premium Blog Grid - Modern Elegance
 * Slug: couponx/premium-blog-grid-modern
 * Categories: couponx
 */
$content = <<<CONTENT
<!-- wp:group {"align":"wide","className":"premium-blog-grid","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}}} -->
<div class="wp-block-group alignwide premium-blog-grid">

    <!-- wp:heading {"textAlign":"center","level":2,"className":"section-heading","fontSize":"xx-large","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|50"}}}} -->
    <h2 class="has-text-align-center section-heading has-xx-large-font-size">Savings &amp; Lifestyle Insights</h2>
    <!-- /wp:heading -->

    <!-- wp:query {"queryId":3,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"displayLayout":{"type":"flex","columns":3},"align":"wide","className":"modern-grid-layout"} -->
    <div class="wp-block-query alignwide modern-grid-layout">
        <!-- wp:post-template -->

        <!-- wp:group {"className":"post-card hover-effect","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"0","right":"0","bottom":"0","left":"0"},"blockGap":"0"},"border":{"radius":"12px"},"backgroundColor":"base"} -->
        <div class="wp-block-group post-card hover-effect has-base-background-color has-background" style="border-radius:12px">
            
            <!-- wp:group {"className":"card-media-wrapper","layout":{"type":"constrained"},"style":{"spacing":{"margin":{"bottom":"0"}}}} -->
            <div class="wp-block-group card-media-wrapper">
                <!-- wp:post-featured-image {"isLink":true,"className":"card-image aspect-ratio-4-3","style":{"border":{"radius":"12px 12px 0 0"}},"sizeSlug":"large"} /-->
                
                <!-- wp:group {"className":"category-badge","layout":{"type":"flex","flexWrap":"nowrap"},"style":{"spacing":{"blockGap":"8px"}}} -->
                <div class="wp-block-group category-badge">
                    <!-- wp:post-terms {"term":"category","className":"is-style-pill","fontSize":"xs","separator":""} /-->
                </div>
                <!-- /wp:group -->
                
                <!-- wp:group {"className":"image-overlay","layout":{"type":"default"}} -->
                <div class="wp-block-group image-overlay"></div>
                <!-- /wp:group -->
            </div>
            <!-- /wp:group -->

            <!-- wp:group {"className":"card-content","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|30","right":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|30"}}}} -->
            <div class="wp-block-group card-content">
                <!-- wp:post-date {"format":"M j, Y","className":"post-date","fontSize":"xs","fontFamily":"secondary"} /-->
                
                <!-- wp:post-title {"level":3,"isLink":true,"className":"post-title","fontSize":"large","fontFamily":"primary"} /-->
                
                <!-- wp:post-excerpt {"moreText":"Continue Reading","excerptLength":18,"className":"post-excerpt","fontSize":"medium","fontFamily":"secondary"} /-->
                
                <!-- wp:separator {"className":"divider","style":{"color":{"background":"#e5e7eb"},"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}} -->
                <hr class="wp-block-separator has-text-color has-alpha-channel-opacity divider has-background" style="background-color:#e5e7eb;color:#e5e7eb;margin-top:var(--wp--preset--spacing--20);margin-bottom:var(--wp--preset--spacing--20)"/>
                <!-- /wp:separator -->
                
                <!-- wp:group {"className":"post-meta","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
                <div class="wp-block-group post-meta">
                    <!-- wp:post-author {"showAvatar":false,"className":"author-name","fontSize":"xs"} /-->
                    <!-- wp:paragraph {"className":"reading-time","fontSize":"xs"} -->
                    <p class="reading-time has-xs-font-size">5 min read</p>
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

</div>
<!-- /wp:group -->

<!-- wp:html -->
<style>
.premium-blog-grid {
    --primary-color: #4f46e5;
    --gradient-overlay: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.6) 100%);
    --transition-speed: 0.3s;
}

.post-card {
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    transition: transform var(--transition-speed) ease, box-shadow var(--transition-speed) ease;
}

.post-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15);
}

.card-image {
    position: relative;
    overflow: hidden;
    transform: scale(1);
    transition: transform var(--transition-speed) ease;
}

.post-card:hover .card-image {
    transform: scale(1.05);
}

.image-overlay {
    position: absolute;
    inset: 0;
    background: var(--gradient-overlay);
    opacity: 0.8;
}

.category-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
    z-index: 10;
}

.wp-block-post-terms.is-style-pill a {
    display: inline-block;
    background: var(--primary-color);
    color: white !important;
    padding: 0.25rem 0.75rem;
    border-radius: 999px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-size: 0.75rem;
}

.post-date {
    color: #6b7280;
    margin-bottom: 0.5rem;
}

.post-title a {
    color: #1f2937;
    text-decoration: none;
    transition: color var(--transition-speed) ease;
}

.post-title a:hover {
    color: var(--primary-color);
}

.post-excerpt {
    color: #4b5563;
    line-height: 1.6;
}

.divider {
    height: 1px;
}

.reading-time {
    color: #6b7280;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

@media (max-width: 768px) {
    .modern-grid-layout {
        grid-template-columns: 1fr !important;
    }
}
</style>
 
<!-- /wp:html -->
CONTENT;


register_block_pattern(
    'couponx/premium-blog-grid-modern',
    array(
        'title'       => esc_html__('Premium Blog Grid - Modern Elegance', 'couponx'),
        'description' => esc_html__('A sophisticated blog grid with dynamic hover effects, gradient overlays, and modern metadata display', 'couponx'),
        'content'     => $content,
        'categories'  => array('couponx'),
    )
);