<?php get_header();

$shop_sidebar_id = get_theme_mod('shop_sidebar', 'no_sidebar');
$shop_sidebar_position = get_theme_mod('shop_sidebar_position', 'left');


if(!empty($shop_sidebar_id)) {
	$shop_sidebar = get_post( $shop_sidebar_id );
} else {
	$shop_sidebar = '';
}

if($shop_sidebar_id == 'no_sidebar') {
	$shop_sidebar_id = false;
}

$stm_sidebar_layout_mode = splash_sidebar_layout_mode($shop_sidebar_position, $shop_sidebar_id);
?>

	<?php get_template_part('partials/global/title-box'); ?>

	<div class="container">
		<div class="row">

			<?php echo wp_kses_post($stm_sidebar_layout_mode['content_before']); ?>
			<?php
				if( have_posts() ){
					woocommerce_content();
				}
			?>
			<?php echo wp_kses_post($stm_sidebar_layout_mode['content_after']); ?>

			<!--Sidebar-->
			<?php splash_display_sidebar(
				$shop_sidebar_id,
				$stm_sidebar_layout_mode['sidebar_before'],
				$stm_sidebar_layout_mode['sidebar_after'],
				$shop_sidebar
			); ?>

		</div> <!--row-->
	</div> <!--container-->

	
<?php get_footer(); ?>