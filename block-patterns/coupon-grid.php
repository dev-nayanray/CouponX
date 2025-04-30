<?php
/**
 * Coupons Grid Shortcode
 * Title: Modern Coupons Grid
 * Slug: couponx/modern-coupons-grid
 * Categories: couponx
 */

add_shortcode('couponx_coupons_grid', function($atts) {
    ob_start();
    
    $atts = shortcode_atts([
        'posts_per_page' => 12,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'show_expired'   => false,
        'currency'       => '$'
    ], $atts, 'couponx_coupons_grid');

    $args = [
        'post_type'      => 'coupon',
        'posts_per_page' => $atts['posts_per_page'],
        'orderby'        => $atts['orderby'],
        'order'          => $atts['order'],
        'meta_query'     => []
    ];

    if (!$atts['show_expired']) {
        $args['meta_query'][] = [
            'relation' => 'OR',
            [
                'key'     => '_couponx_expiry',
                'value'   => date('Y-m-d'),
                'compare' => '>=',
                'type'    => 'DATE'
            ],
            [
                'key'     => '_couponx_expiry',
                'compare' => 'NOT EXISTS'
            ]
        ];
    }

    $coupons = new WP_Query($args);

    if ($coupons->have_posts()) : ?>
    <div class="cx-coupons-grid">
        <?php while ($coupons->have_posts()) : $coupons->the_post();
            // Get all meta values
            $coupon_meta = [
                'code'              => get_post_meta(get_the_ID(), '_couponx_code', true),
                'expiry'            => get_post_meta(get_the_ID(), '_couponx_expiry', true),
                'deal_code'         => get_post_meta(get_the_ID(), '_deal_code', true),
                'printable'         => get_post_meta(get_the_ID(), '_printable', true),
                'rating'            => get_post_meta(get_the_ID(), '_rating', true),
                'discount_type'     => get_post_meta(get_the_ID(), '_discount_type', true),
                'discount_value'    => get_post_meta(get_the_ID(), '_discount_value', true),
                'affiliate_url'    => get_post_meta(get_the_ID(), '_affiliate_url', true),
                'store_link'        => get_post_meta(get_the_ID(), '_store_link', true),
                'usage_limit'      => get_post_meta(get_the_ID(), '_usage_limit', true),
                'minimum_purchase'  => get_post_meta(get_the_ID(), '_minimum_purchase', true),
                'new_customers'     => get_post_meta(get_the_ID(), '_new_customers_only', true),
                'coupon_image'      => get_post_meta(get_the_ID(), '_coupon_image', true),
            ];
            
            // Additional data
            $store_terms = get_the_terms(get_the_ID(), 'store');
            $categories = get_the_terms(get_the_ID(), 'coupon_category');
            $store_image = ($store_terms && !is_wp_error($store_terms)) ? 
                get_term_meta($store_terms[0]->term_id, 'taxonomy_image_url', true) : '';
            $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
            $coupon_image = wp_get_attachment_url($coupon_meta['coupon_image']);
            $is_expired = $coupon_meta['expiry'] && strtotime($coupon_meta['expiry']) < time();
            $currency_symbol = function_exists('get_woocommerce_currency_symbol') ? 
        get_woocommerce_currency_symbol() : 
        $atts['currency'];

            
        ?>
        <article class="cx-coupon-card <?php echo $is_expired ? 'cx-expired' : ''; ?>">
            <div class="cx-coupon-card-inner">
                <?php if ($is_expired) : ?>
                <div class="cx-coupon-expired-banner"><?php _e('Expired', 'couponx'); ?></div>
                <?php endif; ?>

                <div class="cx-coupon-media">
                    <?php if ($coupon_image) : ?>
                    <img src="<?php echo esc_url($coupon_image); ?>" 
                         alt="<?php the_title_attribute(); ?>" 
                         class="cx-coupon-img"
                         loading="lazy" />
                    <?php elseif ($featured_image) : ?>
                    <img src="<?php echo esc_url($featured_image); ?>" 
                         alt="<?php the_title_attribute(); ?>" 
                         class="cx-featured-img"
                         loading="lazy" />
                    <?php endif; ?>
                </div>

                <header class="cx-coupon-header">
                    <?php if ($store_image) : ?>
                    <div class="cx-store-brand">
                        <img src="<?php echo esc_url($store_image); ?>" 
                             alt="<?php echo esc_attr($store_terms[0]->name); ?>" 
                             class="cx-store-logo" 
                             loading="lazy"
                             width="80"
                             height="40" />
                        <div class="cx-store-info">
                            <?php if ($store_terms) : ?>
                            <span class="cx-store-name"><?php echo esc_html($store_terms[0]->name); ?></span>
                            <?php endif; ?>
                            <?php if ($coupon_meta['rating']) : ?>
                            <div class="cx-coupon-rating">
                                <?php echo str_repeat('<span class="cx-star">★</span>', absint($coupon_meta['rating'])); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </header>

                <div class="cx-coupon-body">
                    <div class="cx-coupon-meta">
                         <?php if ($coupon_meta['discount_type'] && $coupon_meta['discount_value']) : ?>
    <div class="cx-discount-badge">
        <?php echo ($coupon_meta['discount_type'] === 'percentage') ? 
            esc_html($coupon_meta['discount_value']) . '%' : 
            esc_html($currency_symbol) . esc_html($coupon_meta['discount_value']); ?>
    </div>
    <?php endif; ?>

                        <div class="cx-additional-meta">
                            <?php if ($coupon_meta['expiry']) : ?>
                            <div class="cx-meta-item">
                                <svg class="cx-icon" viewBox="0 0 24 24">
                                    <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.2 3.2.8-1.3-4.5-2.7V7z"/>
                                </svg>
                                <span><?php echo date_i18n(get_option('date_format'), strtotime($coupon_meta['expiry'])); ?></span>
                            </div>
                            <?php endif; ?>

                            <?php if ($coupon_meta['usage_limit']) : ?>
                            <div class="cx-meta-item">
                                <svg class="cx-icon" viewBox="0 0 24 24">
                                    <path d="M16 13h-3V3h-2v10H8l4 4 4-4zM4 19v2h16v-2H4z"/>
                                </svg>
                                <span><?php printf(__('Uses Left: %d', 'couponx'), absint($coupon_meta['usage_limit'])); ?></span>
                            </div>
                            <?php endif; ?>

                             <?php if ($coupon_meta['minimum_purchase']) : ?>
    <div class="cx-meta-item">
        <!-- ... -->
        <span><?php printf(__('Min. Spend: %s', 'couponx'), 
            esc_html($currency_symbol) . number_format_i18n($coupon_meta['minimum_purchase'], 2)); ?></span>
    </div>
    <?php endif; ?>
                        </div>
                    </div>

                    <h3 class="cx-coupon-title"><?php the_title(); ?></h3>
                    
                    <?php if ($coupon_meta['new_customers'] === 'on') : ?>
                    <div class="cx-new-customer-badge"><?php _e('New Customers Only', 'couponx'); ?></div>
                    <?php endif; ?>

                    <div class="cx-coupon-excerpt"><?php the_excerpt(); ?></div>
                </div>

                <footer class="cx-coupon-footer">
                    <div class="cx-coupon-actions">
                        <?php if ($coupon_meta['code']) : ?>
                        <div class="cx-code-container">
                            <code class="cx-coupon-code"><?php echo esc_html($coupon_meta['code']); ?></code>
                            <button class="cx-copy-code" data-clipboard-text="<?php echo esc_attr($coupon_meta['code']); ?>">
                                <?php _e('Copy Code', 'couponx'); ?>
                            </button>
                        </div>
                        <?php elseif ($coupon_meta['deal_code']) : ?>
                        <div class="cx-deal-container">
                            <span class="cx-deal-code"><?php echo esc_html($coupon_meta['deal_code']); ?></span>
                        </div>
                        <?php endif; ?>

                        <div class="cx-button-group">
                            <?php if ($coupon_meta['printable'] === 'on') : ?>
                            <a href="<?php echo esc_url($coupon_image ?: get_permalink()); ?>" 
                               class="cx-print-button"
                               target="_blank"
                               rel="noopener">
                                <?php _e('Print Coupon', 'couponx'); ?>
                            </a>
                            <?php endif; ?>

                            <a href="<?php echo esc_url($coupon_meta['affiliate_url'] ?: $coupon_meta['store_link'] ?: get_permalink()); ?>" 
                               class="cx-deal-button"
                               target="_blank"
                               rel="noopener">
                                <?php _e('Get Deal', 'couponx'); ?>
                                <svg class="cx-arrow" viewBox="0 0 24 24">
                                    <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </footer>
            </div>
        </article>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <?php else : ?>
        <p class="cx-no-coupons"><?php _e('No coupons found.', 'couponx'); ?></p>
    <?php endif;
    
    return ob_get_clean();
});

// Register block pattern
register_block_pattern(
    'couponx/modern-coupons-grid',
    [
        'title'       => esc_html__('Modern Coupons Grid', 'couponx'),
        'description' => esc_html__('Responsive grid of coupons with store branding and code copying', 'couponx'),
        'content'     => '<!-- wp:group {"align":"wide","className":"couponx-coupons-grid-wrapper","layout":{"type":"constrained"}} -->
                        <div class="wp-block-group alignwide couponx-coupons-grid-wrapper">
                            <!-- wp:heading {"level":3,"className":"cx-section-heading"} -->
                            <h3 class="wp-block-heading cx-section-heading">' . esc_html__('Latest Coupons & Deals', 'couponx') . '</h3>
                            <!-- /wp:heading -->
                            
                            <!-- wp:shortcode -->
                            [couponx_coupons_grid]
                            <!-- /wp:shortcode -->
                        </div>
                        <!-- /wp:group -->',
        'categories'  => ['couponx'],
    ]
);

// Enqueue assets
add_action('wp_enqueue_scripts', function() {
    if (!is_admin()) {
        // Clipboard.js
        wp_enqueue_script(
            'clipboard', 
            'https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js', 
            [], 
            '2.0.11', 
            true
        );
        
        // Initialize clipboard
        wp_add_inline_script('clipboard', '
            new ClipboardJS(".cx-copy-code").on("success", function(e) {
                const btn = e.trigger;
                const originalText = btn.innerText;
                btn.innerText = "'.esc_attr__('Copied!', 'couponx').'";
                setTimeout(() => { btn.innerText = originalText; }, 2000);
            });
        ');
        
        // Grid styles
        wp_enqueue_style(
            'couponx-coupons-grid',
            get_theme_file_uri('assets/css/coupons-grid.css'),
            [],
            filemtime(get_theme_file_path('assets/css/coupons-grid.css'))
        );
    }
});
