<?php
/**
 * Plugin Name: WooCommerce Review Follow-up
 * Description: Send follow-up email after order completion.
 * Version: 1.0
 * Author: Vasim Shaikh
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

add_action( 'woocommerce_order_status_completed', 'wplt_send_review_followup_email_after_order_complete' );

function wplt_send_review_followup_email_after_order_complete( $order_id ) {
    $order = wc_get_order( $order_id );
    $order_date = $order->get_date_created();
    $order_date_timestamp = strtotime( $order_date );
    $current_date_timestamp = strtotime( date( 'Y-m-d H:i:s' ) );
    $difference = $current_date_timestamp - $order_date_timestamp;
    $days = floor( $difference / ( 60 * 60 * 24 ) );

    if ( $days == 7 ) { // Number of days until the email is sent
        $to = $order->get_billing_email();
        $subject = 'How was your order?';
        $message = 'Hey ' . $order->get_billing_first_name() . ',<br>How was your order? We\'d love to hear your feedback on <a href="trustpilot.com">TrustPilot here</a>';
        $headers = array( 'Content-Type: text/html; charset=UTF-8' );
        wp_mail( $to, $subject, $message, $headers );
    }
}
