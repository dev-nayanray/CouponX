<?php
/**
 * FAQ Section
 * Title: FAQ Accordion
 * Slug: couponx/faq-accordion
 * Categories: couponx
 */
$content = <<<CONTENT
<!-- wp:group {"align":"wide","className":"faq-accordion"} -->
<div class="wp-block-group alignwide faq-accordion">
    <!-- wp:heading {"textAlign":"center"} -->
    <h2 class="has-text-align-center">Frequently Asked Questions</h2>
    <!-- /wp:heading -->
    
    <!-- wp:details {"className":"faq-item"} -->
    <details class="wp-block-details faq-item">
        <summary>How do I use coupon codes?</summary>
        <div class="wp-block-details__content">
            <p>Copy the code during checkout and paste it in the promo code field.</p>
        </div>
    </details>
    <!-- /wp:details -->
    
    <!-- wp:details {"className":"faq-item"} -->
    <details class="wp-block-details faq-item">
        <summary>Are these deals verified?</summary>
        <div class="wp-block-details__content">
            <p>Yes, our team manually verifies all deals daily.</p>
        </div>
    </details>
    <!-- /wp:details -->
</div>
<!-- /wp:group -->
CONTENT;

register_block_pattern(
    'couponx/faq-accordion',
    array(
        'title'       => esc_html__('FAQ Accordion', 'couponx'),
        'description' => esc_html__('Expandable Q&A section with accordion functionality', 'couponx'),
        'content'     => $content,
        'categories'  => array('couponx'),
    )
);