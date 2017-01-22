<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if(!empty($images)):

	$images = explode(',', $images);
	$images_thumbs = array();


	foreach($images as $image) {
		$post_thumbnail = wpb_getImageBySize( array(
			'attach_id' => $image,
			'thumb_size' => $image_size
		) );

		$images_thumbs[] = $post_thumbnail['thumbnail'];
	}


	$id = 'stm-images-slider-' . rand(0,9999);
	?>

	<div class="stm-image-slider <?php echo esc_attr($id); ?>">

		<div class="stm-slider-control-prev"><i class="fa fa-angle-left"></i></div>
		<div class="stm-slider-control-next"><i class="fa fa-angle-right"></i></div>

		<div class="stm-image-slider-init-unit">
			<div class="stm-image-slider-init">
				<?php foreach($images_thumbs as $image_tag): ?>
					<div class="stm-single-image-slider">
						<?php echo wp_kses_post($image_tag); ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

	</div>

	<script type="text/javascript">
		(function($) {
			"use strict";

			var unique_class = "<?php echo esc_js($id); ?>";

			var owl = $('.' + unique_class + ' .stm-image-slider-init');

			$(document).ready(function () {
				owl.owlCarousel({
					items: 1,
					dots: false,
					autoplay: false,
					slideBy: 1,
					loop: true
				});

				$('.' + unique_class + ' .stm-slider-control-prev').on('click', function(){
					owl.trigger('prev.owl.carousel');
				});

				$('.' + unique_class + ' .stm-slider-control-next').on('click', function(){
					owl.trigger('next.owl.carousel');
				});
			});
		})(jQuery);
	</script>

<?php endif; ?>