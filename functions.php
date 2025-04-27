<?php
/**
 * CouponX Theme functions and definitions
 *
 * @package CouponX
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
function couponx_enqueue_assets() {
    // Enqueue stylesheet
    wp_enqueue_style(
        'couponx-style',
        get_stylesheet_uri(),
        array(),
        COUPONX_THEME_VERSION
    );
    
    // Enqueue JavaScript file for admin taxonomy
    wp_enqueue_script(
        'couponx-admin-taxonomy',
        get_template_directory_uri() . '/assets/js/admin-taxonomy.js',
        array('jquery'), // Dependencies (if any)
        COUPONX_THEME_VERSION,
        true // Load in footer
    );
}

// Define constants
define( 'COUPONX_THEME_VERSION', wp_get_theme()->get( 'Version' ) );

// Theme setup
add_action( 'after_setup_theme', 'couponx_theme_setup' );
function couponx_theme_setup() {
    // Load text domain for translations
    load_theme_textdomain( 'couponx', get_template_directory() . '/languages' );

    // Add core theme supports
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'wp-block-styles' );
    
    // Custom coupon theme supports
    add_theme_support( 'block-templates' );
    add_theme_support( 'block-template-parts' );
    add_theme_support( 'editor-styles' );
    
    // HTML5 markup for core components
    add_theme_support( 'html5', array(
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
        'navigation-widgets',
    ) );

    // Custom logo support
    add_theme_support( 'custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Menu locations
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'couponx' ),
        'footer'  => __( 'Footer Menu', 'couponx' ),
    ) );

    // Custom image sizes for coupons
    add_image_size( 'coupon-thumbnail', 400, 300, true );
    add_image_size( 'store-logo', 200, 200, false );

    // Editor color palette (matches theme.json)
    add_theme_support( 'editor-color-palette', array(
        array(
            'name'  => __( 'Primary', 'couponx' ),
            'slug'  => 'primary',
            'color' => '#ff6b6b',
        ),
        array(
            'name'  => __( 'Secondary', 'couponx' ),
            'slug'  => 'secondary',
            'color' => '#4ecdc4',
        ),
        array(
            'name'  => __( 'Dark', 'couponx' ),
            'slug'  => 'dark',
            'color' => '#2d3436',
        ),
        array(
            'name'  => __( 'Light', 'couponx' ),
            'slug'  => 'light',
            'color' => '#f9f9f9',
        ),
    ) );

    // Disable custom colors in favor of palette
    add_theme_support( 'disable-custom-colors' );
    
    // Enable experimental spacing controls
    add_theme_support( 'custom-spacing' );
    
    // Enable layout controls
    add_theme_support( 'experimental-layout-controls' );
    
    // Add editor styles
    add_editor_style( 'assets/css/editor-style.css' );
    
    // Starter content for new sites
    add_theme_support( 'starter-content', array(
        'posts' => array(
            'coupon' => array(
                'post_type'    => 'coupon',
                'post_title'   => __( 'Example Coupon', 'couponx' ),
                'post_content' => __( 'This is an example coupon. Edit or delete it to get started.', 'couponx' ),
                'meta' => array(
                    '_couponx_code'   => 'EXAMPLE25',
                    '_couponx_expiry' => date( 'Y-m-d', strtotime( '+30 days' ) ),
                ),
                'thumbnail' => '{{image-coupon-example}}',
            ),
        ),
        'attachments' => array(
            'image-coupon-example' => array(
                'post_title' => __( 'Example Coupon Image', 'couponx' ),
                'file'       => 'assets/images/example-coupon.jpg',
            ),
        ),
        'options' => array(
            'show_on_front'  => 'posts',
            'posts_per_page' => 12,
        ),
    ) );
}

// Include additional functionality
require_once get_template_directory() . '/inc/couponpost.php';
require_once get_template_directory() . '/inc/custom-meta.php';
require_once get_template_directory() . '/inc/performance.php';



function couponx_register_block_patterns() {
    // Register the custom pattern category
    register_block_pattern_category( 'couponx', array(
        'label' => __( 'CouponX Patterns', 'couponx' )
    ));
    
    // Array of block patterns, no duplicates
    $patterns = array(
        'coupon-grid',
        'featured-carousel',
        'category-tabs',
        'deal-of-day',
        'store-directory',
        'newsletter-cta',
        'expiring-deals',
        'featured-store',
        'deal-comparison',
        'coupon-masonry',
        'hero-section',
        'category-grid',
        'testimonial-slider',
        'blog-section',
        'faq-accordion',
        'breadcrumb-nav'
    );

    // Loop through each pattern and include the file if it exists
    foreach ($patterns as $pattern) {
        $pattern_file = get_template_directory() . '/block-patterns/' . $pattern . '.php';

        // Check if the pattern file exists before including
        if ( file_exists( $pattern_file ) ) {
            include $pattern_file;
        } else {
            // Optional: log an error for missing files (useful for debugging)
            error_log( 'Pattern file missing: ' . $pattern_file );
        }
    }
}
add_action( 'init', 'couponx_register_block_patterns' );


// Enqueue assets
add_action( 'wp_enqueue_scripts', 'couponx_enqueue_assets' );



// Security headers
add_action( 'send_headers', 'couponx_security_headers' );
function couponx_security_headers() {
	header( 'X-Content-Type-Options: nosniff' );
	header( 'X-Frame-Options: SAMEORIGIN' );
	header( 'X-XSS-Protection: 1; mode=block' );
}

  
// Corrected Coupon Shortcode
function couponx_coupon_shortcode($atts) {
    $atts = shortcode_atts(array(
        'id' => 0,
    ), $atts);

    ob_start();
    
    if ($coupon = get_post($atts['id'])) {
        // Verify it's a coupon post type
        if ($coupon->post_type !== 'coupon') {
            return '<p class="couponx-error">' . esc_html__('Invalid coupon ID', 'couponx') . '</p>';
        }

        $code = get_post_meta($coupon->ID, '_couponx_code', true);
        $expiry = get_post_meta($coupon->ID, '_couponx_expiry', true);

        echo '<div class="couponx-single-coupon">';
        echo '<h3 class="coupon-title">' . esc_html($coupon->post_title) . '</h3>';
        echo '<div class="coupon-content">' . wpautop($coupon->post_content) . '</div>';

        // Display custom fields
        if ($code) {
            echo '<div class="coupon-code">' 
                 . esc_html__('Code:', 'couponx') 
                 . ' <strong>' . esc_html($code) . '</strong></div>';
        }

        if ($expiry) {
            $expiry_date = strtotime($expiry);
            if ($expiry_date) {
                echo '<div class="coupon-expiry">'
                     . esc_html__('Expires:', 'couponx') 
                     . ' <time datetime="' . esc_attr(date('Y-m-d', $expiry_date)) . '">'
                     . esc_html(date_i18n(get_option('date_format'), $expiry_date))
                     . '</time></div>';
            }
        }

        echo '</div>'; // Close .couponx-single-coupon
    } else {
        echo '<p class="couponx-error">' . esc_html__('Coupon not found', 'couponx') . '</p>';
    }

    return ob_get_clean();
}
add_shortcode('couponx_coupon', 'couponx_coupon_shortcode');
// Enqueue Theme Styles
 
function couponx_enqueue_carousel_assets() {
    // SwiperJS CSS & JS
    wp_enqueue_style('swiper-css', 'https://unpkg.com/swiper@8/swiper-bundle.min.css');
    wp_enqueue_script('swiper-js', 'https://unpkg.com/swiper@8/swiper-bundle.min.js', array(), null, true);

    // Custom Carousel Initialization
    wp_add_inline_script('swiper-js', "
        document.addEventListener('DOMContentLoaded', function() {
            var swiper = new Swiper('.category-carousel', {
                slidesPerView: 3,
                spaceBetween: 30,
                loop: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                autoplay: {
                    delay: 3000,
                },
                breakpoints: {
                    768: {
                        slidesPerView: 2,
                    },
                    480: {
                        slidesPerView: 1,
                    }
                }
            });
        });
    ");
}
add_action('wp_enqueue_scripts', 'couponx_enqueue_carousel_assets');

 
// Register menus
function register_pro_menus() {
    register_nav_menus([
        'primary' => __('Primary Menu', 'text-domain'),
        'utility' => __('Utility Menu', 'text-domain'),
        'mobile' => __('Mobile Menu', 'text-domain')
    ]);
}
add_action('init', 'register_pro_menus');

// Add theme support
add_theme_support('custom-logo');
 
function couponx_meta_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'key' => '',
    ), $atts );

    if ( empty( $atts['key'] ) ) {
        return '';
    }

    $value = get_post_meta( get_the_ID(), $atts['key'], true );
    return esc_html( $value );
}
add_shortcode( 'meta', 'couponx_meta_shortcode' );
function couponx_enqueue_blog_styles() {
    wp_enqueue_style(
        'couponx-blog-styles',
        get_theme_file_uri('css/blog-grid.css'),
        array(),
        filemtime(get_theme_file_path('/assets/css/blog-grid.css'))
    );
}
add_action('wp_enqueue_scripts', 'couponx_enqueue_blog_styles');

function couponx_enqueue_premium_styles() {
    wp_enqueue_style(
        'couponx-premium',
        get_template_directory_uri() . '/assets/css/premium-deals.css',
        array(),
        '1.1.0'
    );
    
    wp_enqueue_script(
        'couponx-countdown',
        get_template_directory_uri() . '/assets/js/countdown.js',
        array(),
        '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'couponx_enqueue_premium_styles');