<?php
$team = $player_list = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$id = 'stm-players-'.rand(0,9999);

?>

<div class="stm-player-ids <?php echo esc_attr($id); ?>">
	<div class="clearfix">
		<?php if(!empty($title)): ?>
			<div class="stm-title-left">
				<h3 class="stm-main-title-unit"><?php echo esc_attr($title); ?></h3>
			</div>
		<?php endif; ?>
		<div class="stm-carousel-controls-right">
			<div class="stm-carousel-control-prev"><i class="fa fa-angle-left"></i></div>
			<div class="stm-carousel-control-next"><i class="fa fa-angle-right"></i></div>
		</div>
	</div>


	<div class="stm-player-list-wrapper">
		<div class="stm-players clearfix">

			<?php
			$data = get_post_meta($player_list, 'sp_player', false);
			if($data) {
				foreach ($data as $player_id):
					if(!empty($player_id)):
						$player_number = get_post_meta( $player_id, 'sp_number', true );
						$positions = wp_get_post_terms($player_id,'sp_position');
						$position = false;
						if($positions) {
							$position = $positions[0]->name;
						}

						if(!empty($player_image_size)) {
							$image = wpb_getImageBySize( array(
								'post_id' => $player_id,
								'thumb_size' => $player_image_size
							) );

							if(!empty($image) and !empty($image['thumbnail'])) {
								$image = $image['thumbnail'];
							} else {
								$image = '';
							}
						} else {
							$image = '<img src="' . splash_get_thumbnail_url( $player_id, 0, 'stm-270-370' )  . '" alt="'.get_the_title($player_id) .'" />';
						}

						if(!empty($image)): ?>

							<div class="stm-list-single-player">
								<a href="<?php echo esc_url(get_the_permalink($player_id)); ?>" title="<?php echo esc_attr(get_the_title($player_id)); ?>">
									<?php echo $image; ?>
									<div class="stm-list-single-player-info">
										<div class="inner heading-font">
											<div class="player-number"><?php echo esc_attr($player_number); ?></div>
											<div class="player-title"><?php echo esc_attr(get_the_title($player_id)); ?></div>
											<div class="player-position"><?php echo esc_attr($position); ?></div>
										</div>
									</div>
								</a>
							</div>
						<?php endif; ?>
					<?php endif; ?>


				<?php endforeach;
			} ?>
		</div>
	</div>
</div>

<?php if(!empty($enable_carousel) and $enable_carousel == 'yes'):
	if(empty($per_row)) {
		$per_row = 4;
	}
	?>
	<script type="text/javascript">
		(function($) {
			"use strict";

			var unique_class = "<?php echo esc_js($id); ?>";

			var owl = $('.' + unique_class + ' .stm-players');

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
							items:3,
							slideBy: 3
						},
						992:{
							items:3,
							slideBy: 3
						},
						1100: {
							items: <?php echo intval($per_row); ?>,
							slideBy: <?php echo intval($per_row); ?>
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
<?php endif; ?>