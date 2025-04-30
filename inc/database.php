<?php
/**
 * CouponX Full Integration
 * 
 * @package CouponX
 * @version 2.0.2
 */
namespace CouponX;
defined('ABSPATH') || exit;

/**
 * Database Setup Class
 */
if (!class_exists('CouponX\CouponX_Database')) {



class CouponX_Database {
    const DB_VERSION = '2.0.3';
    const DB_PREFIX = 'couponx_';

    public static function get_table_name() {
        global $wpdb;
        return $wpdb->prefix . self::DB_PREFIX . 'coupons';
    }

    public static function create_tables() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = self::get_table_name();

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $sql = "CREATE TABLE {$table_name} (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            post_id BIGINT(20) UNSIGNED NOT NULL,
            code VARCHAR(100) NOT NULL,
            deal_code VARCHAR(100) DEFAULT NULL,
            expiry_date DATE NOT NULL,
            rating TINYINT(1) UNSIGNED DEFAULT 0,
            discount_type VARCHAR(20) NOT NULL,
            discount_value DECIMAL(10,2) NOT NULL,
            usage_limit INT(10) DEFAULT 0,
            usage_count INT(10) DEFAULT 0,
            minimum_purchase DECIMAL(10,2) DEFAULT 0.00,
            is_featured TINYINT(1) DEFAULT 0,
            affiliate_url VARCHAR(255) DEFAULT NULL,
            store_link VARCHAR(255) DEFAULT NULL,
            printable TINYINT(1) DEFAULT 0,
            coupon_image VARCHAR(255) DEFAULT NULL,
            new_customers_only TINYINT(1) DEFAULT 0,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY post_id (post_id),
            KEY expiry_date (expiry_date),
            KEY is_featured (is_featured)
        ) $charset_collate;";

        dbDelta($sql);
        update_option('couponx_db_version', self::DB_VERSION);
    }

    public static function maybe_update_table() {
        global $wpdb;
        $table_name = self::get_table_name();

        $columns = $wpdb->get_col("SHOW COLUMNS FROM {$table_name}", 0);

        if (!in_array('deal_code', $columns)) {
            $wpdb->query("ALTER TABLE {$table_name} ADD COLUMN deal_code VARCHAR(100) DEFAULT NULL;");
        }

        if (!in_array('rating', $columns)) {
            $wpdb->query("ALTER TABLE {$table_name} ADD COLUMN rating TINYINT(1) UNSIGNED DEFAULT 0;");
        }
    }

    public static function activate_plugin() {
        self::create_tables();
        self::maybe_update_table();
    }

    public static function check_db_version() {
        if (get_option('couponx_db_version') !== self::DB_VERSION) {
            self::create_tables();
            if (!get_option('couponx_activated')) {
                update_option('couponx_show_activation_notice', true);
            }
            update_option('couponx_activated', true);
        }
    }

    public static function activation_notice() {
        if (get_option('couponx_show_activation_notice')) {
            ?>
            <div class="notice notice-success is-dismissible">
                <p><?php _e('CouponX database tables created successfully!', 'couponx'); ?></p>
            </div>
            <?php
            delete_option('couponx_show_activation_notice');
        }
    }

    // Add init() method to fix fatal error
    public static function init() {
        add_action('admin_notices', [__CLASS__, 'activation_notice']);
        self::check_db_version(); // Check and create/update tables if needed
    }

    // CRUD
    public static function insert_coupon($data) {
        global $wpdb;
        $defaults = array(
            'created_at' => current_time('mysql'),
            'updated_at' => current_time('mysql')
        );
        $data = wp_parse_args($data, $defaults);
        return $wpdb->insert(self::get_table_name(), $data);
    }

    public static function update_coupon($id, $data) {
        global $wpdb;
        $data['updated_at'] = current_time('mysql');
        return $wpdb->update(
            self::get_table_name(),
            $data,
            array('id' => $id)
        );
    }

    public static function get_coupon_by_post_id($post_id) {
        global $wpdb;
        return $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM " . self::get_table_name() . " WHERE post_id = %d", $post_id),
            ARRAY_A
        );
    }
}

// Initialize
CouponX_Database::init();
}



/**
 * Meta Boxes Class
 */
if (!class_exists('CouponX\CouponX_Meta_Boxes')) {

class CouponX_Meta_Boxes {
    public static function init() {
        add_action('add_meta_boxes', array(__CLASS__, 'add_meta_boxes'));
        add_action('save_post', array(__CLASS__, 'save_meta_data'), 10, 2);
        add_action('admin_enqueue_scripts', array(__CLASS__, 'admin_scripts'));
        add_action('admin_notices', array(__CLASS__, 'show_admin_notices'));
    }

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

    public static function meta_box_callback($post) {
        wp_nonce_field('couponx_meta_action', 'couponx_meta_nonce');
        $coupon_data = CouponX_Database::get_coupon_by_post_id($post->ID);
        ?>
        <div class="couponx-metabox-container">
            <table class="form-table">
                <tbody>
                    <?php
                    self::render_text_input(__('Coupon Code', 'couponx'), 'couponx_code', $coupon_data['code'] ?? '');
                    self::render_date_input(__('Expiry Date', 'couponx'), 'couponx_expiry', $coupon_data['expiry_date'] ?? '');
                    self::render_text_input(__('Deal Code', 'couponx'), 'deal_code', $coupon_data['deal_code'] ?? '');
                    self::render_checkbox(__('Printable Coupon', 'couponx'), 'printable', $coupon_data['printable'] ?? 0);
                    self::render_number_input(__('Rating (1-5)', 'couponx'), 'rating', $coupon_data['rating'] ?? 0, 1, 5);
                    self::render_select_input(
                        __('Discount Type', 'couponx'),
                        'discount_type',
                        $coupon_data['discount_type'] ?? 'percentage',
                        array(
                            'percentage' => __('Percentage', 'couponx'),
                            'fixed' => __('Fixed Amount', 'couponx')
                        )
                    );
                    self::render_number_input(
                        __('Discount Value', 'couponx'),
                        'discount_value',
                        $coupon_data['discount_value'] ?? 0,
                        0,
                        10000,
                        '0.01'
                    );
                    self::render_text_input(
                        __('Affiliate URL', 'couponx'),
                        'affiliate_url',
                        $coupon_data['affiliate_url'] ?? '',
                        'widefat',
                        'url'
                    );
                    self::render_text_input(
                        __('Store Link', 'couponx'),
                        'store_link',
                        $coupon_data['store_link'] ?? '',
                        'widefat',
                        'url'
                    );
                    self::render_number_input(
                        __('Usage Limit', 'couponx'),
                        'usage_limit',
                        $coupon_data['usage_limit'] ?? 0,
                        0
                    );
                    self::render_number_input(
                        __('Minimum Purchase', 'couponx'),
                        'minimum_purchase',
                        $coupon_data['minimum_purchase'] ?? 0,
                        0,
                        100000,
                        '0.01'
                    );
                    self::render_checkbox(
                        __('New Customers Only', 'couponx'),
                        'new_customers_only',
                        $coupon_data['new_customers_only'] ?? 0
                    );
                    self::render_media_upload(
                        __('Coupon Image', 'couponx'),
                        'coupon_image',
                        $coupon_data['coupon_image'] ?? ''
                    );
                    self::render_taxonomy_select('Store', 'store', $post->ID);
                    self::render_taxonomy_select('Category', 'coupon_category', $post->ID);
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    public static function save_meta_data($post_id, $post) {
        if (!isset($_POST['couponx_meta_nonce']) ||
            !wp_verify_nonce($_POST['couponx_meta_nonce'], 'couponx_meta_action') ||
            !current_user_can('edit_post', $post_id) ||
            (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) ||
            $post->post_type !== 'coupon'
        ) return;

        $coupon_data = array(
            'post_id' => $post_id,
            'code' => sanitize_text_field($_POST['couponx_code']),
            'expiry_date' => sanitize_text_field($_POST['couponx_expiry']),
            'deal_code' => sanitize_text_field($_POST['deal_code']),
            'printable' => isset($_POST['printable']) ? 1 : 0,
            'rating' => max(1, min(5, absint($_POST['rating']))),
            'discount_type' => self::sanitize_discount_type($_POST['discount_type']),
            'discount_value' => (float) $_POST['discount_value'],
            'affiliate_url' => esc_url_raw($_POST['affiliate_url']),
            'store_link' => esc_url_raw($_POST['store_link']),
            'usage_limit' => absint($_POST['usage_limit']),
            'minimum_purchase' => (float) $_POST['minimum_purchase'],
            'new_customers_only' => isset($_POST['new_customers_only']) ? 1 : 0,
            'coupon_image' => absint($_POST['coupon_image'])
        );

        foreach (['store', 'coupon_category'] as $taxonomy) {
            if (isset($_POST[$taxonomy])) {
                wp_set_post_terms($post_id, (array) $_POST[$taxonomy], $taxonomy);
            }
        }

        $existing = CouponX_Database::get_coupon_by_post_id($post_id);
        $existing ? CouponX_Database::update_coupon($existing['id'], $coupon_data)
                  : CouponX_Database::insert_coupon($coupon_data);

        self::validate_taxonomies($post_id);
    }

    private static function validate_taxonomies($post_id) {
        $required = array('store', 'coupon_category');
        $missing = array();

        foreach ($required as $taxonomy) {
            if (!wp_get_post_terms($post_id, $taxonomy)) {
                $tax_object = get_taxonomy($taxonomy);
                $missing[] = $tax_object->labels->singular_name;
            }
        }

        if (!empty($missing)) {
            wp_update_post(array('ID' => $post_id, 'post_status' => 'draft'));
            set_transient('couponx_missing_tax', $missing, 30);
        }
    }

    public static function show_admin_notices() {
        if ($missing = get_transient('couponx_missing_tax')) {
            delete_transient('couponx_missing_tax');
            ?>
            <div class="notice notice-error">
                <p><?php printf(
                    __('Coupon requires: %s', 'couponx'),
                    implode(', ', $missing)
                ); ?></p>
            </div>
            <?php
        }
    }

    // Field Rendering Methods
    private static function render_text_input($label, $name, $value, $class = 'widefat', $type = 'text') {
        ?>
        <tr>
            <th><label><?php echo esc_html($label); ?></label></th>
            <td>
                <input type="<?php echo esc_attr($type); ?>" 
                       name="<?php echo esc_attr($name); ?>" 
                       value="<?php echo esc_attr($value); ?>" 
                       class="<?php echo esc_attr($class); ?>">
            </td>
        </tr>
        <?php
    }

    private static function render_date_input($label, $name, $value) {
        self::render_text_input($label, $name, $value, 'widefat', 'date');
    }

    private static function render_number_input($label, $name, $value, $min = 0, $max = 10000, $step = 1) {
        ?>
        <tr>
            <th><label><?php echo esc_html($label); ?></label></th>
            <td>
                <input type="number" 
                       name="<?php echo esc_attr($name); ?>" 
                       value="<?php echo esc_attr($value); ?>"
                       min="<?php echo esc_attr($min); ?>"
                       max="<?php echo esc_attr($max); ?>"
                       step="<?php echo esc_attr($step); ?>"
                       class="widefat">
            </td>
        </tr>
        <?php
    }

    private static function render_checkbox($label, $name, $value) {
        ?>
        <tr>
            <th><?php echo esc_html($label); ?></th>
            <td>
                <input type="checkbox" 
                       name="<?php echo esc_attr($name); ?>" 
                    <?php checked($value, 1); ?> value="1">
            </td>
        </tr>
        <?php
    }

    private static function render_select_input($label, $name, $selected, $options) {
        ?>
        <tr>
            <th><label><?php echo esc_html($label); ?></label></th>
            <td>
                <select name="<?php echo esc_attr($name); ?>" class="widefat">
                    <?php foreach ($options as $value => $text) : ?>
                        <option value="<?php echo esc_attr($value); ?>" 
                            <?php selected($selected, $value); ?>>
                            <?php echo esc_html($text); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <?php
    }

    private static function render_taxonomy_select($label, $taxonomy, $post_id) {
        $terms = get_terms(array('taxonomy' => $taxonomy, 'hide_empty' => false));
        $selected = wp_get_post_terms($post_id, $taxonomy, array('fields' => 'ids'));
        ?>
        <tr>
            <th><label><?php echo esc_html($label); ?></label></th>
            <td>
                <select name="<?php echo esc_attr($taxonomy); ?>[]" class="widefat" multiple>
                    <?php foreach ($terms as $term) : ?>
                        <option value="<?php echo esc_attr($term->term_id); ?>" 
                            <?php selected(in_array($term->term_id, $selected)); ?>>
                            <?php echo esc_html($term->name); ?>
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
            <th><label><?php echo esc_html($label); ?></label></th>
            <td>
                <input type="hidden" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($value); ?>">
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

    public static function admin_scripts($hook) {
    if (!in_array($hook, array('post-new.php', 'post.php'))) return;

    global $post_type;
    if ('coupon' !== $post_type) return;

    wp_enqueue_media();
    wp_enqueue_script(
        'couponx-admin',
        get_template_directory_uri() . '/assets/js/admin.js',
        array('jquery'),
        '2.0.0',
        true
    );
    wp_enqueue_style(
        'couponx-admin',
        get_template_directory_uri() . '/assets/css/admin.css',
        array(),
        '2.0.0'
    );
}


    private static function sanitize_discount_type($value) {
        return in_array($value, array('percentage', 'fixed')) ? $value : 'percentage';
    }
}

CouponX_Meta_Boxes::init();
}

// Template Functions
if (!function_exists('couponx_get_coupon')) {
    function couponx_get_coupon($post_id) {
        return CouponX_Database::get_coupon_by_post_id($post_id);
    }
}

if (!function_exists('couponx_get_featured_coupons')) {
    function couponx_get_featured_coupons($limit = 5) {
        global $wpdb;
        $table_name = CouponX_Database::get_table_name();
        return $wpdb->get_results(
            $wpdb->prepare("SELECT * FROM {$table_name} WHERE is_featured = 1 LIMIT %d", $limit),
            ARRAY_A
        );
    }
}