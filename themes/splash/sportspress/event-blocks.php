<?php
/**
 * Event Blocks
 *
 * @author 		ThemeBoy
 * @package 	SportsPress/Templates
 * @version     2.1
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*Default template or sportpress */
$event_list_template = get_theme_mod('event_block_template', 'theme');


	$defaults = array(
		'id' => null,
		'title' => false,
		'status' => 'default',
		'date' => 'default',
		'date_from' => 'default',
		'date_to' => 'default',
		'day' => 'default',
		'league' => null,
		'season' => null,
		'venue' => null,
		'team' => null,
		'player' => null,
		'number' => -1,
		'show_team_logo' => get_option( 'sportspress_event_blocks_show_logos', 'yes' ) == 'yes' ? true : false,
		'link_teams' => get_option( 'sportspress_link_teams', 'no' ) == 'yes' ? true : false,
		'link_events' => get_option( 'sportspress_link_events', 'yes' ) == 'yes' ? true : false,
		'paginated' => get_option( 'sportspress_event_blocks_paginated', 'yes' ) == 'yes' ? true : false,
		'rows' => get_option( 'sportspress_event_blocks_rows', 5 ),
		'orderby' => 'default',
		'order' => 'default',
		'show_all_events_link' => false,
		'show_title' => get_option( 'sportspress_event_blocks_show_title', 'no' ) == 'yes' ? true : false,
		'show_league' => get_option( 'sportspress_event_blocks_show_league', 'no' ) == 'yes' ? true : false,
		'show_season' => get_option( 'sportspress_event_blocks_show_season', 'no' ) == 'yes' ? true : false,
		'show_venue' => get_option( 'sportspress_event_blocks_show_venue', 'no' ) == 'yes' ? true : false,
		'hide_if_empty' => false,
	);

	extract( $defaults, EXTR_SKIP );

	$calendar = new SP_Calendar( $id );
	if ( $status != 'default' )
		$calendar->status = $status;
	if ( $date != 'default' )
		$calendar->date = $date;
	if ( $date_from != 'default' )
		$calendar->from = $date_from;
	if ( $date_to != 'default' )
		$calendar->to = $date_to;
	if ( $league )
		$calendar->league = $league;
	if ( $season )
		$calendar->season = $season;
	if ( $venue )
		$calendar->venue = $venue;
	if ( $team )
		$calendar->team = $team;
	if ( $player )
		$calendar->player = $player;
	if ( $order != 'default' )
		$calendar->order = $order;
	if ( $orderby != 'default' )
		$calendar->orderby = $orderby;
	if ( $day != 'default' )
		$calendar->day = $day;
	$data = $calendar->data();

	if ( $hide_if_empty && empty( $data ) ) return;

	if ( $show_title && false === $title && $id ):
		$caption = $calendar->caption;
		if ( $caption )
			$title = $caption;
		else
			$title = get_the_title( $id );
	endif;

	if ( $title )
		echo '<h4 class="sp-table-caption">' . $title . '</h4>';

	if($event_list_template == 'theme') { ?>
		<div class="sp-template sp-template-event-blocks sp-stm-template-event-blocks">
		<div class="sp-table-wrapper">
			<?php foreach($data as $event):

				$teams = array_unique( get_post_meta( $event->ID, 'sp_team' ) );
				$teams = array_filter( $teams, 'sp_filter_positive' );
				$team_results = get_post_meta($event->ID, 'sp_results', false);
				$permalink = get_post_permalink( $event, false, true );
				$results = get_post_meta( $event->ID, 'sp_results', true );
				$point_system = splash_get_sportpress_points_system();

				if ( count( $teams ) > 1 ):
					$team_1_id = $teams[0];
					$team_2_id = $teams[1];

					$logos = array();

					$j = 0;
					foreach( $teams as $team ):
						$j++;
						if ( has_post_thumbnail ( $team ) ):
							if ( $link_teams ):
								$logo = '<a class="team-logo logo-' . ( $j % 2 ? 'odd' : 'even' ) . '" href="' . get_permalink( $team, false, true ) . '" title="' . get_the_title( $team ) . '">' . get_the_post_thumbnail( $team, 'stm-200-200' ) . '</a>';
							else:
								$logo = '<span class="team-logo logo-' . ( $j % 2 ? 'odd' : 'even' ) . '" title="' . get_the_title( $team ) . '">' . get_the_post_thumbnail( $team, 'stm-200-200' ) . '</span>';
							endif;
							$logos[] = $logo;
						endif;
					endforeach; ?>

					<div class="stm-single-block-event-list sp-stm-template-event-blocks-<?php echo esc_attr($event->post_status); ?>">
						<a href="<?php echo esc_url(get_the_permalink($event->ID)); ?>" class="stm-no-decor">
							<div class="stm-single-block-event-list-top">
								<div class="time h6"><?php echo esc_attr(get_the_time( get_option( 'date_format' ), $event )); ?></div>
								<?php if ( $show_venue ): $venues = get_the_terms( $event, 'sp_venue' ); if ( $venues ): $venue = array_shift( $venues ); ?>
									<div class="venue h6"><?php echo sanitize_text_field($venue->name); ?></div>
								<?php endif; endif; ?>
								<?php if($event->post_status == 'future'): ?>
									<div class="stm-future-event-list-time">
										<?php
										$date = new DateTime( get_the_time('Y/m/d H:i:s', $event->ID) );
										if($date) {
											$date_show = $date->format('F d, Y - H:i');
											$date = $date->format('Y-m-d H:i:s');
										}
										?>
										<time class="heading-font" datetime="<?php echo esc_attr($date) ?>"  data-countdown="<?php echo esc_attr( str_replace( "-", "/", $date ) ) ?>"></time>
									</div>
								<?php endif; ?>
							</div>
							<div class="stm-single-block-unit">
								<div class="stm-team-logo left">
									<?php
									if(!empty($logos[0])):
										echo wp_kses_post($logos[0]);
									endif;
									?>
								</div>

								<div class="stm-teams-info heading-font">


									<div class="stm-title-team">
										<?php echo esc_attr(get_the_title($team_1_id)); ?>
									</div>

									<div class="stm-team-results-outer">
										<?php if(!empty($team_results[0])): ?>
											<?php if(!empty($team_results[0][$team_1_id])): ?>
												<?php if(isset($team_results[0][$team_1_id]['outcome']) and !empty($team_results[0][$team_1_id]['outcome'][0])): ?>
													<?php if($team_results[0][$team_1_id]['outcome'][0] == 'win'): ?>
														<div class="stm-latest-result-win-label normal-font"><?php esc_html_e('win', 'splash') ?></div>
													<?php else: ?>
														<div class="stm-latest-result-lose-label normal-font"><?php esc_html_e('lose', 'splash') ?></div>
													<?php endif; ?>
												<?php else: ?>
													<div class="stm-latest-result-lose-label"><?php esc_html_e('- -', 'splash') ?></div>
												<?php endif; ?>
											<?php endif; ?>
										<?php else: ?>
											<div class="stm-latest-result-lose-label"><?php esc_html_e('- -', 'splash') ?></div>
										<?php endif; ?>

										<?php if(!empty($team_results[0])): ?>
											<?php if(!empty($team_results[0][$team_1_id]) and !empty($team_results[0][$team_2_id])): ?>
												<?php if(isset($team_results[0][$team_1_id][$point_system]) and isset($team_results[0][$team_2_id][$point_system])): ?>
													<?php if(empty($team_results[0][$team_1_id][$point_system]) and empty($team_results[0][$team_2_id][$point_system])): ?>
														<div class="stm-latest-result_result"><?php esc_html_e('- VS -', 'splash'); ?></div>
													<?php else: ?>
														<div class="stm-latest-result_result"><?php echo esc_attr($team_results[0][$team_1_id][$point_system] . ' / ' . $team_results[0][$team_2_id][$point_system]); ?></div>
													<?php endif; ?>
												<?php endif; ?>
											<?php endif; ?>
										<?php else: ?>
											<div class="stm-latest-result_result"><?php esc_html_e('- VS -', 'splash'); ?></div>
										<?php endif; ?>

										<?php if(!empty($team_results[0])): ?>
											<?php if(!empty($team_results[0][$team_2_id])): ?>
												<?php if(isset($team_results[0][$team_2_id]['outcome']) and !empty($team_results[0][$team_2_id]['outcome'][0])): ?>
													<?php if($team_results[0][$team_2_id]['outcome'][0] == 'win'): ?>
														<div class="stm-latest-result-win-label normal-font"><?php esc_html_e('win', 'splash') ?></div>
													<?php else: ?>
														<div class="stm-latest-result-lose-label normal-font"><?php esc_html_e('lose', 'splash') ?></div>
													<?php endif; ?>
												<?php else: ?>
													<div class="stm-latest-result-lose-label"><?php esc_html_e('- -', 'splash') ?></div>
												<?php endif; ?>
											<?php endif; ?>
										<?php else: ?>
											<div class="stm-latest-result-lose-label"><?php esc_html_e('- -', 'splash') ?></div>
										<?php endif; ?>
									</div>

									<div class="stm-title-team opponent">
										<?php echo esc_attr(get_the_title($team_2_id)); ?>
									</div>

								</div>

								<div class="stm-team-logo right">
									<?php
									if(!empty($logos[1])):
										echo wp_kses_post($logos[1]);
									endif;
									?>
								</div>
							</div>
						</a>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
			</div>
		</div>
	<?php } else { ?>
	<div class="sp-template sp-template-event-blocks">
		<div class="sp-table-wrapper">
			<table class="sp-event-blocks sp-data-table<?php if ( $paginated ) { ?> sp-paginated-table<?php } ?>" data-sp-rows="<?php echo esc_attr($rows); ?>">
				<thead><tr><th></th></tr></thead> <?php # Required for DataTables ?>
				<tbody>
					<?php
					$i = 0;

					if ( intval( $number ) > 0 )
						$limit = $number;

					foreach ( $data as $event ):
						if ( isset( $limit ) && $i >= $limit ) continue;

						$permalink = get_post_permalink( $event, false, true );
						$results = get_post_meta( $event->ID, 'sp_results', true );

						$teams = array_unique( get_post_meta( $event->ID, 'sp_team' ) );
						$teams = array_filter( $teams, 'sp_filter_positive' );
						$logos = array();

						if ( $show_team_logo ):
							$j = 0;
							foreach( $teams as $team ):
								$j++;
								if ( has_post_thumbnail ( $team ) ):
									if ( $link_teams ):
										$logo = '<a class="team-logo logo-' . ( $j % 2 ? 'odd' : 'even' ) . '" href="' . get_permalink( $team, false, true ) . '" title="' . get_the_title( $team ) . '">' . get_the_post_thumbnail( $team, 'sportspress-fit-icon' ) . '</a>';
									else:
										$logo = '<span class="team-logo logo-' . ( $j % 2 ? 'odd' : 'even' ) . '" title="' . get_the_title( $team ) . '">' . get_the_post_thumbnail( $team, 'sportspress-fit-icon' ) . '</span>';
									endif;
									$logos[] = $logo;
								endif;
							endforeach;
						endif;

						if ( 'day' === $calendar->orderby ):
							$event_group = get_post_meta( $event->ID, 'sp_day', true );
							if ( ! isset( $group ) || $event_group !== $group ):
								$group = $event_group;
								echo '<tr><th><strong class="sp-event-group-name">', __( 'Match Day', 'sportspress' ), ' ', $group, '</strong></th></tr>';
							endif;
						endif;
						?>
						<tr class="sp-row heading-font sp-post<?php echo ( $i % 2 == 0 ? ' alternate' : '' ); ?>">
							<td>
								<?php echo implode( $logos, ' ' ); ?>
								<time class="sp-event-date" datetime="<?php echo esc_attr($event->post_date); ?>">
									<?php echo sp_add_link( get_the_time( get_option( 'date_format' ), $event ), $permalink, $link_events ); ?>
								</time>
								<h5 class="sp-event-results">
									<?php echo sp_add_link( '<span class="sp-result">' . implode( '</span> - <span class="sp-result">', apply_filters( 'sportspress_event_blocks_team_result_or_time', sp_get_main_results_or_time( $event ), $event->ID ) ), $permalink, $link_events . '</span>' ); ?>
								</h5>
								<h4 class="sp-event-title">
									<?php echo sp_add_link( $event->post_title, $permalink, $link_events ); ?>
								</h4>
								<?php if ( $show_league ): $leagues = get_the_terms( $event, 'sp_league' ); if ( $leagues ): $league = array_shift( $leagues ); ?>
									<div class="sp-event-league"><?php echo esc_attr($league->name); ?></div>
								<?php endif; endif; ?>
								<?php if ( $show_season ): $seasons = get_the_terms( $event, 'sp_season' ); if ( $seasons ): $season = array_shift( $seasons ); ?>
									<div class="sp-event-season"><?php echo esc_attr($season->name); ?></div>
								<?php endif; endif; ?>
								<?php if ( $show_venue ): $venues = get_the_terms( $event, 'sp_venue' ); if ( $venues ): $venue = array_shift( $venues ); ?>
									<div class="sp-event-venue"><?php echo sanitize_text_field($venue->name); ?></div>
								<?php endif; endif; ?>


							</td>
						</tr>
						<?php
						$i++;
					endforeach;
					?>
				</tbody>
			</table>
		</div>
		<?php
		if ( $id && $show_all_events_link )
			echo '<div class="sp-calendar-link sp-view-all-link"><a href="' . get_permalink( $id ) . '">' . esc_html__( 'View all events', 'splash' ) . '</a></div>';
		?>
	</div>
<?php }