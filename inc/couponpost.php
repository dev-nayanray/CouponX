<?php
/**
 * Enhanced CouponX Content Types with Image Support
 * 
 * @package CouponX
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

class CouponX_Content_Types {

    public function __construct() {
        add_action( 'init', array( $this, 'register_content_types' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
        add_action( 'init', array( $this, 'add_taxonomy_image_support' ) );
    }

    /**
     * Register all custom content types
     */
    public function register_content_types() {
        $this->register_coupon_post_type();
        $this->register_store_taxonomy();
        $this->register_coupon_category_taxonomy();
        $this->register_coupon_tag_taxonomy();
    }

    /**
     * Register Coupon post type
     */
    private function register_coupon_post_type() {
        $args = array(
            'label'               => __( 'Coupon', 'couponx' ),
            'description'         => __( 'Coupon entries', 'couponx' ),
            'labels'              => $this->get_coupon_labels(),
            'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'excerpt' ),
            'taxonomies'          => array( 'store', 'coupon_category', 'coupon_tag' ),
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-tag',
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'show_in_rest'        => true,
            'capability_type'     => 'post',
            'rewrite'             => array( 'slug' => 'coupons' ),
        );

        register_post_type( 'coupon', $args );
    }

    /**
     * Register Store taxonomy
     */
    private function register_store_taxonomy() {
        $args = array(
            'labels'            => $this->get_store_labels(),
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud'     => true,
            'show_in_rest'      => true,
            'rewrite'           => array( 'slug' => 'stores' ),
        );

        register_taxonomy( 'store', 'coupon', $args );
    }

    /**
     * Register Coupon Category taxonomy
     */
    private function register_coupon_category_taxonomy() {
        $args = array(
            'labels'            => $this->get_category_labels(),
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'rewrite'           => array( 'slug' => 'coupon-category' ),
        );

        register_taxonomy( 'coupon_category', 'coupon', $args );
    }

    /**
     * Register Coupon Tag taxonomy
     */
    private function register_coupon_tag_taxonomy() {
        $args = array(
            'labels'            => $this->get_tag_labels(),
            'hierarchical'      => false,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'rewrite'           => array( 'slug' => 'coupon-tag' ),
        );

        register_taxonomy( 'coupon_tag', 'coupon', $args );
    }

    /**
     * Add image support to taxonomies
     */
    public function add_taxonomy_image_support() {
        $taxonomies = array( 'store', 'coupon_category' );
        
        foreach ( $taxonomies as $taxonomy ) {
            add_filter( "manage_edit-{$taxonomy}_columns", array( $this, 'add_image_column' ) );
            add_filter( "manage_{$taxonomy}_custom_column", array( $this, 'show_image_column' ), 10, 3 );
            add_action( "{$taxonomy}_add_form_fields", array( $this, 'add_taxonomy_image_field' ) );
            add_action( "{$taxonomy}_edit_form_fields", array( $this, 'edit_taxonomy_image_field' ), 10, 2 );
            add_action( "created_{$taxonomy}", array( $this, 'save_taxonomy_image' ) );
            add_action( "edited_{$taxonomy}", array( $this, 'save_taxonomy_image' ) );
        }
    }

   /**
 * Enqueue admin assets
 */
public function enqueue_admin_assets( $hook ) {
    // Only enqueue on taxonomy term pages
    if ( in_array( $hook, array( 'edit-tags.php', 'term.php' ) ) ) {
        wp_enqueue_media();
        
        wp_enqueue_script(
            'couponx-taxonomy-image',
            get_template_directory_uri() . '/assets/js/admin-taxonomy.js',
            array( 'jquery' ),
            '2.0.0',
            true
        );
        
        wp_enqueue_style(
            'couponx-taxonomy-admin',
            get_template_directory_uri() . '/assets/css/admin-taxonomy.css',
            array(),
            '2.0.0'
        );
    }
}


    /**
     * Label generators with complete WordPress standard labels
     */
    private function get_coupon_labels() {
        return array(
            'name'                  => _x( 'Coupons', 'Post Type General Name', 'couponx' ),
            'singular_name'         => _x( 'Coupon', 'Post Type Singular Name', 'couponx' ),
            'menu_name'             => __( 'Coupons', 'couponx' ),
            'name_admin_bar'        => __( 'Coupon', 'couponx' ),
            'archives'              => __( 'Coupon Archives', 'couponx' ),
            'attributes'            => __( 'Coupon Attributes', 'couponx' ),
            'parent_item_colon'     => __( 'Parent Coupon:', 'couponx' ),
            'all_items'             => __( 'All Coupons', 'couponx' ),
            'add_new_item'          => __( 'Add New Coupon', 'couponx' ),
            'add_new'               => __( 'Add New', 'couponx' ),
            'new_item'              => __( 'New Coupon', 'couponx' ),
            'edit_item'             => __( 'Edit Coupon', 'couponx' ),
            'update_item'           => __( 'Update Coupon', 'couponx' ),
            'view_item'             => __( 'View Coupon', 'couponx' ),
            'view_items'            => __( 'View Coupons', 'couponx' ),
            'search_items'          => __( 'Search Coupons', 'couponx' ),
            'not_found'             => __( 'No coupons found', 'couponx' ),
            'not_found_in_trash'   => __( 'No coupons found in Trash', 'couponx' ),
            'featured_image'        => __( 'Coupon Image', 'couponx' ),
            'set_featured_image'    => __( 'Set coupon image', 'couponx' ),
            'remove_featured_image' => __( 'Remove coupon image', 'couponx' ),
            'use_featured_image'    => __( 'Use as coupon image', 'couponx' ),
            'insert_into_item'      => __( 'Insert into coupon', 'couponx' ),
            'uploaded_to_this_item' => __( 'Uploaded to this coupon', 'couponx' ),
            'items_list'            => __( 'Coupons list', 'couponx' ),
            'items_list_navigation' => __( 'Coupons list navigation', 'couponx' ),
            'filter_items_list'     => __( 'Filter coupons list', 'couponx' ),
        );
    }

    private function get_store_labels() {
        return array(
            'name'              => _x( 'Stores', 'taxonomy general name', 'couponx' ),
            'singular_name'     => _x( 'Store', 'taxonomy singular name', 'couponx' ),
            'search_items'      => __( 'Search Stores', 'couponx' ),
            'all_items'         => __( 'All Stores', 'couponx' ),
            'parent_item'       => __( 'Parent Store', 'couponx' ),
            'parent_item_colon' => __( 'Parent Store:', 'couponx' ),
            'edit_item'         => __( 'Edit Store', 'couponx' ),
            'update_item'       => __( 'Update Store', 'couponx' ),
            'add_new_item'      => __( 'Add New Store', 'couponx' ),
            'new_item_name'     => __( 'New Store Name', 'couponx' ),
            'menu_name'         => __( 'Stores', 'couponx' ),
            'view_item'         => __( 'View Store', 'couponx' ),
            'popular_items'      => __( 'Popular Stores', 'couponx' ),
            'separate_items_with_commas' => __( 'Separate stores with commas', 'couponx' ),
            'add_or_remove_items' => __( 'Add or remove stores', 'couponx' ),
            'choose_from_most_used' => __( 'Choose from the most used stores', 'couponx' ),
            'not_found'          => __( 'No stores found', 'couponx' ),
            'back_to_items'      => __( '← Back to stores', 'couponx' ),
        );
    }

    private function get_category_labels() {
        return array(
            'name'              => _x( 'Categories', 'taxonomy general name', 'couponx' ),
            'singular_name'     => _x( 'Category', 'taxonomy singular name', 'couponx' ),
            'search_items'      => __( 'Search Categories', 'couponx' ),
            'all_items'         => __( 'All Categories', 'couponx' ),
            'parent_item'       => __( 'Parent Category', 'couponx' ),
            'parent_item_colon' => __( 'Parent Category:', 'couponx' ),
            'edit_item'         => __( 'Edit Category', 'couponx' ),
            'update_item'       => __( 'Update Category', 'couponx' ),
            'add_new_item'      => __( 'Add New Category', 'couponx' ),
            'new_item_name'     => __( 'New Category Name', 'couponx' ),
            'menu_name'         => __( 'Categories', 'couponx' ),
            'view_item'         => __( 'View Category', 'couponx' ),
            'popular_items'      => __( 'Popular Categories', 'couponx' ),
            'separate_items_with_commas' => __( 'Separate categories with commas', 'couponx' ),
            'add_or_remove_items' => __( 'Add or remove categories', 'couponx' ),
            'choose_from_most_used' => __( 'Choose from the most used categories', 'couponx' ),
            'not_found'          => __( 'No categories found', 'couponx' ),
            'back_to_items'      => __( '← Back to categories', 'couponx' ),
        );
    }

    private function get_tag_labels() {
        return array(
            'name'              => _x( 'Tags', 'taxonomy general name', 'couponx' ),
            'singular_name'     => _x( 'Tag', 'taxonomy singular name', 'couponx' ),
            'search_items'      => __( 'Search Tags', 'couponx' ),
            'all_items'         => __( 'All Tags', 'couponx' ),
            'parent_item'       => __( 'Parent Tag', 'couponx' ),
            'parent_item_colon' => __( 'Parent Tag:', 'couponx' ),
            'edit_item'         => __( 'Edit Tag', 'couponx' ),
            'update_item'       => __( 'Update Tag', 'couponx' ),
            'add_new_item'      => __( 'Add New Tag', 'couponx' ),
            'new_item_name'     => __( 'New Tag Name', 'couponx' ),
            'menu_name'         => __( 'Tags', 'couponx' ),
            'popular_items'      => __( 'Popular Tags', 'couponx' ),
            'separate_items_with_commas' => __( 'Separate tags with commas', 'couponx' ),
            'add_or_remove_items' => __( 'Add or remove tags', 'couponx' ),
            'choose_from_most_used' => __( 'Choose from the most used tags', 'couponx' ),
            'not_found'          => __( 'No tags found', 'couponx' ),
            'back_to_items'      => __( '← Back to tags', 'couponx' ),
        );
    }

    /**
     * Taxonomy image methods
     */
    public function add_image_column( $columns ) {
        $columns['taxonomy_image'] = __( 'Image', 'couponx' );
        return $columns;
    }

    public function show_image_column( $content, $column_name, $term_id ) {
        if ( 'taxonomy_image' !== $column_name ) {
            return $content;
        }
        
        $image_id = get_term_meta( $term_id, 'taxonomy_image_id', true );
        return $image_id ? wp_get_attachment_image( $image_id, 'thumbnail', false, array( 'class' => 'taxonomy-image-thumb' ) ) : '';
    }

    public function add_taxonomy_image_field( $taxonomy ) {
        wp_nonce_field( 'couponx_taxonomy_image', 'couponx_taxonomy_image_nonce' );
        ?>
        <div class="form-field term-group">
            <label for="taxonomy-image-id"><?php esc_html_e( 'Image', 'couponx' ); ?></label>
            <input type="hidden" id="taxonomy-image-id" name="taxonomy_image_id" value="">
            <div id="taxonomy-image-wrapper" class="taxonomy-image-preview"></div>
            <p class="taxonomy-image-buttons">
                <button type="button" class="button button-secondary ct-tax-media-button" id="ct-media-button">
                    <?php esc_html_e( 'Add Image', 'couponx' ); ?>
                </button>
                <button type="button" class="button button-secondary ct-tax-media-remove">
                    <?php esc_html_e( 'Remove Image', 'couponx' ); ?>
                </button>
            </p>
        </div>
        <?php
    }

    public function edit_taxonomy_image_field( $term, $taxonomy ) {
        wp_nonce_field( 'couponx_taxonomy_image', 'couponx_taxonomy_image_nonce' );
        $image_id = get_term_meta( $term->term_id, 'taxonomy_image_id', true );
        ?>
        <tr class="form-field term-group">
            <th scope="row">
                <label for="taxonomy-image-id"><?php esc_html_e( 'Image', 'couponx' ); ?></label>
            </th>
            <td>
                <input type="hidden" id="taxonomy-image-id" name="taxonomy_image_id" value="<?php echo esc_attr( $image_id ); ?>">
                <div id="taxonomy-image-wrapper" class="taxonomy-image-preview">
                    <?php if ( $image_id ) : ?>
                        <?php echo wp_kses_post( wp_get_attachment_image( $image_id, 'thumbnail' ) ); ?>
                    <?php endif; ?>
                </div>
                <p class="taxonomy-image-buttons">
                    <button type="button" class="button button-secondary ct-tax-media-button" id="ct-media-button">
                        <?php esc_html_e( 'Add Image', 'couponx' ); ?>
                    </button>
                    <button type="button" class="button button-secondary ct-tax-media-remove">
                        <?php esc_html_e( 'Remove Image', 'couponx' ); ?>
                    </button>
                </p>
            </td>
        </tr>
        <?php
    }

    public function save_taxonomy_image( $term_id ) {
        if ( ! isset( $_POST['couponx_taxonomy_image_nonce'] ) ) {
            return;
        }
        
        if ( ! wp_verify_nonce( $_POST['couponx_taxonomy_image_nonce'], 'couponx_taxonomy_image' ) ) {
            return;
        }

        if ( ! current_user_can( 'edit_term', $term_id ) ) {
            return;
        }

        $old_image = get_term_meta( $term_id, 'taxonomy_image_id', true );
        $new_image = isset( $_POST['taxonomy_image_id'] ) ? absint( $_POST['taxonomy_image_id'] ) : '';

        if ( $new_image && $new_image !== $old_image ) {
            update_term_meta( $term_id, 'taxonomy_image_id', $new_image );
        } elseif ( '' === $new_image && $old_image ) {
            delete_term_meta( $term_id, 'taxonomy_image_id' );
        }
    }
    /**
 * Admin scripts and styles
 */
public static function admin_scripts($hook) {
    global $post_type;

    // Fixed line: Added missing closing parenthesis
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

// Initialize the content types
new CouponX_Content_Types();