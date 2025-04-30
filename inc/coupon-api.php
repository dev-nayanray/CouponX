<?php
/**
 * CouponX Custom API Endpoints
 *
 * @package CouponX
 */

/**
 * Register custom REST API endpoints
 */
add_action(
	'rest_api_init',
	function () {
		// Get all coupons.
		register_rest_route(
			'couponx/v1',
			'/coupons',
			array(
				'methods'             => 'GET',
				'callback'            => 'couponx_get_coupons',
				'permission_callback' => '__return_true',
			)
		);

		// Get single coupon by ID.
		register_rest_route(
			'couponx/v1',
			'/coupon/(?P<id>\d+)',
			array(
				'methods'             => 'GET',
				'callback'            => 'couponx_get_single_coupon',
				'args'                => array(
					'id' => array(
						'validate_callback' => function( $param ) {
							return is_numeric( $param );
						},
					),
				),
				'permission_callback' => '__return_true',
			)
		);

		// Search coupons.
		register_rest_route(
			'couponx/v1',
			'/coupons/search',
			array(
				'methods'             => 'GET',
				'callback'            => 'couponx_search_coupons',
				'args'                => array(
					'term' => array(
						'required'          => true,
						'validate_callback' => function( $param ) {
							return ! empty( $param );
						},
					),
				),
				'permission_callback' => '__return_true',
			)
		);
	}
);

/**
 * Get coupons via REST API
 *
 * @param WP_REST_Request $request REST request object.
 * @return WP_REST_Response
 */
function couponx_get_coupons( WP_REST_Request $request ) {
	$params    = $request->get_params();
	$per_page  = isset( $params['per_page'] ) ? absint( $params['per_page'] ) : 10;
	$page      = isset( $params['page'] ) ? absint( $params['page'] ) : 1;
	$coupons   = array();
	$post_args = array(
		'post_type'      => 'coupon',
		'posts_per_page' => $per_page,
		'paged'          => $page,
		'post_status'    => 'publish',
	);

	$query = new WP_Query( $post_args );

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$coupon_id = get_the_ID();

			// Process taxonomy terms.
			$store_terms    = get_the_terms( $coupon_id, 'store' );
			$category_terms = get_the_terms( $coupon_id, 'coupon_category' );

			$coupons[] = array(
				'id'       => $coupon_id,
				'title'    => get_the_title(),
				'content'  => apply_filters( 'the_content', get_the_content() ),
				'excerpt'  => get_the_excerpt(),
				'permalink' => esc_url( get_permalink() ),
				'meta'     => array(
					'coupon_code'     => sanitize_text_field( get_post_meta( $coupon_id, 'coupon_code', true ) ),
					'expiration_date' => sanitize_text_field( get_post_meta( $coupon_id, 'expiration_date', true ) ),
					'discount_type'   => sanitize_text_field( get_post_meta( $coupon_id, 'discount_type', true ) ),
					'deal_url'       => esc_url_raw( get_post_meta( $coupon_id, 'deal_url', true ) ),
					'store'          => $store_terms ? array_map(
						function( $term ) {
							return array(
								'id'   => $term->term_id,
								'name' => sanitize_text_field( $term->name ),
								'slug' => sanitize_title( $term->slug ),
								'link' => esc_url( get_term_link( $term ) ),
							);
						},
						$store_terms
					) : array(),
					'category'       => $category_terms ? array_map(
						function( $term ) {
							return array(
								'id'   => $term->term_id,
								'name' => sanitize_text_field( $term->name ),
								'slug' => sanitize_title( $term->slug ),
								'link' => esc_url( get_term_link( $term ) ),
							);
						},
						$category_terms
					) : array(),
				),
			);
		}
	}

	wp_reset_postdata();

	return new WP_REST_Response(
		array(
			'total'        => $query->found_posts,
			'pages'        => $query->max_num_pages,
			'current_page' => $page,
			'per_page'     => $per_page,
			'coupons'      => $coupons,
		),
		200
	);
}

/**
 * Get single coupon details
 *
 * @param WP_REST_Request $request REST request object.
 * @return WP_REST_Response|WP_Error
 */
function couponx_get_single_coupon( WP_REST_Request $request ) {
	$coupon_id = absint( $request->get_param( 'id' ) );

	if ( ! get_post( $coupon_id ) || 'coupon' !== get_post_type( $coupon_id ) ) {
		return new WP_Error(
			'invalid_coupon',
			esc_html__( 'Coupon not found', 'couponx' ),
			array( 'status' => 404 )
		);
	}

	// Process taxonomy terms.
	$store_terms    = get_the_terms( $coupon_id, 'store' );
	$category_terms = get_the_terms( $coupon_id, 'coupon_category' );

	$coupon_data = array(
		'id'       => $coupon_id,
		'title'    => get_the_title( $coupon_id ),
		'content'  => apply_filters( 'the_content', get_post_field( 'post_content', $coupon_id ) ),
		'excerpt'  => get_post_field( 'post_excerpt', $coupon_id ),
		'permalink' => esc_url( get_permalink( $coupon_id ) ),
		'meta'     => array(
			'coupon_code'     => sanitize_text_field( get_post_meta( $coupon_id, 'coupon_code', true ) ),
			'expiration_date' => sanitize_text_field( get_post_meta( $coupon_id, 'expiration_date', true ) ),
			'discount_type'   => sanitize_text_field( get_post_meta( $coupon_id, 'discount_type', true ) ),
			'deal_url'        => esc_url_raw( get_post_meta( $coupon_id, 'deal_url', true ) ),
			'store'          => $store_terms ? array_map(
				function( $term ) {
					return array(
						'id'   => $term->term_id,
						'name' => sanitize_text_field( $term->name ),
						'slug' => sanitize_title( $term->slug ),
						'link' => esc_url( get_term_link( $term ) ),
					);
				},
				$store_terms
			) : array(),
			'category'       => $category_terms ? array_map(
				function( $term ) {
					return array(
						'id'   => $term->term_id,
						'name' => sanitize_text_field( $term->name ),
						'slug' => sanitize_title( $term->slug ),
						'link' => esc_url( get_term_link( $term ) ),
					);
				},
				$category_terms
			) : array(),
		),
	);

	return new WP_REST_Response( $coupon_data, 200 );
}

/**
 * Search coupons via REST API
 *
 * @param WP_REST_Request $request REST request object.
 * @return WP_REST_Response
 */
function couponx_search_coupons( WP_REST_Request $request ) {
	$search_term = sanitize_text_field( $request->get_param( 'term' ) );
	$results     = array();
	$post_args   = array(
		'post_type'      => 'coupon',
		'posts_per_page' => 10,
		's'              => $search_term,
		'post_status'    => 'publish',
	);

	$query = new WP_Query( $post_args );

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$coupon_id = get_the_ID();

			$results[] = array(
				'id'         => $coupon_id,
				'title'      => get_the_title(),
				'permalink'  => esc_url( get_permalink() ),
				'excerpt'    => get_the_excerpt(),
				'coupon_code' => sanitize_text_field( get_post_meta( $coupon_id, 'coupon_code', true ) ),
			);
		}
	}

	wp_reset_postdata();

	return new WP_REST_Response(
		array(
			'search_term' => $search_term,
			'count'       => $query->found_posts,
			'results'     => $results,
		),
		200
	);
}