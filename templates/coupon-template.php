<?php
/**
 * Template Name: Coupon Grid Template
 * Description: Modern coupon grid layout with stores
 */

get_header();
?>

<div class="coupon-grid-container">
    <div class="coupon-filters">
        <?php 
        // Store Taxonomy Filter
        $stores = get_terms('store');
        if (!empty($stores)) : ?>
            <div class="store-filter">
                <button class="filter-btn active" data-filter="*">All</button>
                <?php foreach ($stores as $store) : ?>
                    <button class="filter-btn" data-filter=".<?php echo esc_attr($store->slug); ?>">
                        <?php echo esc_html($store->name); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="coupon-grid">
        <?php
        $args = array(
            'post_type' => 'coupon',
            'posts_per_page' => -1,
        );
        $query = new WP_Query($args);
        
        while ($query->have_posts()) : $query->the_post();
            $store_terms = get_the_terms(get_the_ID(), 'store');
            $store_classes = '';
            if ($store_terms) {
                foreach ($store_terms as $store_term) {
                    $store_classes .= ' ' . $store_term->slug;
                }
            }
            $expiry_date = get_post_meta(get_the_ID(), 'coupon_expiry', true);
            $coupon_code = get_post_meta(get_the_ID(), 'coupon_code', true);
            $is_expired = ($expiry_date && strtotime($expiry_date) < time());
        ?>
            <div class="coupon-card <?php echo esc_attr($store_classes); ?> <?php echo $is_expired ? 'expired' : ''; ?>">
                <div class="store-logo">
                    <?php the_post_thumbnail('medium'); ?>
                </div>
                <div class="coupon-content">
                    <h3><?php the_title(); ?></h3>
                    <div class="coupon-meta">
                        <?php if ($coupon_code) : ?>
                            <div class="coupon-code">
                                <span><?php echo esc_html($coupon_code); ?></span>
                                <button class="copy-btn" data-clipboard-text="<?php echo esc_attr($coupon_code); ?>">
                                    Copy Code
                                </button>
                            </div>
                        <?php endif; ?>
                        <?php if ($expiry_date) : ?>
                            <div class="expiry-date">
                                Expires: <?php echo date('M j, Y', strtotime($expiry_date)); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="coupon-status">
                        <?php if ($is_expired) : ?>
                            <span class="expired-label">Expired</span>
                        <?php else : ?>
                            <span class="active-label">Active</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
</div>

<?php get_footer(); ?>