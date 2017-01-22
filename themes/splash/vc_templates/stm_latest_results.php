<?php
$title = $show_games = $count = $pick_team = '';
$atts  = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if ( empty( $count ) ) {
	$count = '1';
}

$latest_results_args = array(
	'post_status'    => 'publish',
	'posts_per_page' => intval( $count ),
	'post_type'      => 'sp_event',
	'order'          => 'DESC'
);

if ( ! empty( $pick_team ) ) {
	$latest_results_args['meta_query'][] = array(
		'key'     => 'sp_team',
		'value'   => intval( $pick_team ),
		'compare' => 'LIKE'
	);
}

$latest_results_query = new WP_Query( $latest_results_args );

if(empty($link_bind)) {
	$link_bind = 'teams';
}

$team_1_full_link = $team_2_full_link = '';

$fixture_link = false;

?>

	<!--Looping through next matches-->
<?php
if ( $latest_results_query->have_posts() ): ?>
	<h3 class="stm-latest-results-title"><?php echo esc_attr( $title ); ?></h3>
	<div class="stm-latest-results-units">
		<?php $prev_date = $prev_venue = ''; ?>
		<?php while ( $latest_results_query->have_posts() ):
			$latest_results_query->the_post();
			/*Check if two team exist in derby*/
			$teams = get_post_meta( get_the_id(), 'sp_team', false );

			$point_system = splash_get_sportpress_points_system();

			if ( count( $teams ) > 1 ):
				$team_1_id = $teams[0];
				$team_2_id = $teams[1];

				$team_results = get_post_meta(get_the_ID(), 'sp_results', false);


				/*Get venue name*/
				$venue      = wp_get_post_terms( get_the_id(), 'sp_venue' );
				$venue_name = '';
				if ( ! empty( $venue ) and ! is_wp_error( $venue ) ) {
					$venue_name = $venue[0]->name;
				}

				/*Get teams meta*/
				$team_1_title = get_the_title( $team_1_id );
				$team_2_title = get_the_title( $team_2_id );

				$team_1_url = get_permalink($team_1_id);
				$team_2_url = get_permalink($team_2_id);

				$date = new DateTime( get_the_time('Y/m/d H:i:s') );
				if ( $date ) {
					$date_show = $date->format( 'l d M.y' );
				}


				/*Link bind*/
				if($link_bind == 'teams') {
					$team_1_full_link = '<a href="' . esc_url($team_1_url) . '">' . esc_attr($team_1_title) . '</a>';
					$team_2_full_link = '<a href="' . esc_url($team_2_url) . '">' . esc_attr($team_2_title) . '</a>';
				} else {
					$team_1_full_link = '<span>' . esc_attr($team_1_title) . '</span>';
					$team_2_full_link = '<span>' . esc_attr($team_2_title) . '</span>';
					$fixture_link = true;
				}
				?>

				<?php if($prev_date != $date_show and $prev_venue != $venue_name): ?>
				<div class="stm-latest-results-meta heading-font">
					<div class="date"><?php echo esc_attr($date_show); ?></div>
					<div class="venue"><?php echo esc_attr($venue_name); ?></div>
				</div>
			<?php endif; ?>

				<?php if($fixture_link): ?>
				<a href="<?php echo esc_url(get_permalink()); ?>" class="stm-no-decoration" title="<?php the_title(); ?>">
			<?php endif; ?>


				<div class="stm-latest-results-info heading-font">
					<div class="stm-latest-result">
						<?php if(!empty($team_results[0])): ?>
							<?php if(!empty($team_results[0][$team_1_id])): ?>
								<?php if(isset($team_results[0][$team_1_id]['outcome']) and !empty($team_results[0][$team_1_id]['outcome'][0]) and $team_results[0][$team_1_id]['outcome'][0] == 'win'): ?>
									<div class="stm-latest-result-win-label normal-font"><?php esc_html_e('win', 'splash') ?></div>
								<?php endif; ?>
							<?php endif; ?>
						<?php endif; ?>
						<div class="stm-latest-result-team">
							<?php echo ($team_1_full_link); ?>
						</div>
					</div>

					<?php if(!empty($team_results[0])): ?>
						<?php if(!empty($team_results[0][$team_1_id]) and !empty($team_results[0][$team_2_id])): ?>
							<?php if(isset($team_results[0][$team_1_id][$point_system]) and isset($team_results[0][$team_2_id][$point_system])): ?>
								<div class="stm-latest-result_result"><?php echo esc_attr($team_results[0][$team_1_id][$point_system] . ' / ' . $team_results[0][$team_2_id][$point_system]); ?></div>
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>

					<div class="stm-latest-result stm-latest-result-right">
						<?php if(!empty($team_results[0])): ?>
							<?php if(!empty($team_results[0][$team_2_id])): ?>
								<?php if(isset($team_results[0][$team_2_id]['outcome']) and !empty($team_results[0][$team_2_id]['outcome'][0]) and $team_results[0][$team_2_id]['outcome'][0] == 'win'): ?>
									<div class="stm-latest-result-win-label normal-font"><?php esc_html_e('win', 'splash') ?></div>
								<?php endif; ?>
							<?php endif; ?>
						<?php endif; ?>

						<div class="stm-latest-result-team">
							<?php echo ($team_2_full_link); ?>
						</div>
					</div>
				</div>

				<?php if($fixture_link): ?>
				</a>
			<?php endif; ?>

				<?php
				$prev_date  = $date_show;
				$prev_venue = $venue_name;
				?>
			<?php endif; /*Two team exists*/ ?>
		<?php endwhile; ?>
	</div>

	<?php wp_reset_postdata(); ?>
<?php endif; ?>