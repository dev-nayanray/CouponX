<?php
/**
 * Deal of the Day
 * Title: Deal of the Day
 * Slug: couponx/deal-of-day
 * Categories: couponx
 */
$content = <<<CONTENT
<!-- wp:cover {"url":"' . esc_url(get_template_directory_uri()) . '/assets/images/deal-bg.jpg","dimRatio":50,"overlayColor":"dark","minHeight":500,"align":"full"} -->
<div class="wp-block-cover alignfull has-dark-background-color has-background-dim" style="min-height:500px">
    <!-- wp:group {"layout":{"type":"constrained"},"className":"deal-container"} -->
    <div class="wp-block-group deal-container">
        <!-- wp:heading {"textAlign":"center","style":{"color":{"text":"#ffffff"},"typography":{"fontSize":"3rem"}}} -->
        <h2 class="has-text-align-center has-text-color" style="color:#ffffff;font-size:3rem">Deal of the Day</h2>
        <!-- /wp:heading -->
        
        <!-- wp:countdown {"align":"center","backgroundColor":"accent","textColor":"light"} -->
        <div class="wp-block-countdown aligncenter has-light-color has-accent-background-color has-text-color has-background">
            <!-- Timer elements -->
        </div>
        <!-- /wp:countdown -->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:cover -->
CONTENT;

register_block_pattern(
    'couponx/deal-of-day',
    array(
        'title'       => esc_html__('Deal of the Day', 'couponx'),
        'description' => esc_html__('Full-width hero section with countdown timer for special deals', 'couponx'),
        'content'     => $content,
        'categories'  => array('couponx'),
    )
);