<?php
// First define all elements EXCEPT 'expired'
$coupon_data = [
    'code'        => get_post_meta(get_the_ID(), 'coupon_code', true),
    'type'        => get_post_meta(get_the_ID(), 'coupon_type', true),
    'expiration'  => get_post_meta(get_the_ID(), 'expiration_date', true),
    'discount'    => get_post_meta(get_the_ID(), 'discount_value', true),
    'store'       => get_the_terms(get_the_ID(), 'store'),
    'categories'  => get_the_terms(get_the_ID(), 'coupon_category'),
    'image'       => get_the_post_thumbnail_url(get_the_ID(), 'medium_large'),
    'store_image' => ''
];

// Now add the 'expired' status using the fully defined array
$coupon_data['expired'] = ($coupon_data['expiration'] && strtotime($coupon_data['expiration']) < time());

if ($coupon_data['store'] && !is_wp_error($coupon_data['store'])) {
    $coupon_data['store_image'] = get_term_meta($coupon_data['store'][0]->term_id, 'taxonomy_image_url', true);
}
?>

<article class="coupon-card <?php echo $coupon_data['expired'] ? 'expired' : ''; ?>">
    <?php if ($coupon_data['expired']) : ?>
    <div class="expired-banner"><?php esc_html_e('Expired', 'couponx'); ?></div>
    <?php endif; ?>

    <header class="card-header">
        <?php if ($coupon_data['image']) : ?>
        <div class="coupon-image">
            <img src="<?php echo esc_url($coupon_data['image']); ?>" 
                 alt="<?php the_title_attribute(); ?>" 
                 loading="lazy">
        </div>
        <?php endif; ?>

        <div class="store-info">
            <?php if ($coupon_data['store_image']) : ?>
            <img class="store-logo" 
                 src="<?php echo esc_url($coupon_data['store_image']); ?>" 
                 alt="<?php echo esc_attr($coupon_data['store'][0]->name); ?>">
            <?php endif; ?>
            
            <div class="store-meta">
                <?php if ($coupon_data['store']) : ?>
                <h3><?php echo esc_html($coupon_data['store'][0]->name); ?></h3>
                <?php endif; ?>
                <span class="coupon-type <?php echo sanitize_html_class(strtolower($coupon_data['type'])); ?>">
                    <?php echo esc_html($coupon_data['type']); ?>
                </span>
            </div>
        </div>
    </header>

    <div class="card-body">
        <h4><?php the_title(); ?></h4>
        
        <?php if ($coupon_data['discount']) : ?>
        <div class="discount-value">
            <?php echo esc_html($coupon_data['discount']); ?>
        </div>
        <?php endif; ?>

        <div class="coupon-meta">
            <?php if ($coupon_data['categories']) : ?>
            <div class="categories">
                <?php foreach ($coupon_data['categories'] as $category) : ?>
                <span class="category"><?php echo esc_html($category->name); ?></span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if ($coupon_data['expiration']) : ?>
            <div class="expiration">
                <svg aria-hidden="true" viewBox="0 0 24 24" width="18" height="18">
                    <path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8zm1-4v-4h-2v6h6v-2h-4z"/>
                </svg>
                <time datetime="<?php echo esc_attr(date('Y-m-d', strtotime($coupon_data['expiration']))); ?>">
                    <?php echo esc_html(date_i18n('M j, Y', strtotime($coupon_data['expiration']))); ?>
                </time>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <footer class="card-footer">
        <?php if ($coupon_data['code']) : ?>
        <div class="code-wrapper">
            <input type="text" value="<?php echo esc_attr($coupon_data['code']); ?>" 
                   readonly 
                   aria-label="<?php esc_attr_e('Coupon code', 'couponx'); ?>">
            <button class="copy-btn" data-clipboard-text="<?php echo esc_attr($coupon_data['code']); ?>">
                <?php esc_html_e('Copy', 'couponx'); ?>
            </button>
        </div>
        <?php endif; ?>

        <a href="<?php the_permalink(); ?>" class="deal-link">
            <?php esc_html_e('View Deal', 'couponx'); ?>
            <svg aria-hidden="true" viewBox="0 0 24 24" width="16" height="16">
                <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
            </svg>
        </a>
    </footer>
</article>