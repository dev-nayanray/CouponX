<?php
/**
 * CouponX Custom Meta Boxes
 * 
 * @package CouponX
 * @version 1.2.0
 */

namespace CouponX;

defined('ABSPATH') || exit;

if (!class_exists(__NAMESPACE__ . '\\CouponX_Meta_Boxes')) {

class CouponX_Meta_Boxes {
    /**
     * Initialize meta box functionality
     */
    public static function init() {
        add_action('add_meta_boxes', array(__CLASS__, 'add_meta_boxes'));
        add_action('save_post', array(__CLASS__, 'save_meta_data'), 10, 2);
        add_action('admin_enqueue_scripts', array(__CLASS__, 'admin_scripts'));
        add_action('admin_notices', array(__CLASS__, 'show_admin_notices'));
    }

    /**
     * Add meta boxes to coupon post type
     */
    public static function add_meta_boxes() {
        add_meta_box(
            'couponx_details',
            __('Coupon Details', 'couponx'),
            array(__CLASS__, 'meta_box_callback'),
            'coupon',
            'normal',
            'high'
        );
    }

    /**
     * Meta box content
     */
    public static function meta_box_callback($post) {
        wp_nonce_field('couponx_meta_action', 'couponx_meta_nonce');
        $meta_data = self::get_meta_defaults($post->ID);
        ?>
        <div class="couponx-metabox-container">
            <table class="form-table">
                <tbody>
                    <?php 
                    self::render_text_input(__('Coupon Code', 'couponx'), 'couponx_code', $meta_data['code'], 'widefat');
                    self::render_date_input(__('Expiry Date', 'couponx'), 'couponx_expiry', $meta_data['expiry']);
                    self::render_text_input(__('Deal Code', 'couponx'), 'deal_code', $meta_data['deal_code'], 'widefat');
                    self::render_checkbox(__('Printable Coupon', 'couponx'), 'printable', $meta_data['printable']);
                    self::render_number_input(__('Rating (1-5)', 'couponx'), 'rating', $meta_data['rating'], 1, 5);
                    self::render_select_input(
                        __('Discount Type', 'couponx'),
                        'discount_type',
                        $meta_data['discount_type'],
                        array(
                            'percentage' => __('Percentage', 'couponx'),
                            'fixed' => __('Fixed Amount', 'couponx')
                        )
                    );
                    self::render_number_input(
                        __('Discount Value', 'couponx'),
                        'discount_value',
                        $meta_data['discount_value'],
                        0,
                        10000,
                        '0.01'
                    );
                    self::render_text_input(
                        __('Affiliate URL', 'couponx'),
                        'affiliate_url',
                        $meta_data['affiliate_url'],
                        'widefat',
                        'url'
                    );
                    self::render_text_input(
                        __('Store Link', 'couponx'),
                        'store_link',
                        $meta_data['store_link'],
                        'widefat',
                        'url'
                    );
                    self::render_number_input(
                        __('Usage Limit', 'couponx'),
                        'usage_limit',
                        $meta_data['usage_limit'],
                        0
                    );
                    self::render_number_input(
                        __('Minimum Purchase', 'couponx'),
                        'minimum_purchase',
                        $meta_data['minimum_purchase'],
                        0,
                        100000,
                        '0.01'
                    );
                    self::render_checkbox(
                        __('New Customers Only', 'couponx'),
                        'new_customers_only',
                        $meta_data['new_customers_only']
                    );
                    self::render_media_upload(
                        __('Coupon Image', 'couponx'),
                        'coupon_image',
                        $meta_data['coupon_image']
                    );
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    /**
     * Save meta data
     */
    public static function save_meta_data($post_id, $post) {
        if (!isset($_POST['couponx_meta_nonce'])) return;
        if (!wp_verify_nonce($_POST['couponx_meta_nonce'], 'couponx_meta_action')) return;
        if (!current_user_can('edit_post', $post_id)) return;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if ('coupon' !== $post->post_type) return;

        $fields = array(
            'couponx_code'       => 'sanitize_text_field',
            'couponx_expiry'     => 'sanitize_text_field',
            'deal_code'          => 'sanitize_text_field',
            'printable'          => array(__CLASS__, 'sanitize_checkbox'),
            'rating'             => array(__CLASS__, 'sanitize_rating'),
            'discount_type'      => array(__CLASS__, 'sanitize_discount_type'),
            'discount_value'     => array(__CLASS__, 'sanitize_float'),
            'affiliate_url'      => 'esc_url_raw',
            'store_link'         => 'esc_url_raw',
            'usage_limit'        => 'absint',
            'minimum_purchase'   => array(__CLASS__, 'sanitize_float'),
            'new_customers_only' => array(__CLASS__, 'sanitize_checkbox'),
            'coupon_image'       => 'absint',
        );

        foreach ($fields as $key => $sanitizer) {
            $value = isset($_POST[$key]) ? $_POST[$key] : '';
            $clean_value = is_callable($sanitizer) ? call_user_func($sanitizer, $value) : $value;
            update_post_meta($post_id, "_{$key}", $clean_value);
        }

        self::validate_taxonomies($post_id);
    }

    /**
     * Custom sanitization methods
     */
    private static function sanitize_checkbox($value) {
        return isset($value) ? 'on' : 'off';
    }

    private static function sanitize_rating($value) {
        return max(1, min(5, absint($value)));
    }

    private static function sanitize_discount_type($value) {
        return in_array($value, array('percentage', 'fixed'), true) ? $value : 'percentage';
    }

    private static function sanitize_float($value) {
        return (float) filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }

    /**
     * Taxonomy validation
     */
   private static function validate_taxonomies($post_id) {
    $required_taxonomies = array('store', 'coupon_category');
    $missing = array();

    foreach ($required_taxonomies as $taxonomy) {
        $terms = get_the_terms($post_id, $taxonomy);
        if (empty($terms) || is_wp_error($terms)) {
            $tax_object = get_taxonomy($taxonomy);
            $missing[] = $tax_object->labels->singular_name;
        }
    }

    if (!empty($missing)) {
        wp_update_post(array(
            'ID' => $post_id,
            'post_status' => 'draft'
        ));
        set_transient('couponx_missing_tax', $missing, 30);
    }
}

    /**
     * Admin notices
     */
    public static function show_admin_notices() {
        if ($missing = get_transient('couponx_missing_tax')) {
            delete_transient('couponx_missing_tax');
            ?>
            <div class="notice notice-error">
                <p><?php printf(
                    __('Coupon requires at least one: %s', 'couponx'),
                    implode(', ', $missing)
                ); ?></p>
            </div>
            <?php
        }
    }

    /**
     * Helper methods for field rendering
     */
    private static function get_meta_defaults($post_id) {
        return array(
            'code'              => get_post_meta($post_id, '_couponx_code', true),
            'expiry'            => get_post_meta($post_id, '_couponx_expiry', true),
            'deal_code'         => get_post_meta($post_id, '_deal_code', true),
            'printable'         => get_post_meta($post_id, '_printable', true),
            'rating'            => get_post_meta($post_id, '_rating', true),
            'discount_type'     => get_post_meta($post_id, '_discount_type', true),
            'discount_value'    => get_post_meta($post_id, '_discount_value', true),
            'affiliate_url'     => get_post_meta($post_id, '_affiliate_url', true),
            'store_link'        => get_post_meta($post_id, '_store_link', true),
            'usage_limit'       => get_post_meta($post_id, '_usage_limit', true),
            'minimum_purchase'  => get_post_meta($post_id, '_minimum_purchase', true),
            'new_customers_only'=> get_post_meta($post_id, '_new_customers_only', true),
            'coupon_image'      => get_post_meta($post_id, '_coupon_image', true),
        );
    }

    private static function render_text_input($label, $name, $value, $class = '', $type = 'text') {
        ?>
        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr($name); ?>"><?php echo esc_html($label); ?></label>
            </th>
            <td>
                <input type="<?php echo esc_attr($type); ?>" 
                     id="<?php echo esc_attr($name); ?>" 
                     name="<?php echo esc_attr($name); ?>" 
                     value="<?php echo esc_attr($value); ?>" 
                     class="<?php echo esc_attr($class); ?>">
            </td>
        </tr>
        <?php
    }

    private static function render_date_input($label, $name, $value) {
        ?>
        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr($name); ?>"><?php echo esc_html($label); ?></label>
            </th>
            <td>
                <input type="date" 
                     id="<?php echo esc_attr($name); ?>" 
                     name="<?php echo esc_attr($name); ?>" 
                     value="<?php echo esc_attr($value); ?>">
            </td>
        </tr>
        <?php
    }

    private static function render_number_input($label, $name, $value, $min = 0, $max = '', $step = '1') {
        ?>
        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr($name); ?>"><?php echo esc_html($label); ?></label>
            </th>
            <td>
                <input type="number" 
                     id="<?php echo esc_attr($name); ?>" 
                     name="<?php echo esc_attr($name); ?>" 
                     value="<?php echo esc_attr($value); ?>" 
                     min="<?php echo esc_attr($min); ?>"
                     max="<?php echo esc_attr($max); ?>"
                     step="<?php echo esc_attr($step); ?>">
            </td>
        </tr>
        <?php
    }

    private static function render_checkbox($label, $name, $value) {
        ?>
        <tr>
            <th scope="row"><?php echo esc_html($label); ?></th>
            <td>
                <input type="checkbox" 
                     id="<?php echo esc_attr($name); ?>"
                     name="<?php echo esc_attr($name); ?>"
                     <?php checked($value, 'on'); ?>>
            </td>
        </tr>
        <?php
    }

    private static function render_select_input($label, $name, $selected, $options) {
        ?>
        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr($name); ?>"><?php echo esc_html($label); ?></label>
            </th>
            <td>
                <select id="<?php echo esc_attr($name); ?>" name="<?php echo esc_attr($name); ?>">
                    <?php foreach ($options as $value => $text) : ?>
                        <option value="<?php echo esc_attr($value); ?>" <?php selected($selected, $value); ?>>
                            <?php echo esc_html($text); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <?php
    }

    private static function render_media_upload($label, $name, $value) {
        $image_url = $value ? wp_get_attachment_url($value) : '';
        ?>
        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr($name); ?>"><?php echo esc_html($label); ?></label>
            </th>
            <td>
                <input type="hidden" 
                     id="<?php echo esc_attr($name); ?>" 
                     name="<?php echo esc_attr($name); ?>" 
                     value="<?php echo esc_attr($value); ?>">
                <div class="couponx-image-preview">
                    <?php if ($image_url) : ?>
                        <img src="<?php echo esc_url($image_url); ?>" style="max-width: 200px; height: auto;">
                    <?php endif; ?>
                </div>
                <button type="button" class="button couponx-upload-image">
                    <?php esc_html_e('Upload Image', 'couponx'); ?>
                </button>
                <button type="button" class="button couponx-remove-image" 
                     <?php echo !$value ? 'style="display:none;"' : ''; ?>>
                    <?php esc_html_e('Remove Image', 'couponx'); ?>
                </button>
            </td>
        </tr>
        <?php
    }

    /**
     * Admin scripts and styles
     */
  public static function admin_scripts($hook) {
        global $post_type;

        // Corrected the in_array condition
        if (in_array($hook, array('post-new.php', 'post.php'))) {
            if ('coupon' === $post_type) {
                wp_enqueue_media();
                wp_enqueue_script(
                    'couponx-admin',
                    get_template_directory_uri() . '/assets/js/admin.js',
                    array('jquery'),
                    '1.2.0',
                    true
                );
                wp_enqueue_style(
                    'couponx-admin',
                    get_template_directory_uri() . '/assets/css/admin.css',
                    array(),
                    '1.2.0'
                );
            }
        }
        
        
        
        
  }
}

} // End class_exists check

// Initialize with proper namespace reference
add_action('init', function() {
    \CouponX\CouponX_Meta_Boxes::init();
});