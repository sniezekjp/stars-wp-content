<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );


$id = 'stm-trophy-carousel-' . rand(0,9999);
?>

<div class="stm-trophy-carousel <?php echo esc_attr($id); ?>">

	<div class="clearfix">
		<?php if(!empty($title)): ?>
			<div class="stm-title-left">
				<h3 class="stm-main-title-unit"><?php echo esc_attr($title); ?></h3>
			</div>
		<?php endif; ?>
		<div class="stm-carousel-controls-right stm-thophies-controls">
			<div class="stm-carousel-control-prev"><i class="fa fa-angle-left"></i></div>
			<div class="stm-carousel-control-next"><i class="fa fa-angle-right"></i></div>
		</div>
	</div>

	<div class="stm-trophy-carousel-init-unit">
		<div class="stm-trophy-carousel-init <?php echo esc_attr($css_class); ?>">
			<?php echo wpb_js_remove_wpautop($content); ?>
		</div>
	</div>

</div>

<script type="text/javascript">
	(function($) {
		"use strict";

		var unique_class = "<?php echo esc_js($id); ?>";

		var owl = $('.' + unique_class + ' .stm-trophy-carousel-init');

		$(document).ready(function () {
			owl.owlCarousel({
				items: 4,
				dots: false,
				autoplay: false,
				slideBy: 4,
				loop: true,
				responsive:{
					0:{
						items:1,
						slideBy: 1
					},
					768:{
						items:2,
						slideBy:2
					},
					992:{
						items:3,
						slideBy: 3
					},
					1100: {
						items: 4,
						slideBy: 4
					}
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