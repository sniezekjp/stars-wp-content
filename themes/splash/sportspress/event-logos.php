<?php
/**
 * Event Logos
 *
 * @author 		ThemeBoy
 * @package 	SportsPress/Templates
 * @version     2.1.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( get_option( 'sportspress_event_show_logos', 'yes' ) === 'no' ) return;

if ( ! isset( $id ) ) {
	$id = get_the_ID();
}
?>

<div class="stm-next-match-units">
	<?php
	/*Check if two team exist in derby*/
	$teams = get_post_meta($id, 'sp_team', false);
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

				<div class="stm-next-matches_bg" style="background-image: url(<?php echo esc_url(get_theme_mod('sp_event_bg')); ?>);"></div>

				<div class="stm-next-match-opponents-units">
					<div class="stm-next-match-opponents">
						<?php
						/*Get teams meta*/
						$team_1_title = get_the_title($teams[0]);
						$team_1_image = splash_get_thumbnail_url($teams[0],'', 'stm-200-200');
						$team_1_url = get_permalink($teams[0]);

						$team_2_title = get_the_title($teams[1]);
						$team_2_image = splash_get_thumbnail_url($teams[1],'', 'stm-200-200');
						$team_2_url = get_permalink($teams[1]);
						?>

						<div class="stm-command">
							<?php if(!empty($team_1_image)): ?>
								<div class="stm-command-logo">
									<a href="<?php echo esc_url($team_1_url); ?>">
										<img src="<?php echo esc_url($team_1_image); ?>" />
									</a>
								</div>
							<?php endif; ?>
							<div class="stm-command-title">
								<h4>
									<a href="<?php echo esc_url($team_1_url); ?>">
										<?php echo esc_attr($team_1_title); ?>
									</a>
								</h4>
							</div>
						</div>

						<div class="stm-command-vs"><span><?php esc_html_e('vs', 'splash'); ?></span></div>

						<div class="stm-command stm-command-right">
							<div class="stm-command-title">
								<h4>
									<a href="<?php echo esc_url($team_1_url); ?>">
										<?php echo esc_attr($team_2_title); ?>
									</a>
								</h4>
							</div>
							<?php if(!empty($team_2_image)): ?>
								<div class="stm-command-logo">
									<a href="<?php echo esc_url($team_2_url); ?>">
										<img src="<?php echo esc_url($team_2_image); ?>" />
									</a>
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

		</div>
	<?php endif; /*Two team exists*/ ?>
</div>