<?php
/**
 * Premium Coupon Display System
 * Includes Carousel and Grid layouts with advanced features
 */

// 1. MAIN CAROUSEL SHORTCODE
add_shortcode('premium_coupon_carousel', function($atts) {
    ob_start();
    
    // Validate and sanitize shortcode attributes
    $atts = shortcode_atts([
        'posts_per_page'  => 8,
        'orderby'         => 'date',
        'order'           => 'DESC',
        'show_expired'    => false,
        'autoplay'        => 5000,
        'slides_per_view' => 3,
        'show_arrows'     => true,
        'show_pagination' => true,
        'loop'            => true,
        'store'           => '' // New filter attribute
    ], $atts, 'premium_coupon_carousel');

    // Base query arguments
    $args = [
        'post_type'      => 'coupon',
        'posts_per_page' => absint($atts['posts_per_page']),
        'orderby'        => sanitize_key($atts['orderby']),
        'order'          => sanitize_key($atts['order']),
        'meta_query'     => []
    ];

    // Store filter
    if (!empty($atts['store'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'store',
            'field'    => 'slug',
            'terms'    => array_map('sanitize_title', explode(',', $atts['store']))
        ];
    }

    // Expiration handling
    if (!wp_validate_boolean($atts['show_expired'])) {
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
    <section class="premium-coupon-carousel swiper" 
         data-settings='<?php echo wp_json_encode([
            'autoplay' => absint($atts['autoplay']),
            'slides'   => absint($atts['slides_per_view']),
            'loop'     => wp_validate_boolean($atts['loop']),
            'arrows'   => wp_validate_boolean($atts['show_arrows']),
            'pagination' => wp_validate_boolean($atts['show_pagination'])
         ]); ?>'>
        
        <div class="swiper-wrapper">
            <?php while ($coupons->have_posts()) : $coupons->the_post();
                include locate_template('parts/coupon-card.php');
            endwhile; ?>
        </div>

        <?php if ($atts['show_pagination']) : ?>
        <div class="swiper-pagination"></div>
        <?php endif; ?>

        <?php if ($atts['show_arrows']) : ?>
        <div class="swiper-nav">
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
        <?php endif; ?>
    </section>
    <?php else : ?>
    <p class="no-coupons"><?php esc_html_e('No coupons available', 'couponx'); ?></p>
    <?php endif;
    
    wp_reset_postdata();
    return ob_get_clean();
});

// 2. GRID LAYOUT SHORTCODE
add_shortcode('premium_coupon_grid', function($atts) {
    ob_start();
    
    $atts = shortcode_atts([
        'posts_per_page' => 8,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'show_expired'   => false,
        'columns'        => 3,
        'gap'            => '30px',
        'store'          => ''
    ], $atts, 'premium_coupon_grid');

    $args = [
        'post_type'      => 'coupon',
        'posts_per_page' => absint($atts['posts_per_page']),
        'orderby'        => sanitize_key($atts['orderby']),
        'order'          => sanitize_key($atts['order']),
        'meta_query'     => []
    ];

    // Store filter
    if (!empty($atts['store'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'store',
            'field'    => 'slug',
            'terms'    => array_map('sanitize_title', explode(',', $atts['store']))
        ];
    }

    // Expiration handling
    if (!wp_validate_boolean($atts['show_expired'])) {
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
    <style>.premium-coupon-grid {--columns: <?php echo absint($atts['columns']); ?>; --gap: <?php echo esc_attr($atts['gap']); ?>;}</style>
    <div class="premium-coupon-grid">
        <?php while ($coupons->have_posts()) : $coupons->the_post();
            include locate_template('parts/coupon-card.php');
        endwhile; ?>
    </div>
    <?php else : ?>
    <p class="no-coupons"><?php esc_html_e('No coupons available', 'couponx'); ?></p>
    <?php endif;
    
    wp_reset_postdata();
    return ob_get_clean();
});

// 3. ASSET MANAGEMENT
add_action('wp_enqueue_scripts', function() {
    if (!is_admin()) {
        // Swiper CSS
        wp_enqueue_style(
            'swiper',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
            [],
            '11.0.5'
        );

        // Main CSS
        wp_enqueue_style(
            'couponx-premium',
            get_theme_file_uri('/assets/css/premium-coupons.css'),
            ['swiper'],
            filemtime(get_theme_file_path('/assets/css/premium-coupons.css'))
        );

        // Swiper JS
        wp_enqueue_script(
            'swiper',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
            [],
            '11.0.5',
            true
        );

        // Clipboard.js
        wp_enqueue_script(
            'clipboard',
            'https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js',
            [],
            '2.0.11',
            true
        );

        // Main JS
        wp_enqueue_script(
            'couponx-premium',
            get_theme_file_uri('/assets/js/premium-coupons.js'),
            ['swiper', 'clipboard'],
            filemtime(get_theme_file_path('/assets/js/premium-coupons.js')),
            true
        );

        // Localize script data
        wp_localize_script('couponx-premium', 'couponxSettings', [
            'copyText' => __('Copied!', 'couponx'),
            'failedCopy' => __('Failed to copy!', 'couponx')
        ]);
    }
});

// 4. BLOCK PATTERN REGISTRATION
register_block_pattern_category('couponx', [
    'label' => __('CouponX Elements', 'couponx')
]);

register_block_pattern('couponx/premium-carousel', [
    'title'       => esc_html__('Premium Coupon Carousel', 'couponx'),
    'description' => esc_html__('Responsive coupon carousel with swipe navigation', 'couponx'),
    'categories'  => ['couponx'],
    'content'     => '
        <!-- wp:group {"className":"premium-carousel-section","align":"wide"} -->
        <div class="wp-block-group premium-carousel-section alignwide">
            <!-- wp:shortcode -->
            [premium_coupon_carousel slides_per_view="3" show_arrows="true"]
            <!-- /wp:shortcode -->
        </div>
        <!-- /wp:group -->
    '
]);