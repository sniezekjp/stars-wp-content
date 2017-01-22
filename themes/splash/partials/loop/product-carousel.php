<?php
$post_id = get_the_id();
$product = new WC_Product( $post_id );
$image = splash_get_thumbnail_url($post_id, 0, 'stm-570-350');
$currency = get_woocommerce_currency_symbol();

$price = $product->price;
?>

<div class="stm-single-product-carousel">
	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="stm-product-link">
		<?php if(!empty($image)): ?>
			<div class="image">
				<img src="<?php echo esc_url($image) ?>" alt="<?php the_title(); ?>"/>
				<div class="stm-add-to-cart">
					<span
						rel="nofollow"
						data-quantity="1"
						data-product_id="<?php echo intval($post_id); ?>"
						data-product_sku=""
						class="button btn-secondary btn-style-4 add_to_cart_button ajax_add_to_cart">
						<?php esc_html_e('Add to cart', 'splash'); ?>
					</span>
				</div>
			</div>
		<?php endif; ?>


		<div class="clearfix stm-product-meta heading-font">
			<div class="title">
				<?php the_title(); ?>
			</div>
			<?php if(!empty($price)): ?>
				<div class="price">
					<?php echo esc_attr($currency . ' ' . $price); ?>
				</div>
			<?php endif; ?>
		</div>
	</a>

	<div class="content">
		<?php the_excerpt(); ?>
	</div>
</div>