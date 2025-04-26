<?php
/**
 * Coupons Grid Shortcode
 * Title: Modern Coupons Grid
 * Slug: couponx/modern-coupons-grid
 * Categories: couponx
 */

// Register coupons grid shortcode
add_shortcode('couponx_coupons_grid', function($atts) {
    ob_start();
    
    // Shortcode attributes
    $atts = shortcode_atts([
        'posts_per_page' => 12,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'show_expired'   => false,
    ], $atts, 'couponx_coupons_grid');

    // Query arguments
    $args = [
        'post_type'      => 'coupon',
        'posts_per_page' => $atts['posts_per_page'],
        'orderby'        => $atts['orderby'],
        'order'          => $atts['order'],
        'meta_query'     => []
    ];

    // Handle expiration date
    if (!$atts['show_expired']) {
        $args['meta_query'][] = [
            'relation' => 'OR',
            [
                'key'     => 'expiration_date',
                'value'   => date('Y-m-d'),
                'compare' => '>=',
                'type'    => 'DATE'
            ],
            [
                'key'     => 'expiration_date',
                'compare' => 'NOT EXISTS'
            ]
        ];
    }

    $coupons = new WP_Query($args);

    if ($coupons->have_posts()) : ?>
    <div class="cx-coupons-grid">
        <?php while ($coupons->have_posts()) : $coupons->the_post();
            $coupon_code    = get_post_meta(get_the_ID(), 'coupon_code', true);
            $coupon_type    = get_post_meta(get_the_ID(), 'coupon_type', true);
            $expiration     = get_post_meta(get_the_ID(), 'expiration_date', true);
            $discount       = get_post_meta(get_the_ID(), 'discount_value', true);
            $store_terms    = get_the_terms(get_the_ID(), 'store');
            $categories     = get_the_terms(get_the_ID(), 'coupon_category');
            $store_image    = '';
            $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
            
            if ($store_terms && !is_wp_error($store_terms)) {
                $store_image = get_term_meta($store_terms[0]->term_id, 'taxonomy_image_url', true);
            }
        ?>
        <article class="cx-coupon-card cx-coupon-type-<?php echo esc_attr(strtolower($coupon_type)); ?>">
            <div class="cx-coupon-card-inner">
                <?php if ($expiration && strtotime($expiration) < time()) : ?>
                <div class="cx-coupon-expired-banner"><?php _e('Expired', 'couponx'); ?></div>
                <?php endif; ?>
                
                <?php if ($featured_image) : ?>
                <div class="cx-coupon-featured-image">
                    <img src="<?php echo esc_url($featured_image); ?>" 
                         alt="<?php the_title_attribute(); ?>" 
                         loading="lazy"
                         class="cx-featured-img" />
                </div>
                <?php endif; ?>

                <header class="cx-coupon-header">
                    <?php if ($store_image) : ?>
                    <div class="cx-store-brand">
                        <img src="<?php echo esc_url($store_image); ?>" 
                             alt="<?php echo esc_attr($store_terms[0]->name); ?>" 
                             class="cx-store-logo" 
                             loading="lazy"
                             width="120"
                             height="60" />
                        <div class="cx-store-info">
                            <?php if ($store_terms) : ?>
                            <span class="cx-store-name"><?php echo esc_html($store_terms[0]->name); ?></span>
                            <?php endif; ?>
                            <?php if ($categories) : ?>
                            <div class="cx-coupon-categories">
                                <?php foreach ($categories as $category) : ?>
                                <span class="cx-category-badge"><?php echo esc_html($category->name); ?></span>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </header>

                <div class="cx-coupon-body">
                    <div class="cx-coupon-meta">
                        <?php if ($coupon_type) : ?>
                        <span class="cx-coupon-type-badge"><?php echo esc_html($coupon_type); ?></span>
                        <?php endif; ?>
                        
                        <div class="cx-additional-meta">
                            <?php if ($discount) : ?>
                            <div class="cx-discount-badge">
                                <svg class="cx-icon" viewBox="0 0 24 24" width="16" height="16">
                                    <path d="M12.79 21L3 11.21v2c0 .53.21 1.04.59 1.41l7.79 7.79c.78.78 2.05.78 2.83 0l6.21-6.21c.78-.78.78-2.05 0-2.83L12.79 21z"/>
                                    <path d="M3 5v6c0 .53.21 1.04.59 1.41l7.79 7.79c.78.78 2.05.78 2.83 0l6.21-6.21c.78-.78.78-2.05 0-2.83L12.79 3 4.59 11.21c-.38.37-.59.88-.59 1.41z"/>
                                </svg>
                                <?php echo esc_html($discount); ?>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($expiration) : ?>
                            <div class="cx-coupon-expiry">
                                <svg class="cx-icon" viewBox="0 0 24 24" width="16" height="16">
                                    <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.2 3.2.8-1.3-4.5-2.7V7z"/>
                                </svg>
                                <time><?php echo date_i18n(get_option('date_format'), strtotime($expiration)); ?></time>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <h3 class="cx-coupon-title"><?php the_title(); ?></h3>
                    
                    <div class="cx-coupon-excerpt"><?php the_excerpt(); ?></div>
                </div>

                <footer class="cx-coupon-footer">
                    <?php if ($coupon_code) : ?>
                    <div class="cx-coupon-code-wrapper">
                        <div class="cx-coupon-code-container">
                            <code class="cx-coupon-code"><?php echo esc_html($coupon_code); ?></code>
                            <button class="cx-copy-code" data-clipboard-text="<?php echo esc_attr($coupon_code); ?>">
                                <svg class="cx-icon" viewBox="0 0 24 24" width="18" height="18">
                                    <path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/>
                                </svg>
                                <span class="cx-copy-text"><?php _e('Copy', 'couponx'); ?></span>
                            </button>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <a href="<?php the_permalink(); ?>" class="cx-coupon-link">
                        <?php _e('View Deal', 'couponx'); ?>
                        <svg class="cx-arrow" viewBox="0 0 24 24" width="16" height="16">
                            <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                        </svg>
                    </a>
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
