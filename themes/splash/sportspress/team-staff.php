<?php
/**
 * Team Staff
 *
 * @author 		ThemeBoy
 * @package 	SportsPress/Templates
 * @version     1.9.13
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! isset( $id ) )
	$id = get_the_ID();

$team = new SP_Team( $id );
$members = $team->staff();

if(!empty($members)): ?>
	<h4 class="sp-table-caption">
		<?php esc_html_e('Coaching Staff', 'splash'); ?>
	</h4>
	<div class="stm-team-staff-list">
		<div class="stm-team-staff-list-inner clearfix">
			<?php foreach ( $members as $staff ):
				$id = $staff->ID;
				$name = $staff->post_title;
				$countries = SP()->countries->countries;
				$staff = new SP_Staff( $id );
				$role = $staff->role();
				$nationalities = $staff->nationalities();
				$nationality = '';
				if( !empty($nationalities) and !empty($nationalities[0])) {
					$nationality = $nationalities[0];
					if ( 2 == strlen( $nationality ) ):
						$legacy = SP()->countries->legacy;
						$nationality = strtolower( $nationality );
						$nationality = sp_array_value( $legacy, $nationality, null );
					endif;
					$country_name = sp_array_value( $countries, $nationality, null );
				}

				$role_name = '';

				if($role) {
					$role_name = $role->name;
				}


				?>
				<div class="stm-single-staff">
					<div class="inner">
						<div class="stm-red heading-font"><?php echo esc_attr($role_name); ?></div>
						<h4 class="sp-staff-name heading-font"><?php echo esc_attr($name); ?></h4>
						<?php if(!empty($country_name)): ?>
							<div class="nationality">
								(<?php esc_html_e('Nationality', 'splash'); ?>: <?php echo esc_attr($country_name); ?>)
							</div>
						<?php endif; ?>
					</div>
				</div>
				<?php
			endforeach; ?>
		</div>
	</div>
<?php endif; ?>