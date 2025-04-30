<?php
/**
 * Newsletter Signup - Premium Grid
 * Title: Premium Newsletter Grid v2
 * Slug: couponx/newsletter-grid-pro
 * Categories: couponx
 */

$content = <<<CONTENT
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"6rem","bottom":"6rem"},"blockGap":"0px"},"className":"newsletter-premium-pro","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull newsletter-premium-pro" style="padding-top:6rem;padding-bottom:6rem">
    
    <!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"4rem","left":"4rem"}}},"className":"newsletter-columns"} -->
    <div class="wp-block-columns alignwide newsletter-columns">
        
        <!-- wp:column {"width":"55%","className":"features-column"} -->
        <div class="wp-block-column features-column" style="flex-basis:55%">
            
            <!-- wp:heading {"textColor":"primary","fontSize":"xxxl","fontFamily":"heading"} -->
            <h2 class="has-primary-color has-text-color has-xxxl-font-size has-heading-font-family">Exclusive Member Benefits</h2>
            <!-- /wp:heading -->
            
            <!-- wp:paragraph {"fontSize":"lg","textColor":"light"} -->
            <p class="has-light-color has-text-color has-lg-font-size">Join our premium community to unlock these benefits:</p>
            <!-- /wp:paragraph -->
            
            <!-- wp:columns {"style":{"spacing":{"blockGap":"2rem"}},"className":"benefits-grid"} -->
            <div class="wp-block-columns benefits-grid">
                
              <!-- wp:columns -->
<div class="wp-block-columns">
    
    <!-- First Column -->
    <div class="wp-block-column">
        <div class="benefit-card group" style="border-radius:16px;padding:2.5rem 2rem;background:linear-gradient(135deg, #f0f4ff, #e0e7ff);box-shadow:0 8px 24px rgba(0,0,0,0.08);transition:transform 0.4s ease, box-shadow 0.4s ease;">
            
            <!-- Icon -->
            <div class="icon-wrapper" style="display:flex;justify-content:center;align-items:center;width:80px;height:80px;margin:0 auto 1.5rem;background:#ffffff;border-radius:50%;box-shadow:0 4px 10px rgba(0,0,0,0.1);transition:transform 0.4s ease;">
                <img src="https://cdn-icons-png.flaticon.com/512/545/545705.png" alt="Priority Access" width="40" height="40" style="transition:transform 0.4s ease;" class="group-hover:scale-110">
            </div>

            <!-- Badge -->
            <div class="badge" style="display:inline-block;background:#4f46e5;color:#fff;font-size:0.75rem;font-weight:600;padding:0.25rem 0.75rem;border-radius:9999px;margin:1rem auto 0.75rem;text-align:center;">
                Early Access
            </div>

            <!-- Title -->
            <h3 class="has-primary-color has-text-color has-xl-font-size has-heading-font-family" style="text-align:center;margin-bottom:1rem;">Priority Access</h3>

            <!-- Description -->
            <p class="has-light-color has-text-color has-md-font-size" style="text-align:center;">Get early notifications for limited-time offers and exclusive deals, so you're always first in line.</p>
        </div>
    </div>

    <!-- Second Column -->
    <div class="wp-block-column">
        <div class="benefit-card group" style="border-radius:16px;padding:2.5rem 2rem;background:linear-gradient(135deg, #f0fdf4, #d1fae5);box-shadow:0 8px 24px rgba(0,0,0,0.08);transition:transform 0.4s ease, box-shadow 0.4s ease;">
            
            <!-- Icon -->
            <div class="icon-wrapper" style="display:flex;justify-content:center;align-items:center;width:80px;height:80px;margin:0 auto 1.5rem;background:#ffffff;border-radius:50%;box-shadow:0 4px 10px rgba(0,0,0,0.1);transition:transform 0.4s ease;">
                <img src="https://cdn-icons-png.flaticon.com/512/1828/1828640.png" alt="Curated Offers" width="40" height="40" style="transition:transform 0.4s ease;" class="group-hover:scale-110">
            </div>

            <!-- Badge -->
            <div class="badge" style="display:inline-block;background:#10b981;color:#fff;font-size:0.75rem;font-weight:600;padding:0.25rem 0.75rem;border-radius:9999px;margin:1rem auto 0.75rem;text-align:center;">
                Personalized
            </div>

            <!-- Title -->
            <h3 class="has-primary-color has-text-color has-xl-font-size has-heading-font-family" style="text-align:center;margin-bottom:1rem;">Curated Offers</h3>

            <!-- Description -->
            <p class="has-light-color has-text-color has-md-font-size" style="text-align:center;">Enjoy handpicked deals perfectly suited to your style, preferences, and shopping behavior.</p>
        </div>
    </div>

</div>
<!-- /wp:columns -->

                
            </div>
            <!-- /wp:columns -->
            
        </div>
        <!-- /wp:column -->
        
        <!-- wp:column {"width":"45%","className":"form-column"} -->
<div class="wp-block-column form-column" style="flex-basis:45%">
    <!-- wp:group {"style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem","left":"4rem","right":"4rem"},"blockGap":"2rem"},"border":{"radius":"16px"},"className":"newsletter-form-container","layout":{"type":"constrained"}} -->
    <div class="wp-block-group newsletter-form-container" style="border-radius:16px;padding:4rem">
        
        <!-- wp:heading -->
        <h2 class="has-text-align-center has-primary-color has-text-color has-xxl-font-size has-heading-font-family">Join Now</h2>
        <!-- /wp:heading -->
        
        <!-- wp:paragraph -->
        <p class="has-text-align-center has-light-color has-text-color has-lg-font-size">Get started with your premium account</p>
        <!-- /wp:paragraph -->
        
        <!-- Social Signup Buttons -->
        <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1rem; text-align: center;">
            <button style="padding:1rem;border:none;border-radius:8px;background-color:#DB4437;color:white;font-weight:bold">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google Icon" style="width:20px;margin-right:8px;vertical-align:middle"> Continue with Google
            </button>
            <!-- Add more buttons as needed -->
            <!-- 
            <button style="padding:1rem;border:none;border-radius:8px;background-color:#3b5998;color:white;font-weight:bold">
                <i class="fab fa-facebook-f" style="margin-right:8px"></i> Continue with Facebook
            </button> 
            -->
        </div>
        
        <!-- Custom Form Start -->
        <form action="#" method="post" class="newsletter-form-pro" style="display:flex;flex-direction:column;gap:1rem;text-align:center">
            <input type="text" name="name" placeholder="Your Name" required style="padding:1rem;border-radius:8px;border:1px solid #ccc;width:100%">
            <input type="email" name="email" placeholder="Your Email" required style="padding:1rem;border-radius:8px;border:1px solid #ccc;width:100%">
            <button type="submit" style="padding:1rem;border:none;border-radius:8px;background-color:var(--wp--preset--color--primary);color:white;font-weight:bold">Get Premium Access</button>
        </form>
        <!-- Custom Form End -->
        
        <!-- wp:paragraph -->
                <p class="has-text-align-center has-light-color has-text-color has-xs-font-size privacy-note">256-bit SSL encryption ¡¤ No spam</p>
        <!-- /wp:paragraph -->

    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:column -->

        
    </div>
    <!-- /wp:columns -->
    
</div>
<!-- /wp:group -->
CONTENT;

register_block_pattern(
    'couponx/newsletter-grid-pro',
    array(
        'title'       => esc_html__('Premium Newsletter Grid Pro', 'couponx'),
        'description' => esc_html__('Modern premium newsletter section with feature cards and enhanced styling', 'couponx'),
        'content'     => $content,
        'categories'  => array('couponx'),
    )
);

// Enqueue custom styles
function couponx_newsletter_pro_styles() {
    wp_enqueue_style(
        'couponx-patterns-pro',
        get_template_directory_uri() . '/assets/css/patterns.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/patterns.css')
    );
}
add_action('wp_enqueue_scripts', 'couponx_newsletter_pro_styles');