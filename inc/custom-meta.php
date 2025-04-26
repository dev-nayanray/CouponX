<?php
/**
 * CouponX Custom Meta Boxes
 * 
 * @package CouponX
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register meta boxes for coupon post type
 */
class CouponX_Meta_Boxes {

    /**
     * Initialize meta box functionality
     */
    public static function init() {
        add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_boxes' ) );
        add_action( 'save_post', array( __CLASS__, 'save_meta_data' ), 10, 2 );
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_scripts' ) );
        add_action( 'admin_notices', array( __CLASS__, 'show_admin_notices' ) );
    }

    /**
     * Add meta boxes to coupon post type
     */
    public static function add_meta_boxes() {
        add_meta_box(
            'couponx_details',
            __( 'Coupon Details', 'couponx' ),
            array( __CLASS__, 'meta_box_callback' ),
            'coupon',
            'normal',
            'high'
        );
    }

    /**
     * Meta box content
     */
    public static function meta_box_callback( $post ) {
        wp_nonce_field( 'couponx_meta_action', 'couponx_meta_nonce' );

        $meta_data = self::get_meta_defaults( $post->ID );
        ?>
        <div class="couponx-metabox-container">
            <table class="form-table">
                <tbody>
                    <?php 
                    self::render_text_input( __( 'Coupon Code', 'couponx' ), 'couponx_code', $meta_data['code'], 'widefat' );
                    self::render_date_input( __( 'Expiry Date', 'couponx' ), 'couponx_expiry', $meta_data['expiry'] );
                    self::render_text_input( __( 'Deal Code', 'couponx' ), 'deal_code', $meta_data['deal_code'], 'widefat' );
                    self::render_checkbox( __( 'Printable Coupon', 'couponx' ), 'printable', $meta_data['printable'] );
                    self::render_number_input( __( 'Rating (1-5)', 'couponx' ), 'rating', $meta_data['rating'], 1, 5 );
                    self::render_media_upload( __( 'Coupon Image', 'couponx' ), 'coupon_image_id', $meta_data['image_id'] );
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    /**
     * Save meta data
     */
    public static function save_meta_data( $post_id, $post ) {
        // Verify nonce and user capabilities
        if ( ! isset( $_POST['couponx_meta_nonce'] ) ) return;
        if ( ! wp_verify_nonce( $_POST['couponx_meta_nonce'], 'couponx_meta_action' ) ) return;
        if ( ! current_user_can( 'edit_post', $post_id ) ) return;
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
        if ( 'coupon' !== $post->post_type ) return;

        // Sanitize and save fields
        $fields = array(
            'couponx_code'     => 'sanitize_text_field',
            'couponx_expiry'   => 'sanitize_text_field',
            'deal_code'        => 'sanitize_text_field',
            'printable'        => array( __CLASS__, 'sanitize_checkbox' ),
            'rating'           => array( __CLASS__, 'sanitize_rating' ),
            'coupon_image_id'  => 'absint'
        );

        foreach ( $fields as $key => $sanitizer ) {
            $value = isset( $_POST[ $key ] ) ? $_POST[ $key ] : '';
            $clean_value = is_callable( $sanitizer ) ? call_user_func( $sanitizer, $value ) : $value;
            update_post_meta( $post_id, "_$key", $clean_value );
        }

        // Validate taxonomies
        self::validate_taxonomies( $post_id );
    }

    /**
     * Custom sanitization methods
     */
    private static function sanitize_checkbox( $value ) {
        return isset( $value ) ? 'on' : 'off';
    }

    private static function sanitize_rating( $value ) {
        $rating = absint( $value );
        return max( 1, min( 5, $rating ) );
    }

    /**
     * Taxonomy validation
     */
    private static function validate_taxonomies( $post_id ) {
        $required_taxonomies = array( 'store', 'coupon_category' );
        $missing = array();

        foreach ( $required_taxonomies as $taxonomy ) {
            if ( ! has_term( '', $taxonomy, $post_id ) ) {
                $tax_object = get_taxonomy( $taxonomy );
                $missing[] = $tax_object->labels->singular_name;
            }
        }

        if ( ! empty( $missing ) ) {
            // Prevent publishing
            wp_update_post( array(
                'ID' => $post_id,
                'post_status' => 'draft'
            ) );

            // Set admin notice
            set_transient( 'couponx_missing_tax', $missing, 30 );
        }
    }

    /**
     * Admin notices
     */
    public static function show_admin_notices() {
        if ( $missing = get_transient( 'couponx_missing_tax' ) ) {
            delete_transient( 'couponx_missing_tax' );
            ?>
            <div class="error notice">
                <p><?php printf(
                    __( 'Coupon requires at least one: %s', 'couponx' ),
                    implode( ', ', $missing )
                ); ?></p>
            </div>
            <?php
        }
    }

    /**
     * Helper methods for field rendering
     */
    private static function get_meta_defaults( $post_id ) {
        return array(
            'code'        => get_post_meta( $post_id, '_couponx_code', true ),
            'expiry'      => get_post_meta( $post_id, '_couponx_expiry', true ),
            'deal_code'   => get_post_meta( $post_id, '_deal_code', true ),
            'printable'   => get_post_meta( $post_id, '_printable', true ),
            'rating'      => get_post_meta( $post_id, '_rating', true ),
            'image_id'    => get_post_meta( $post_id, '_coupon_image_id', true )
        );
    }

    private static function render_text_input( $label, $name, $value, $class = '' ) {
        ?>
        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr( $name ); ?>"><?php echo esc_html( $label ); ?></label>
            </th>
            <td>
                <input type="text" id="<?php echo esc_attr( $name ); ?>" 
                       name="<?php echo esc_attr( $name ); ?>" 
                       value="<?php echo esc_attr( $value ); ?>" 
                       class="<?php echo esc_attr( $class ); ?>">
            </td>
        </tr>
        <?php
    }

    private static function render_date_input( $label, $name, $value ) {
        ?>
        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr( $name ); ?>"><?php echo esc_html( $label ); ?></label>
            </th>
            <td>
                <input type="date" id="<?php echo esc_attr( $name ); ?>" 
                       name="<?php echo esc_attr( $name ); ?>" 
                       value="<?php echo esc_attr( $value ); ?>">
            </td>
        </tr>
        <?php
    }

    private static function render_number_input( $label, $name, $value, $min, $max ) {
        ?>
        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr( $name ); ?>"><?php echo esc_html( $label ); ?></label>
            </th>
            <td>
                <input type="number" id="<?php echo esc_attr( $name ); ?>" 
                       name="<?php echo esc_attr( $name ); ?>" 
                       value="<?php echo esc_attr( $value ); ?>" 
                       min="<?php echo esc_attr( $min ); ?>" 
                       max="<?php echo esc_attr( $max ); ?>">
            </td>
        </tr>
        <?php
    }

    private static function render_checkbox( $label, $name, $value ) {
        ?>
        <tr>
            <th scope="row"><?php echo esc_html( $label ); ?></th>
            <td>
                <input type="checkbox" id="<?php echo esc_attr( $name ); ?>"
                       name="<?php echo esc_attr( $name ); ?>"
                       <?php checked( $value, 'on' ); ?>>
            </td>
        </tr>
        <?php
    }

    private static function render_media_upload( $label, $name, $value ) {
        $image_url = $value ? wp_get_attachment_image_url( $value, 'medium' ) : '';
        ?>
        <tr>
            <th scope="row"><?php echo esc_html( $label ); ?></th>
            <td>
                <div class="couponx-media-upload">
                    <input type="hidden" 
                           name="<?php echo esc_attr( $name ); ?>" 
                           id="<?php echo esc_attr( $name ); ?>" 
                           value="<?php echo esc_attr( $value ); ?>">
                    <div class="image-preview" style="margin: 1em 0">
                        <?php if ( $image_url ) : ?>
                            <img src="<?php echo esc_url( $image_url ); ?>" style="max-width: 200px; height: auto;">
                        <?php endif; ?>
                    </div>
                    <button type="button" class="button upload-image-btn">
                        <?php esc_html_e( 'Upload Image', 'couponx' ); ?>
                    </button>
                    <button type="button" class="button remove-image-btn" <?php echo $image_url ? '' : 'style="display:none;"'; ?>>
                        <?php esc_html_e( 'Remove Image', 'couponx' ); ?>
                    </button>
                </div>
            </td>
        </tr>
        <?php
    }

    /**
     * Admin scripts
     */
    public static function admin_scripts( $hook ) {
        global $post_type;

        if ( in_array( $hook, array( 'post-new.php', 'post.php' ) ) && 'coupon' === $post_type ) {
            wp_enqueue_media();
            wp_enqueue_script( 'couponx-admin', get_template_directory_uri() . '/assets/js/admin.js', array( 'jquery' ), '1.1.0', true );
            wp_enqueue_style( 'couponx-admin', get_template_directory_uri() . '/assets/css/admin.css', array(), '1.1.0' );
        }
    }
}

// Initialize meta box functionality
CouponX_Meta_Boxes::init();
