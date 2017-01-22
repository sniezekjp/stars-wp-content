<?php
$title = $post_categories = '';
$number = 6;
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$product_args = array(
	'post_type' => 'product',
	'post_status' => 'publish',
	'posts_per_page' => intval($number),
);

if(!empty($post_categories)) {
	$post_categories = explode(', ', $post_categories);
	if(!empty($post_categories)) {
		$product_args['tax_query'] = array(
			'relation' => 'OR'
		);
		foreach($post_categories as $post_category) {
			$product_args['tax_query'][] = array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => $post_category
			);
		}
	}
}

$id = 'stm-product-carousel-init-'.rand(0,9999);

$id_controls = 'stm-product-carousel-controls-'.rand(0,9999);

$product_query = new WP_Query($product_args);

if($product_query->have_posts()): ?>

	<div class="container">
		<div class="clearfix">
			<?php if(!empty($title)): ?>
				<div class="stm-title-left">
					<h3 class="stm-main-title-unit"><?php echo esc_attr($title); ?></h3>
				</div>
			<?php endif; ?>
			<div class="stm-carousel-controls-right <?php echo esc_attr($id_controls); ?>">
				<div class="stm-carousel-control-prev"><i class="fa fa-angle-left"></i></div>
				<div class="stm-carousel-control-next"><i class="fa fa-angle-right"></i></div>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>

	<div class="container">
		<div class="stm-products-carousel-unit-wrapper">
			<div class="stm-products-carousel-unit">
				<div class="stm-products-carousel-init <?php echo esc_attr($id); ?>">
					<?php while($product_query->have_posts()): $product_query->the_post(); ?>
						<?php get_template_part('partials/loop/product-carousel'); ?>
					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
				</div>
			</div>
		</div>
	</div>


	<script type="text/javascript">
		(function($) {
			"use strict";

			var unique_class = "<?php echo esc_js($id); ?>";

			var unique_class_controls = "<?php echo esc_js($id_controls); ?>";

			var owl = $('.' + unique_class);

			$(window).load(function () {
				owl.owlCarousel({
					items: 2,
					dots: true,
					autoplay: false,
					loop: true,
					slideBy: 2,
					responsive:{
						0:{
							items:1,
							slideBy:1
						},
						768:{
							items:2,
							slideBy:2
						}
					}
				});

				$('.' + unique_class_controls + ' .stm-carousel-control-prev').on('click', function(){
					owl.trigger('prev.owl.carousel');
				});

				$('.' + unique_class_controls + ' .stm-carousel-control-next').on('click', function(){
					owl.trigger('next.owl.carousel');
				});
			});
		})(jQuery);
	</script>

<?php endif; ?>

