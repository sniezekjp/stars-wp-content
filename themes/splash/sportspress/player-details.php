<?php
/**
 * Player Details
 *
 * @author 		ThemeBoy
 * @package 	SportsPress/Templates
 * @version     2.1
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( get_option( 'sportspress_player_show_details', 'yes' ) === 'no' ) return;

if ( ! isset( $id ) )
	$id = get_the_ID();

$defaults = array(
	'show_number' => get_option( 'sportspress_player_show_number', 'no' ) == 'yes' ? true : false,
	'show_name' => get_option( 'sportspress_player_show_name', 'no' ) == 'yes' ? true : false,
	'show_nationality' => get_option( 'sportspress_player_show_nationality', 'yes' ) == 'yes' ? true : false,
	'show_positions' => get_option( 'sportspress_player_show_positions', 'yes' ) == 'yes' ? true : false,
	'show_current_teams' => get_option( 'sportspress_player_show_current_teams', 'yes' ) == 'yes' ? true : false,
	'show_past_teams' => get_option( 'sportspress_player_show_past_teams', 'yes' ) == 'yes' ? true : false,
	'show_leagues' => get_option( 'sportspress_player_show_leagues', 'no' ) == 'yes' ? true : false,
	'show_seasons' => get_option( 'sportspress_player_show_seasons', 'no' ) == 'yes' ? true : false,
	'show_nationality_flags' => get_option( 'sportspress_player_show_flags', 'yes' ) == 'yes' ? true : false,
	'abbreviate_teams' => get_option( 'sportspress_abbreviate_teams', 'yes' ) === 'yes' ? true : false,
	'link_teams' => get_option( 'sportspress_link_teams', 'no' ) == 'yes' ? true : false,
);

extract( $defaults, EXTR_SKIP );

$countries = SP()->countries->countries;

$player = new SP_Player( $id );

$nationalities = $player->nationalities();
$positions = $player->positions();
$current_teams = $player->current_teams();
$past_teams = $player->past_teams();
$leagues = $player->leagues();
$seasons = $player->seasons();
$metrics_before = $player->metrics( true );
$metrics_after = $player->metrics( false );

$common = array();
if ( $show_nationality && $nationalities && is_array( $nationalities ) ):
	$values = array();
	foreach ( $nationalities as $nationality ):
		$country_name = sp_array_value( $countries, $nationality, null );
		$values[] = $country_name ? ( $show_nationality_flags ? '<img src="' . plugin_dir_url( SP_PLUGIN_FILE ) . 'assets/images/flags/' . strtolower( $nationality ) . '.png" alt="' . $nationality . '"> ' : '' ) . $country_name : '&mdash;';
	endforeach;
	$common[ esc_html__( 'Nationality', 'splash' ) ] = implode( '<br>', $values );
endif;

if ( $show_positions && $positions && is_array( $positions ) ):
	$position_names = array();
	foreach ( $positions as $position ):
		$position_names[] = $position->name;
	endforeach;
	$common[ esc_html__( 'Position', 'splash' ) ] = implode( ', ', $position_names );
endif;

$data = array_merge( $metrics_before, $common, $metrics_after );

if ( $show_current_teams && $current_teams ):
	$teams = array();
	foreach ( $current_teams as $team ):
		$team_name = sp_get_team_name( $team, $abbreviate_teams );
		if ( $link_teams ) $team_name = '<a href="' . get_post_permalink( $team ) . '">' . $team_name . '</a>';
		$teams[] = $team_name;
	endforeach;
	$data[ esc_html__( 'Current Team', 'splash' ) ] = implode( ', ', $teams );
endif;

if ( $show_past_teams && $past_teams ):
	$teams = array();
	foreach ( $past_teams as $team ):
		$team_name = sp_get_team_name( $team, $abbreviate_teams );
		if ( $link_teams ) $team_name = '<a href="' . get_post_permalink( $team ) . '">' . $team_name . '</a>';
		$teams[] = $team_name;
	endforeach;
	$data[ esc_html__( 'Past Teams', 'splash' ) ] = implode( ', ', $teams );
endif;

if ( $show_leagues && $leagues && ! is_wp_error( $leagues ) ):
	$terms = array();
	foreach ( $leagues as $league ) {
		$terms[] = $league->name;
	}
	$data[ esc_html__( 'Competitions', 'splash' ) ] = implode( ', ', $terms );
endif;

if ( $show_seasons && $seasons && ! is_wp_error( $seasons ) ):
	$terms = array();
	foreach ( $seasons as $season ) {
		$terms[] = $season->name;
	}
	$data[ esc_html__( 'Seasons', 'splash' ) ] = implode( ', ', $terms );
endif;

$data = apply_filters( 'sportspress_player_details', $data, $id );
$player_number = get_post_meta( $id, 'sp_number', true );

$socials = array( 'facebook', 'twitter', 'instagram', 'dribbble' );

if ( empty( $data ) )
	return; ?>

	<div class="sp-template sp-template-player-details sp-template-details">
		<div class="sp-list-wrapper">
			<?php if($show_name): ?>
				<h3><?php the_title(); ?></h3>
			<?php endif; ?>
			<?php if(!empty($player_number) and $show_number): ?>
				<div class="stm-player-number">
					<div class="inner">
						<span class="stm-grey"><?php echo esc_html__('N:', 'splash') ?></span><span class="stm-red"><?php echo esc_attr($player_number); ?></span>
					</div>
				</div>
			<?php endif; ?>
			<div class="sp-player-details heading-font">
				<?php foreach( $data as $label => $value ): ?>
					<div class="single-info">
						<div class="st-label normal_font"><?php echo wp_kses_post($label); ?></div>
						<div class="st-value"><?php echo wp_kses_post($value); ?></div>
					</div>
				<?php endforeach; ?>
			</div>
			<ul class="player-socials">
				<?php foreach($socials as $social): ?>
					<?php
					$soc = get_post_meta($id, $social, true);
					if(!empty($soc)): ?>
						<li class="<?php echo esc_attr($social) ?>">
							<a href="<?php echo esc_url($soc); ?>" target="_blank">
								<i class="fa fa-<?php echo esc_attr($social); ?>"></i>
							</a>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>

	<div class="stm_player_right_details">
		<?php get_template_part('sportspress/player-details-right'); ?>
	</div>

