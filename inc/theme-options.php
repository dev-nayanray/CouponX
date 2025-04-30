<?php
/**
 * Theme Customizer functionality
 * 
 * @package CouponX
 * @since 1.0.0
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Customizer class
 */
class CouponX_Customizer {

    /**
     * Register customizer settings
     * 
     * @param WP_Customize_Manager $wp_customize Theme Customizer object
     */
    public function register($wp_customize) {

        // Panel
        $this->add_panel($wp_customize);

        // Sections
        $this->add_general_section($wp_customize);
        $this->add_coupon_section($wp_customize);
        $this->add_performance_section($wp_customize);
        $this->add_color_section($wp_customize);
        $this->add_footer_section($wp_customize);
    }

    /**
     * Add main panel
     */
    private function add_panel($wp_customize) {
        $wp_customize->add_panel('couponx_theme_options', array(
            'title'       => esc_html__('CouponX Settings', 'couponx'),
            'description' => esc_html__('Main theme configuration settings', 'couponx'),
            'priority'    => 35,
            'capability' => 'edit_theme_options',
        ));
    }

    /**
     * General settings section
     */
    private function add_general_section($wp_customize) {
        $wp_customize->add_section('couponx_general', array(
            'title'    => esc_html__('General Settings', 'couponx'),
            'panel'    => 'couponx_theme_options',
            'priority' => 10,
        ));

        // Logo Upload
        $wp_customize->add_setting('couponx_logo', array(
            'default'           => '',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'esc_url_raw',
            'capability'        => 'edit_theme_options',
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control(
            $wp_customize,
            'couponx_logo',
            array(
                'label'       => esc_html__('Site Logo', 'couponx'),
                'description' => esc_html__('Upload your site logo (recommended size 200x50px)', 'couponx'),
                'section'     => 'couponx_general',
                'settings'    => 'couponx_logo',
            )
        ));
    }

    /**
     * Coupon settings section
     */
    private function add_coupon_section($wp_customize) {
        $wp_customize->add_section('couponx_coupons', array(
            'title'    => esc_html__('Coupon Settings', 'couponx'),
            'panel'    => 'couponx_theme_options',
            'priority' => 20,
        ));

        // Expiration Display
        $wp_customize->add_setting('couponx_show_expiration', array(
            'default'           => true,
            'transport'         => 'postMessage',
            'sanitize_callback' => 'wp_validate_boolean',
            'capability'        => 'edit_theme_options',
        ));

        $wp_customize->add_control('couponx_show_expiration', array(
            'label'       => esc_html__('Display Expiration Dates', 'couponx'),
            'description' => esc_html__('Show/hide coupon expiration dates', 'couponx'),
            'section'     => 'couponx_coupons',
            'type'        => 'checkbox',
        ));
    }

    /**
     * Performance section
     */
    private function add_performance_section($wp_customize) {
        $wp_customize->add_section('couponx_performance', array(
            'title'    => esc_html__('Performance', 'couponx'),
            'panel'    => 'couponx_theme_options',
            'priority' => 30,
        ));

        // Lazy Loading
        $wp_customize->add_setting('couponx_lazy_load', array(
            'default'           => true,
            'transport'         => 'refresh',
            'sanitize_callback' => 'wp_validate_boolean',
            'capability'        => 'edit_theme_options',
        ));

        $wp_customize->add_control('couponx_lazy_load', array(
            'label'       => esc_html__('Enable Lazy Loading', 'couponx'),
            'description' => esc_html__('Improve performance by lazy loading images', 'couponx'),
            'section'     => 'couponx_performance',
            'type'        => 'checkbox',
        ));
    }

    /**
     * Color scheme section
     */
    private function add_color_section($wp_customize) {
        $wp_customize->add_section('couponx_colors', array(
            'title'    => esc_html__('Color Scheme', 'couponx'),
            'panel'    => 'couponx_theme_options',
            'priority' => 40,
        ));

        // Primary Color
        $wp_customize->add_setting('couponx_primary_color', array(
            'default'           => '#2196F3',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color',
            'capability'        => 'edit_theme_options',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            'couponx_primary_color',
            array(
                'label'       => esc_html__('Primary Color', 'couponx'),
                'description' => esc_html__('Main theme accent color', 'couponx'),
                'section'     => 'couponx_colors',
            )
        ));
    }

    /**
     * Footer section
     */
    private function add_footer_section($wp_customize) {
        $wp_customize->add_section('couponx_footer', array(
            'title'    => esc_html__('Footer Settings', 'couponx'),
            'panel'    => 'couponx_theme_options',
            'priority' => 50,
        ));

        // Footer Text
        $wp_customize->add_setting('couponx_footer_text', array(
            'default'           => '',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'wp_kses_post',
            'capability'        => 'edit_theme_options',
        ));

        $wp_customize->add_control('couponx_footer_text', array(
            'label'       => esc_html__('Copyright Text', 'couponx'),
            'description' => esc_html__('HTML allowed in footer text', 'couponx'),
            'section'     => 'couponx_footer',
            'type'        => 'textarea',
        ));
    }

    /**
     * Live preview JS
     */
    public function live_preview() {
        wp_enqueue_script(
            'couponx-customizer',
            get_template_directory_uri() . '/assets/js/customizer.js',
            array('jquery', 'customize-preview'),
            wp_get_theme()->get('Version'),
            true
        );
    }
}

// Initialize
add_action('customize_register', function($wp_customize) {
    $customizer = new CouponX_Customizer();
    $customizer->register($wp_customize);
});

// Live preview
add_action('customize_preview_init', function() {
    $customizer = new CouponX_Customizer();
    $customizer->live_preview();
});


/**
 * Theme mods wrapper class
 */
class CouponX_Theme_Mods {

    public static function get_logo() {
        return esc_url(get_theme_mod('couponx_logo'));
    }

    public static function show_expiration() {
        return (bool) get_theme_mod('couponx_show_expiration', true);
    }

    public static function primary_color() {
        return sanitize_hex_color(get_theme_mod('couponx_primary_color', '#2196F3'));
    }

    public static function footer_text() {
        return wp_kses_post(get_theme_mod('couponx_footer_text'));
    }

    public static function lazy_load_enabled() {
        return (bool) get_theme_mod('couponx_lazy_load', true);
    }
}

// Dynamic CSS output
add_action('wp_head', function() {
    echo '<style id="couponx-dynamic-css">';
    echo ':root { --primary-color: ' . CouponX_Theme_Mods::primary_color() . '; }';
    echo '</style>';
});