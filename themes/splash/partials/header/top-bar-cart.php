<?php
if( function_exists('WC')) {
	$woocommerce_shop_page_id = WC()->cart->get_cart_url();
	$top_bar_enable_cart = get_theme_mod('top_bar_enable_cart', true);
}
?>

<?php if(!empty($woocommerce_shop_page_id) and $top_bar_enable_cart): ?>
	<?php $items = WC()->cart->cart_contents_count; ?>
	<!--Shop archive-->
	<div class="help-bar-shop heading-font">
		<a href="<?php echo esc_url($woocommerce_shop_page_id); ?>" title="<?php esc_html_e('Watch shop items', 'splash'); ?>">
			<i class="fa fa-shopping-cart"></i>
			<span class="list-label"><?php esc_html_e('Cart', 'splash'); ?></span>
			<span class="list-badge"><span class="stm-current-items-in-cart"><?php echo esc_attr($items); ?></span></span>
		</a>
	</div>
<?php endif; ?>