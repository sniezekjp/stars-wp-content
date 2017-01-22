<?php
$title = $number = '';
$number = 3;
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


$review_args = array(
	'post_type'      => 'testimonial',
	'posts_per_page' => intval( $number ),
	'post_status'    => 'publish'
);

$reviews_query = new WP_Query($review_args);

$id = 'stm-reviews-'.rand(0,9999);


if($reviews_query->have_posts()): ?>
	<div class="container">
		<div class="stm-reviews-main-wrapper <?php echo esc_attr($id) ?>">
			<div class="clearfix">
				<?php if(!empty($title)): ?>
					<div class="stm-title-left">
						<h3 class="stm-main-title-unit"><?php echo esc_attr($title); ?></h3>
					</div>
				<?php endif; ?>
				<div class="stm-carousel-controls-right stm-reviews-controls">
					<div class="stm-carousel-control-prev"><i class="fa fa-angle-left"></i></div>
					<div class="stm-review-dots"></div>
					<div class="stm-carousel-control-next"><i class="fa fa-angle-right"></i></div>
				</div>
			</div>
			<?php if(!empty($reviews_query->posts[0]) and !empty($reviews_query->posts[0]->ID)): ?>
				<?php $image_url = splash_get_thumbnail_url($reviews_query->posts[0]->ID, 0, 'full'); ?>
				<div class="stm-review-image" style="background-image: url('<?php echo esc_url($image_url); ?>')"></div>
			<?php endif; ?>
			<div class="stm-reviews-carosel-wrapper">
				<div class="stm-reviews">
					<?php while($reviews_query->have_posts()): $reviews_query->the_post(); ?>
						<?php
							$image_url = '';
							if(has_post_thumbnail()) {
								$image_url = splash_get_thumbnail_url(get_the_id(), 0, 'full' );
							}

							$color = get_post_meta(get_the_id(), 'text_color', true);
						?>

						<div class="stm-review-single" data-image="<?php echo esc_url($image_url); ?>">
							<div class="stm-review-container">
								<div class="icon" style="color:<?php echo esc_attr($color); ?>">
									<i class="stm-icon-quote"></i>
								</div>
								<div class="title heading-font"><?php the_title(); ?></div>
								<div class="content" style="color:<?php echo esc_attr($color); ?>"><?php the_content(); ?></div>
								<div class="line"></div>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		(function($) {
			"use strict";

			var unique_class = "<?php echo esc_js($id); ?>";

			var owl = $('.' + unique_class + ' .stm-reviews');

			$(document).ready(function () {
				owl.owlCarousel({
					items: 1,
					dots: true,
					autoplay: true,
					autoplayHoverPause: true,
					loop:true,
					slideBy: 1,
					dotsContainer: '.' + unique_class + ' .stm-review-dots',
					onTranslated: function () {
						var image = $('.' + unique_class + ' .owl-item.active .stm-review-single').data('image');
						$('.' + unique_class + ' .stm-review-image').css('background-image', 'url("' + image + '")');
					}
				});

				$('.' + unique_class + ' .stm-carousel-control-prev').on('click', function(){
					owl.trigger('prev.owl.carousel');
				});

				$('.' + unique_class + ' .stm-carousel-control-next').on('click', function(){
					owl.trigger('next.owl.carousel');
				});
			});
		})(jQuery);
	</script>

	<?php wp_reset_postdata();
endif; ?>