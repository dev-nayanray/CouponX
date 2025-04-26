<?php
/**
 * Expiring Soon Section
 * Title: Expiring Deals
 * Slug: couponx/expiring-deals
 * Categories: couponx
 */
$content = <<<CONTENT
<!-- wp:group {"align":"wide","className":"expiring-deals"} -->
<div class="wp-block-group alignwide expiring-deals">
    <!-- wp:heading {"level":3,"style":{"color":{"text":"#dc3545"}}} -->
    <h3 class="has-text-color" style="color:#dc3545">⏳ Expiring Soon!</h3>
    <!-- /wp:heading -->
    
    <!-- wp:table {"className":"is-style-stripes"} -->
    <figure class="wp-block-table is-style-stripes">
        <table>
            <thead>
                <tr>
                    <th>Store</th>
                    <th>Deal</th>
                    <th>Expires</th>
                    <th>Code</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Amazon</td>
                    <td>50% Off Electronics</td>
                    <td>24 hours</td>
                    <td><button class="wp-element-button is-style-code-reveal">SHOW CODE</button></td>
                </tr>
            </tbody>
        </table>
    </figure>
    <!-- /wp:table -->
</div>
<!-- /wp:group -->
CONTENT;

register_block_pattern(
    'couponx/expiring-deals',
    array(
        'title'       => esc_html__('Expiring Deals', 'couponx'),
        'description' => esc_html__('Urgent expiring deals table with code reveal functionality', 'couponx'),
        'content'     => $content,
        'categories'  => array('couponx'),
    )
);