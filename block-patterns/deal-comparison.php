<?php
/**
 * Deal Comparison Table
 * Title: Deal Comparison
 * Slug: couponx/deal-comparison
 * Categories: couponx
 */
$content = <<<CONTENT
<!-- wp:group {"align":"wide","className":"deal-comparison"} -->
<div class="wp-block-group alignwide deal-comparison">
    <!-- wp:heading {"textAlign":"center"} -->
    <h2 class="has-text-align-center">Best Deals Comparison</h2>
    <!-- /wp:heading -->
    
    <!-- wp:table {"className":"is-style-compact"} -->
    <figure class="wp-block-table is-style-compact">
        <table>
            <thead>
                <tr>
                    <th>Store</th>
                    <th>Regular Price</th>
                    <th>Discounted Price</th>
                    <th>Savings</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Walmart</td>
                    <td><del>$199</del></td>
                    <td><strong>$99</strong></td>
                    <td><mark class="has-inline-color has-success-color">50% OFF</mark></td>
                </tr>
            </tbody>
        </table>
    </figure>
    <!-- /wp:table -->
</div>
<!-- /wp:group -->
CONTENT;

register_block_pattern(
    'couponx/deal-comparison',
    array(
        'title'       => esc_html__('Deal Comparison', 'couponx'),
        'description' => esc_html__('Price comparison table showing savings percentages', 'couponx'),
        'content'     => $content,
        'categories'  => array('couponx'),
    )
);