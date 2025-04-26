<?php
/**
 * Dynamic Categories Grid with Coupons
 * Title: Modern Categories Grid
 * Slug: couponx/modern-categories-grid
 * Categories: couponx
 */

// Register custom shortcode for categories grid
add_shortcode('couponx_categories_grid', function() {
    ob_start();
    
    // Get all category terms
    $categories = get_terms([
        'taxonomy' => 'coupon_category',
        'hide_empty' => false,
        'orderby'    => 'count',
        'order'      => 'DESC',
    ]);
    
    if (!empty($categories) && !is_wp_error($categories)) : ?>
    <div class="cx-stores-grid"> <!-- Reusing same CSS classes -->
        <?php foreach ($categories as $category) :
            $category_image = get_term_meta($category->term_id, 'category_image', true);
            $category_url = get_term_link($category);
            $coupons = new WP_Query([
                'post_type'      => 'coupon',
                'posts_per_page' => 3,
                'tax_query'      => [[
                    'taxonomy' => 'coupon_category',
                    'field'    => 'term_id',
                    'terms'    => $category->term_id,
                ]],
                'meta_key'       => 'expiration_date',
                'meta_compare'   => '>',
                'meta_value'    => date('Y-m-d'),
                'orderby'        => 'meta_value',
                'order'          => 'ASC',
            ]);
        ?>
        <article class="cx-store-card">
            <header class="cx-store-header">
                <a href="<?php echo esc_url($category_url); ?>" class="cx-store-logo-link">
                    <?php if ($category_image) : ?>
                        <img src="<?php echo esc_url($category_image); ?>" 
                             alt="<?php echo esc_attr($category->name); ?>" 
                             class="cx-store-logo" 
                             loading="lazy"
                             width="160"
                             height="80" />
                    <?php else : ?>
                        <div class="cx-store-logo-placeholder">
                            <?php echo esc_html(mb_substr($category->name, 0, 1)); ?>
                        </div>
                    <?php endif; ?>
                </a>
                <h3 class="cx-store-title">
                    <a href="<?php echo esc_url($category_url); ?>">
                        <?php echo esc_html($category->name); ?>
                    </a>
                </h3>
                <div class="cx-store-count">
                    <?php echo esc_html($category->count) . ' ' . _n('Offer', 'Offers', $category->count, 'couponx'); ?>
                </div>
            </header>

            <?php if ($coupons->have_posts()) : ?>
            <div class="cx-store-coupons">
                <?php while ($coupons->have_posts()) : $coupons->the_post();
                    $coupon_code = get_post_meta(get_the_ID(), 'coupon_code', true);
                    $coupon_type = get_post_meta(get_the_ID(), 'coupon_type', true);
                    $expiry_date = get_post_meta(get_the_ID(), 'expiration_date', true);
                ?>
                <div class="cx-coupon-card cx-coupon-type-<?php echo esc_attr(strtolower($coupon_type)); ?>">
                    <div class="cx-coupon-content">
                        <span class="cx-coupon-type"><?php echo esc_html($coupon_type); ?></span>
                        <?php if ($coupon_code) : ?>
                            <div class="cx-coupon-code">
                                <code><?php echo esc_html($coupon_code); ?></code>
                            </div>
                        <?php endif; ?>
                        <h4 class="cx-coupon-title"><?php the_title(); ?></h4>
                        <?php if ($expiry_date) : ?>
                            <div class="cx-coupon-expiry">
                                <?php printf(__('Expires: %s', 'couponx'), date('M j, Y', strtotime($expiry_date))); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="cx-coupon-action">
                        <?php _e('Get Offer', 'couponx'); ?>
                    </a>
                </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            <?php endif; ?>

            <footer class="cx-store-footer">
                <a href="<?php echo esc_url($category_url); ?>" class="cx-view-all">
                    <?php _e('View All Offers', 'couponx'); ?>
                    <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24">
                        <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/>
                    </svg>
                </a>
            </footer>
        </article>
        <?php endforeach; ?>
    </div>
    <?php
    else : ?>
        <p class="cx-no-stores"><?php _e('No categories found.', 'couponx'); ?></p>
    <?php
    endif;
    
    return ob_get_clean();
});

// Register new block pattern for categories
register_block_pattern(
    'couponx/modern-categories-grid',
    [
        'title'       => esc_html__('Modern Categories Grid', 'couponx'),
        'description' => esc_html__('Responsive grid of coupon categories with their latest offers', 'couponx'),
        'content'     => '<!-- wp:group {"align":"wide","className":"couponx-categories-grid-wrapper","layout":{"type":"constrained"}} -->
                        <div class="wp-block-group alignwide couponx-categories-grid-wrapper">
                            <!-- wp:heading {"level":3,"className":"cx-section-heading"} -->
                            <h3 class="wp-block-heading cx-section-heading">' . esc_html__('Shop by Category', 'couponx') . '</h3>
                            <!-- /wp:heading -->
                            
                            <!-- wp:shortcode -->
                            [couponx_categories_grid]
                            <!-- /wp:shortcode -->
                        </div>
                        <!-- /wp:group -->',
        'categories'  => ['couponx'],
    ]
);