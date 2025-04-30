// AJAX Coupon Code Reveal
add_action('wp_ajax_reveal_coupon_code', 'couponx_reveal_coupon_code');
add_action('wp_ajax_nopriv_reveal_coupon_code', 'couponx_reveal_coupon_code');
function couponx_reveal_coupon_code() {
    $coupon_id = isset($_POST['coupon_id']) ? intval($_POST['coupon_id']) : 0;
    $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
    
    if (!wp_verify_nonce($nonce, 'reveal_coupon_' . $coupon_id)) {
        wp_send_json_error(__('Invalid request', 'couponx'));
    }

    $coupon_code = get_post_meta($coupon_id, 'coupon_code', true);
    
    if($coupon_code) {
        wp_send_json_success(array('code' => $coupon_code));
    } else {
        wp_send_json_error(__('Coupon code not found', 'couponx'));
    }
}