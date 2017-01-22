<?php

$post_id = get_the_ID();
$current_page = get_queried_object();


if(!empty($current_page->ID) and $current_page->ID == get_option( 'page_for_posts' )) {
	$post_id = get_option('page_for_posts');
}

$title = '';
$show_breadcrumbs = true;

$is_shop = false;
$is_product = false;
$is_product_category = false;

if( function_exists( 'is_shop' ) && is_shop() ){
	$is_shop = true;
}

if( function_exists( 'is_product_category' ) && is_product_category() ){
	$is_product_category = true;
}

if( function_exists( 'is_product' ) && is_product() ){
	$is_product = true;
}

if(!class_exists('WooCommerce')) {
	$is_product_category = false;
	$is_product = false;
}

if( is_category() || is_search() || is_tag() || is_year() || is_month() || is_day() ){
	$post_id = get_option( 'page_for_posts' );
}

if( $is_shop or $is_product_category) {
	$post_id = get_option( 'woocommerce_shop_page_id' );
}

$site_pages_show_title = get_theme_mod('pages_show_title', true);
$site_pages_show_bc = get_theme_mod('pages_show_breadcrumbs', true);


$page_hide_title = get_post_meta($post_id, 'page_title', true);
$page_hide_bc = get_post_meta($post_id, 'page_breadcrumbs', true);

if($site_pages_show_title) {
	$title = get_the_title($post_id);
}

if(!empty($page_hide_title) and $page_hide_title == 'on' ) {
	$title = '';
}

if(get_post_type() == 'sp_player') {
	$player_title = get_theme_mod('player_title', true);
	if($player_title) {
		$title = '';
	}
}

if(!$site_pages_show_bc) {
	$show_breadcrumbs = false;
}

if(!empty($page_hide_bc) and $page_hide_bc == 'on') {
	$show_breadcrumbs = false;
}

$transparent_header = get_post_meta($post_id, 'transparent_header', true);

$tr_header= '';
if(!empty($transparent_header) and $transparent_header == 'on') {
	$tr_header = 'transparent-header_on';
}

/*TITLE*/
if(!empty($current_page->name) and !$is_shop) {
	$title = $current_page->name;
}

if(!empty($current_page->label) and !$is_shop) {
	$title = $current_page->label;
}

if(is_search()) {
	$title = esc_html__('Search', 'splash');
}

$shop_archive = get_option('woocommerce_shop_page_id');

echo '<div class="stm-title-box-unit '.$tr_header.'">';

if(!empty($title)): ?>
	<div class="stm-page-title">
		<div class="container">
			<div class="clearfix stm-title-box-title-wrapper">
				<h3><?php echo sanitize_text_field($title); ?></h3>
				<?php if(!empty($shop_archive) and $shop_archive == $post_id or $is_product_category) {
					get_template_part('partials/global/shop-cats');
				} ?>
			</div>
		</div>
	</div>
<?php endif; ?>


<?php if ($show_breadcrumbs) {
	/*Breadcrumbs*/
	if ( $is_shop || $is_product || $is_product_category ) {
		woocommerce_breadcrumb();
	} else {
		if ( function_exists( 'bcn_display' ) ) { ?>
			<div class="stm-breadcrumbs-unit heading-font">
				<div class="container">
					<div class="navxtBreads">
						<?php bcn_display(); ?>
					</div>
				</div>
			</div>
		<?php }
	}
}

echo '</div>';