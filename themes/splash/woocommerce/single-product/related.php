<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

if ( empty( $product ) || ! $product->exists() ) {
	return;
}

$related = $product->get_related( $posts_per_page );

if ( sizeof( $related ) === 0 ) return;

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'            => 'product',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => $posts_per_page,
	'orderby'              => $orderby,
	'post__in'             => $related,
	'post__not_in'         => array( $product->id )
) );

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;

$id = 'stm-product-carousel-init-'.rand(0,9999);

$id_controls = 'stm-product-carousel-controls-'.rand(0,9999);

if ( $products->have_posts() ) : ?>

	<div class="stm-fullwidth-row-js">
		<div class="container">
			<div class="clearfix">
				<div class="stm-title-left">
					<h3 class="stm-main-title-unit"><?php esc_html_e('Related Products', 'splash'); ?></h3>
				</div>
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
						<?php while($products->have_posts()): $products->the_post(); ?>
							<?php get_template_part('partials/loop/product-carousel'); ?>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					</div>
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

<?php endif;

wp_reset_postdata();
