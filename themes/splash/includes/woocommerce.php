<?php
// Declare Woo support
add_action( 'after_setup_theme', 'splash_woocommerce_support' );
function splash_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

//Remove Woo Breadcrumbs
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);

function splash_remove_woo_widgets() {
	unregister_widget( 'WC_Widget_Recent_Products' );
	unregister_widget( 'WC_Widget_Featured_Products' );
	//unregister_widget( 'WC_Widget_Product_Categories' );
	unregister_widget( 'WC_Widget_Product_Tag_Cloud' );
	//unregister_widget( 'WC_Widget_Cart' );
	unregister_widget( 'WC_Widget_Layered_Nav' );
	unregister_widget( 'WC_Widget_Layered_Nav_Filters' );
	//unregister_widget( 'WC_Widget_Price_Filter' );
	unregister_widget( 'WC_Widget_Product_Search' );
	//unregister_widget( 'WC_Widget_Top_Rated_Products' );
	unregister_widget( 'WC_Widget_Recent_Reviews' );
	unregister_widget( 'WC_Widget_Recently_Viewed' );
	unregister_widget( 'WC_Widget_Best_Sellers' );
	unregister_widget( 'WC_Widget_Onsale' );
	unregister_widget( 'WC_Widget_Random_Products' );
}
add_action( 'widgets_init', 'splash_remove_woo_widgets' );

add_filter( 'woocommerce_enqueue_styles', '__return_false' );

add_filter( 'woocommerce_show_page_title', '__return_false' );

add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );
add_filter( 'add_to_cart_fragments', 'splash_header_add_to_cart_fragment' );
function splash_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start();
	?>
	<span class="stm-current-items-in-cart"><?php echo intval($woocommerce->cart->cart_contents_count); ?></span>
	<?php
	$fragments['.stm-current-items-in-cart'] = ob_get_clean();

	return $fragments;
}

/*Removing actions*/
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' , 10 );

add_filter( 'woocommerce_checkout_fields' , 'splash_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function splash_override_checkout_fields( $fields ) {
	$fields['billing']['billing_first_name']['placeholder'] = esc_html__('First Name', 'splash');
	$fields['billing']['billing_last_name']['placeholder'] = esc_html__('Last Name', 'splash');
	$fields['billing']['billing_company']['placeholder'] = esc_html__('Company Name', 'splash');
	$fields['billing']['billing_email']['placeholder'] = esc_html__('Email', 'splash');
	$fields['billing']['billing_phone']['placeholder'] = esc_html__('Phone', 'splash');
	$fields['billing']['billing_city']['placeholder'] = esc_html__('Town/City', 'splash');
	$fields['billing']['billing_state']['placeholder'] = esc_html__('State/Country', 'splash');
	$fields['billing']['billing_postcode']['placeholder'] = esc_html__('Postcode/ZIP', 'splash');

	$fields['shipping']['shipping_first_name']['placeholder'] = esc_html__('First Name', 'splash');
	$fields['shipping']['shipping_last_name']['placeholder'] = esc_html__('Last Name', 'splash');
	$fields['shipping']['shipping_company']['placeholder'] = esc_html__('Company Name', 'splash');
	$fields['shipping']['shipping_city']['placeholder'] = esc_html__('Town/City', 'splash');
	$fields['shipping']['shipping_state']['placeholder'] = esc_html__('State/Country', 'splash');
	$fields['shipping']['shipping_postcode']['placeholder'] = esc_html__('Postcode/ZIP', 'splash');

	return $fields;
}