<?php
$title = $show_games = $count = $pick_team = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if(empty($count)) {
	$count = '1';
}

$next_match_args = array(
	'post_status'    => 'future',
	'posts_per_page' => intval($count),
	'post_type'      => 'sp_event',
	'order'          => 'ASC'
);

if(!empty($pick_team)) {
	$next_match_args['meta_query'][] = array(
		'key' => 'sp_team',
		'value' => intval($pick_team),
		'compare' => 'IN'
	);
}

$next_match_query = new WP_Query($next_match_args);

$rand_id = 'stm-next-match-' . rand(0,9999);

?>

<!--Looping through next matches-->
<?php
if($next_match_query->have_posts()): ?>
	<div class="<?php echo esc_attr($rand_id); ?>">
		<?php $now = new DateTime( current_time( 'mysql', 0 ) ); ?>
		<h3 class="stm-next-match-title"><?php echo esc_attr($title); ?></h3>
		<?php if($next_match_query->found_posts > 1): ?>
			<div class="stm-next-match-controls">
				<div class="stm-next-match-prev disabled"><i class="fa fa-angle-left"></i></div>
				<div class="stm-next-match-pagination heading-font"><span class="current">1</span>/<?php echo esc_attr($count); ?></div>
				<div class="stm-next-match-next"><i class="fa fa-angle-right"></i></div>
			</div>
		<?php endif; ?>
		<div class="stm-next-match-units">
			<?php while($next_match_query->have_posts()):
				$next_match_query->the_post();
				/*Check if two team exist in derby*/
				$teams = get_post_meta(get_the_id(), 'sp_team', false);
				if(count($teams) > 1): ?>
					<?php
						/* Get league names */
						$leagues = wp_get_post_terms(get_the_id(), 'sp_league');

						$leagues_names = array();
						if(!empty($leagues)) {
							foreach($leagues as $league) {
								$leagues_names[] = $league->name;
							}
						}

						/*Get venue name*/
						$venue = wp_get_post_terms(get_the_id(), 'sp_venue');
						$venue_name = '';
						if(!empty($venue) and !is_wp_error($venue)) {
							$venue_name = $venue[0]->name;
						}
					?>

					<div class="stm-next-match-unit">
						<a href="<?php echo esc_url(get_the_permalink()); ?>" class="stm-no-decoration">
							<div class="stm-next-match-time">
								<?php
								$date = new DateTime( get_the_time('Y/m/d H:i:s') );
								if($date) {
									$date_show = $date->format('F d, Y - H:i');
									$date = $date->format('Y-m-d H:i:s');
								}
								?>
								<time class="heading-font" datetime="<?php echo esc_attr($date) ?>"  data-countdown="<?php echo esc_attr( str_replace( "-", "/", $date ) ) ?>"></time>
							</div>

							<div class="stm-next-match-main-meta">
								<?php if(!empty($images)): ?>
									<div class="stm-next-matches_bg" style="background-image: url(<?php echo esc_url(splash_get_thumbnail_url(0, $images, 'full')); ?>);"></div>
								<?php endif; ?>
								<div class="stm-next-match-opponents-units">
									<div class="stm-next-match-opponents">
										<?php
										/*Get teams meta*/
										$team_1_title = get_the_title($teams[0]);
										$team_1_image = splash_get_thumbnail_url($teams[0], '', 'stm-200-200');
										$team_1_url = get_permalink($teams[0]);

										$team_2_title = get_the_title($teams[1]);
										$team_2_image = splash_get_thumbnail_url($teams[1], '', 'stm-200-200');
										$team_2_url = get_permalink($teams[1]);

										?>

										<div class="stm-command">
											<?php if(!empty($team_1_image)): ?>
												<div class="stm-command-logo">
													<!--<a href="<?php /*echo esc_url($team_1_url); */?>">-->
														<img src="<?php echo esc_url($team_1_image); ?>" alt="<?php echo esc_attr($team_1_title); ?>"/>
													<!--</a>-->
												</div>
											<?php endif; ?>
											<div class="stm-command-title">
												<h4>
													<!--<a href="<?php /*echo esc_url($team_1_url); */?>">-->
														<?php echo esc_attr($team_1_title); ?>
													<!--</a>-->
												</h4>
											</div>
										</div>

										<div class="stm-command-vs"><span><?php esc_html_e('vs', 'splash'); ?></span></div>

										<div class="stm-command stm-command-right">
											<div class="stm-command-title">
												<h4>
													<!--<a href="<?php /*echo esc_url($team_1_url); */?>">-->
														<?php echo esc_attr($team_2_title); ?>
													<!--</a>-->
												</h4>
											</div>
											<?php if(!empty($team_2_image)): ?>
												<div class="stm-command-logo">
													<!--<a href="<?php /*echo esc_url($team_2_url); */?>">-->
														<img src="<?php echo esc_url($team_2_image); ?>" alt="<?php echo esc_attr($team_2_title); ?>" />
													<!--</a>-->
												</div>
											<?php endif; ?>
										</div>
									</div>
								</div>

								<div class="stm-next-match-info heading-font">
									<?php echo esc_attr(implode(',', $leagues_names) . ' ' . $date_show); ?>
								</div>

								<?php if(!empty($venue_name)): ?>
									<div class="stm-next-match-venue heading-font">
										<?php echo esc_attr($venue_name); ?>
									</div>
								<?php endif; ?>
							</div>
						</a>

					</div>
				<?php endif; /*Two team exists*/ ?>
			<?php endwhile; ?>
		</div>
	</div>

	<script type="text/javascript">
		(function($) {
			"use strict";

			var unique_class = "<?php echo esc_js($rand_id); ?>";

			var owl = $('.' + unique_class + ' .stm-next-match-units');

			$(document).ready(function () {
				owl.owlCarousel({
					items: 1,
					autoplay: false,
					slideBy: 1
				});

				$('.' + unique_class + ' .stm-next-match-prev').on('click', function(){
					owl.trigger('prev.owl.carousel');
				});

				$('.' + unique_class + ' .stm-next-match-next').on('click', function(){
					owl.trigger('next.owl.carousel');
				});

				owl.on('changed.owl.carousel', function(event) {

					var current = parseInt(event.item.index + 1);
					var total = parseInt(event.item.count);


					if(current == 1) {
						$('.' + unique_class + ' .stm-next-match-prev').addClass('disabled');
					} else {
						$('.' + unique_class + ' .stm-next-match-prev').removeClass('disabled');
					}

					if(current === total) {
						$('.' + unique_class + ' .stm-next-match-next').addClass('disabled');
					} else {
						$('.' + unique_class + ' .stm-next-match-next').removeClass('disabled');
					}

					$('.stm-next-match-pagination .current').text(current);
				})

			});
		})(jQuery);
	</script>

	<?php wp_reset_postdata(); ?>
<?php endif; ?>