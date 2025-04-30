<?php
/**
 * FAQ Section
 * Title: Premium Animated FAQ Grid
 * Slug: couponx/faq-grid
 * Categories: couponx
 */

$content = <<<HTML
<!-- wp:group {"align":"wide","className":"premium-faq-grid","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide premium-faq-grid">
    <!-- wp:heading {"textAlign":"center","className":"section-heading","fontSize":"xl"} -->
    <h2 class="has-text-align-center section-heading has-xl-font-size">Frequently Asked Questions</h2>
    <!-- /wp:heading -->

    <!-- wp:columns {"align":"wide","className":"faq-grid"} -->
    <div class="wp-block-columns alignwide faq-grid">

        <!-- wp:column {"className":"faq-item animate__animated"} -->
        <div class="wp-block-column faq-item animate__animated">
            <div class="faq-card">
                <div class="faq-icon">?</div>
                <h3 class="faq-question">How do I use coupon codes?</h3>
                <div class="faq-answer">
                    <p>Copy the code during checkout and paste it in the promo code field to apply discounts.</p>
                </div>
                <button class="faq-more">View Details</button>
            </div>
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"className":"faq-item animate__animated"} -->
        <div class="wp-block-column faq-item animate__animated">
            <div class="faq-card">
                <div class="faq-icon">!</div>
                <h3 class="faq-question">Are deals verified?</h3>
                <div class="faq-answer">
                    <p>Our team manually verifies all offers daily to ensure validity.</p>
                </div>
                <button class="faq-more">View Details</button>
            </div>
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"className":"faq-item animate__animated"} -->
        <div class="wp-block-column faq-item animate__animated">
            <div class="faq-card">
                <div class="faq-icon">%</div>
                <h3 class="faq-question">Can I use multiple coupons at once?</h3>
                <div class="faq-answer">
                    <p>Most stores allow only one coupon per order, but you can combine a coupon with ongoing sales.</p>
                </div>
                <button class="faq-more">View Details</button>
            </div>
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"className":"faq-item animate__animated"} -->
        <div class="wp-block-column faq-item animate__animated">
            <div class="faq-card">
                <div class="faq-icon">&#10003;</div>
                <h3 class="faq-question">Why is my coupon code not working?</h3>
                <div class="faq-answer">
                    <p>Make sure the coupon has not expired and matches the terms like minimum purchase requirements or specific products.</p>
                </div>
                <button class="faq-more">View Details</button>
            </div>
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"className":"faq-item animate__animated"} -->
        <div class="wp-block-column faq-item animate__animated">
            <div class="faq-card">
                <div class="faq-icon">&#128172;</div>
                <h3 class="faq-question">Do I need an account to use a coupon?</h3>
                <div class="faq-answer">
                    <p>Most stores allow guests to use coupons, but creating an account can unlock exclusive offers and loyalty rewards.</p>
                </div>
                <button class="faq-more">View Details</button>
            </div>
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"className":"faq-item animate__animated"} -->
        <div class="wp-block-column faq-item animate__animated">
            <div class="faq-card">
                <div class="faq-icon">&#128214;</div>
                <h3 class="faq-question">How often are new deals added?</h3>
                <div class="faq-answer">
                    <p>New coupons and deals are added daily to provide you with the latest savings opportunities.</p>
                </div>
                <button class="faq-more">View Details</button>
            </div>
        </div>
        <!-- /wp:column -->

    </div>
    <!-- /wp:columns -->

    <!-- wp:html -->
    <div class="faq-modal">
        <div class="modal-overlay"></div>
        <div class="modal-content">
            <button class="modal-close">&times;</button>
            <h3 class="modal-question"></h3>
            <div class="modal-answer"></div>
        </div>
    </div>
    <!-- /wp:html -->
</div>
<!-- /wp:group -->
HTML;

register_block_pattern(
    'couponx/faq-grid',
    array(
        'title'       => esc_html__('Premium Animated FAQ Grid', 'couponx'),
        'description' => esc_html__('Modern grid-style FAQ with animated cards and modal popups', 'couponx'),
        'content'     => $content,
        'categories'  => array('couponx'),
    )
);

function couponx_faq_assets() {
    if (!is_admin()) {
        // CSS
        wp_enqueue_style(
            'couponx-faq',
            get_theme_file_uri('/assets/css/faq-grid.css'),
            array(),
            filemtime(get_theme_file_path('/assets/css/faq-grid.css'))
        );

        // JS
        wp_enqueue_script(
            'couponx-faq',
            get_theme_file_uri('/assets/js/faq-grid.js'),
            array('jquery'),
            filemtime(get_theme_file_path('/assets/js/faq-grid.js')),
            true
        );

        // Animate.css
        wp_enqueue_style(
            'animate-css',
            'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css',
            array(),
            '4.1.1'
        );
    }
}
add_action('wp_enqueue_scripts', 'couponx_faq_assets');
