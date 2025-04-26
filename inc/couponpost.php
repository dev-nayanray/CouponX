<?php
/**
 * Register custom post type and taxonomies for CouponX
 */

// Register Custom Post Type and Taxonomies
add_action( 'init', 'couponx_register_content_types' );
function couponx_register_content_types() {
    // Coupon Post Type
    $coupon_labels = array(
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
        'not_found'             => __( 'Not found', 'couponx' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'couponx' ),
        'featured_image'        => __( 'Featured Image', 'couponx' ),
        'set_featured_image'    => __( 'Set featured image', 'couponx' ),
        'remove_featured_image' => __( 'Remove featured image', 'couponx' ),
        'use_featured_image'    => __( 'Use as featured image', 'couponx' ),
        'insert_into_item'      => __( 'Insert into coupon', 'couponx' ),
        'uploaded_to_this_item' => __( 'Uploaded to this coupon', 'couponx' ),
        'items_list'            => __( 'Coupons list', 'couponx' ),
        'items_list_navigation' => __( 'Coupons list navigation', 'couponx' ),
        'filter_items_list'     => __( 'Filter coupons list', 'couponx' ),
    );

    register_post_type( 'coupon', array(
        'label'                 => __( 'Coupon', 'couponx' ),
        'description'           => __( 'Coupon entries', 'couponx' ),
        'labels'                => $coupon_labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        'taxonomies'            => array( 'store', 'coupon_category', 'coupon_tag' ),
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-tag',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'show_in_rest'          => true,
        'capability_type'       => 'post',
    ) );

    // Store Taxonomy
    register_taxonomy( 'store', array( 'coupon' ), array(
        'labels'            => array(
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
        ),
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => true,
        'show_in_rest'      => true,
    ) );

    // Coupon Category Taxonomy
    register_taxonomy( 'coupon_category', array( 'coupon' ), array(
        'labels'            => array(
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
        ),
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
    ) );

    // Coupon Tag Taxonomy
    register_taxonomy( 'coupon_tag', array( 'coupon' ), array(
        'labels'            => array(
            'name'              => _x( 'Tags', 'taxonomy general name', 'couponx' ),
            'singular_name'     => _x( 'Tag', 'taxonomy singular name', 'couponx' ),
            'search_items'      => __( 'Search Tags', 'couponx' ),
            'all_items'         => __( 'All Tags', 'couponx' ),
            'edit_item'         => __( 'Edit Tag', 'couponx' ),
            'update_item'       => __( 'Update Tag', 'couponx' ),
            'add_new_item'      => __( 'Add New Tag', 'couponx' ),
            'new_item_name'     => __( 'New Tag Name', 'couponx' ),
            'menu_name'         => __( 'Tags', 'couponx' ),
        ),
        'hierarchical'      => false,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
    ) );
}

/**
 * Add image support for Store and Category taxonomies
 */
add_action( 'admin_enqueue_scripts', 'couponx_taxonomy_image_enqueue' );
function couponx_taxonomy_image_enqueue( $hook ) {
    if ( 'edit-tags.php' !== $hook && 'term.php' !== $hook ) {
        return;
    }
    
    wp_enqueue_media();
    wp_enqueue_script( 
        'couponx-taxonomy-image', 
        get_template_directory_uri() . '/js/admin-taxonomy.js', 
        array( 'jquery' ), 
        '1.0.0', 
        true 
    );
}

// Add image field to taxonomy tables
$taxonomies_with_images = array( 'store', 'coupon_category' );
foreach ( $taxonomies_with_images as $taxonomy ) {
    // Add image column to taxonomy table
    add_filter( "manage_edit-{$taxonomy}_columns", 'couponx_add_image_column' );
    add_filter( "manage_{$taxonomy}_custom_column", 'couponx_show_image_column', 10, 3 );
    
    // Add/Edit image fields
    add_action( "{$taxonomy}_add_form_fields", 'couponx_add_taxonomy_image_field' );
    add_action( "{$taxonomy}_edit_form_fields", 'couponx_edit_taxonomy_image_field', 10, 2 );
    add_action( "created_{$taxonomy}", 'couponx_save_taxonomy_image' );
    add_action( "edited_{$taxonomy}", 'couponx_save_taxonomy_image' );
}

// Add image column to taxonomy table
function couponx_add_image_column( $columns ) {
    $columns['taxonomy_image'] = __( 'Image', 'couponx' );
    return $columns;
}

// Show image in taxonomy table column
function couponx_show_image_column( $content, $column_name, $term_id ) {
    if ( 'taxonomy_image' === $column_name ) {
        $image_id = get_term_meta( $term_id, 'taxonomy_image_id', true );
        if ( $image_id ) {
            $content = wp_get_attachment_image( $image_id, 'thumbnail' );
        }
    }
    return $content;
}


$taxonomies_with_images = array( 'store', 'coupon_category' );
foreach ( $taxonomies_with_images as $taxonomy ) {
    add_action( "{$taxonomy}_add_form_fields", 'couponx_add_taxonomy_image_field' );
    add_action( "{$taxonomy}_edit_form_fields", 'couponx_edit_taxonomy_image_field', 10, 2 );
    add_action( "created_{$taxonomy}", 'couponx_save_taxonomy_image' );
    add_action( "edited_{$taxonomy}", 'couponx_save_taxonomy_image' );
}

function couponx_add_taxonomy_image_field( $taxonomy ) { ?>
    <div class="form-field term-group">
        <label for="taxonomy-image-id"><?php esc_html_e( 'Image', 'couponx' ); ?></label>
        <input type="hidden" id="taxonomy-image-id" name="taxonomy_image_id" class="regular-text" value="">
        <div id="taxonomy-image-wrapper"></div>
        <p>
            <input type="button" class="button button-secondary ct_tax_media_button" id="ct_media_button" name="ct_media_button" value="<?php esc_attr_e( 'Add Image', 'couponx' ); ?>" />
            <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_media_remove" name="ct_media_remove" value="<?php esc_attr_e( 'Remove Image', 'couponx' ); ?>" />
        </p>
        <?php wp_nonce_field( 'couponx_taxonomy_image', 'couponx_taxonomy_image_nonce' ); ?>
    </div>
<?php }

function couponx_edit_taxonomy_image_field( $term, $taxonomy ) {
    $image_id = get_term_meta( $term->term_id, 'taxonomy_image_id', true ); ?>
    <tr class="form-field term-group">
        <th scope="row">
            <label for="taxonomy-image-id"><?php esc_html_e( 'Image', 'couponx' ); ?></label>
        </th>
        <td>
            <input type="hidden" id="taxonomy-image-id" name="taxonomy_image_id" value="<?php echo esc_attr( $image_id ); ?>">
            <div id="taxonomy-image-wrapper">
                <?php if ( $image_id ) : ?>
                    <?php echo wp_get_attachment_image( $image_id, 'thumbnail' ); ?>
                <?php endif; ?>
            </div>
            <p>
                <input type="button" class="button button-secondary ct_tax_media_button" id="ct_media_button" name="ct_media_button" value="<?php esc_attr_e( 'Add Image', 'couponx' ); ?>" />
                <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_media_remove" name="ct_media_remove" value="<?php esc_attr_e( 'Remove Image', 'couponx' ); ?>" />
            </p>
            <?php wp_nonce_field( 'couponx_taxonomy_image', 'couponx_taxonomy_image_nonce' ); ?>
        </td>
    </tr>
<?php }

function couponx_save_taxonomy_image( $term_id ) {
    if ( ! isset( $_POST['couponx_taxonomy_image_nonce'] ) || ! wp_verify_nonce( $_POST['couponx_taxonomy_image_nonce'], 'couponx_taxonomy_image' ) ) {
        return;
    }

    if ( current_user_can( 'edit_term', $term_id ) ) {
        $old_image = get_term_meta( $term_id, 'taxonomy_image_id', true );
        $new_image = isset( $_POST['taxonomy_image_id'] ) ? absint( $_POST['taxonomy_image_id'] ) : '';

        if ( $new_image && $new_image !== $old_image ) {
            update_term_meta( $term_id, 'taxonomy_image_id', $new_image );
        } elseif ( '' === $new_image && $old_image ) {
            delete_term_meta( $term_id, 'taxonomy_image_id', $old_image );
        }
    }
}

