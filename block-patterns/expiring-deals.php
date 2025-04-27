<?php
/**
 * Dynamic Premium Expiring Deals
 * Title: Dynamic Expiring Deals
 * Slug: couponx/dynamic-expiring-deals
 * Categories: couponx
 */
$content = <<<CONTENT
<!-- wp:group {"align":"wide","className":"dynamic-expiring-deals","style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"},"margin":{"top":"0","bottom":"0"}}} -->
<div class="wp-block-group alignwide dynamic-expiring-deals" style="margin-top:0;margin-bottom:0;padding-top:4rem;padding-bottom:4rem">
    
    <!-- wp:heading {"level":3,"className":"dynamic-section-title","fontSize":"xx-large"} -->
    <h3 class="dynamic-section-title has-xx-large-font-size">🔥 Hot Deals Expiring Soon!</h3>
    <!-- /wp:heading -->
    
    <!-- wp:table {"className":"dynamic-deals-table","backgroundColor":"accent"} -->
    <figure class="wp-block-table dynamic-deals-table has-accent-background-color has-background">
        <table class="has-accent-background-color has-background">
            <thead>
                <tr>
                    <th class="has-text-color">Store</th>
                    <th class="has-text-color">Deal</th>
                    <th class="has-text-color">Time Left</th>
                    <th class="has-text-color">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td data-store="Amazon">
                        <div class="store-brand">
                            <img src="https://cdn.example.com/amazon-logo.svg" class="store-logo" alt="Amazon" loading="lazy"/>
                            <span class="store-name">Amazon</span>
                        </div>
                    </td>
                    <td>🎉 50% Off Premium Electronics</td>
                    <td><div class="countdown-box" data-expires="2024-03-01T23:59:00"><span class="countdown"></span></div></td>
                    <td><button class="wp-element-button dynamic-code-reveal" data-code="SPRING50"><span class="dashicons dashicons-hidden"></span> Show Code</button></td>
                </tr>
                <!-- Add more rows -->
            </tbody>
        </table>
    </figure>
    <!-- /wp:table -->
    
    <!-- wp:paragraph {"align":"center","className":"dynamic-disclaimer"} -->
    <p class="has-text-align-center dynamic-disclaimer">🔄 Updates every minute • ⚡ Limited quantities</p>
    <!-- /wp:paragraph -->

</div>
<!-- /wp:group -->
CONTENT;

register_block_pattern(
    'couponx/dynamic-expiring-deals',
    array(
        'title'       => esc_html__('Dynamic Expiring Deals', 'couponx'),
        'description' => esc_html__('Interactive deals section with real-time countdowns and animated elements', 'couponx'),
        'content'     => $content,
        'categories'  => array('couponx'),
    )
);