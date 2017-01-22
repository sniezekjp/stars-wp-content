<?php
$plugin_path = dirname(__FILE__);
require_once $plugin_path . '/post_type.class.php';

$plugin_path_types = dirname(__FILE__) . '/post-types-registration';
require_once $plugin_path_types . '/testimonials.php';
require_once $plugin_path_types . '/media.php';
require_once $plugin_path_types . '/donations.php';
require_once $plugin_path_types . '/vc_sidebar.php';
require_once $plugin_path_types . '/donors.php';

add_action('init', 'stm_init_metaboxes');

function stm_init_metaboxes() {

	/*Players*/
	$players = get_posts(array('post_type' => 'sp_player', 'posts_per_page' => 9999));
	$players_array = array(
		'none' => esc_html__('No player', STM_CONFIGURATIONS)
	);
	if($players){
		foreach($players as $player){
			$players_array[$player->ID] = $player->post_title;
		}
	}

	$statistics       = get_posts( array( 'post_type' => 'sp_performance', 'posts_per_page' => 9999 ) );
	$statistics_array = array();
	if ( $statistics ) {
		foreach ( $statistics as $statistic ) {
			$statistics_array[ $statistic->ID ] = $statistic->post_title;
		}
	}

	/*Leagues categories*/
	$leagues = get_terms( 'sp_league' );
	$leagues_array = array(
		'none' => esc_html__('Use Customizer Default', STM_CONFIGURATIONS)
	);

	if(!empty($leagues) and !is_wp_error($leagues)) {
		foreach ( $leagues as $league ) {
			$leagues_array[ $league->term_id ] = $league->name;
		}
	}

	/*Season categories*/
	$seasons       = get_terms( 'sp_season' );
	$seasons_array = array(
		'none' => esc_html__('Use Customizer Default', STM_CONFIGURATIONS)
	);

	if(!empty($seasons) and !is_wp_error($seasons)) {
		foreach ( $seasons as $season ) {
			$seasons_array[ $season->term_id ] = $season->name;
		}
	}

	STM_PostType::addMetaBox( 'page_options', __( 'Page Options', STM_CONFIGURATIONS ), array(
		'page',
		'post',
		'product',
		'sp_calendar',
		'sp_event',
		'sp_player',
		'sp_team'
	), '', '', '', array(
		'fields' => array(
			'transparent_header' => array(
				'label' => __( 'Transparent Header', STM_CONFIGURATIONS ),
				'type'  => 'checkbox'
			),
			'page_title'         => array(
				'label' => __( 'Hide Page title', STM_CONFIGURATIONS ),
				'type'  => 'checkbox',
			),
			'page_breadcrumbs'   => array(
				'label'       => __( 'Hide Page breadcrumbs', STM_CONFIGURATIONS ),
				'type'        => 'checkbox',
				'description' => esc_html__( 'Breadcrumbs NavXT plugin required' ),
			),
			'no_page_padding'    => array(
				'label' => __( 'Remove page padding', STM_CONFIGURATIONS ),
				'type'  => 'checkbox'
			),
		)
	) );

	STM_PostType::addMetaBox( 'page_options_design', __( 'Page Design Options', STM_CONFIGURATIONS ), array(
		'page',
		'sp_calendar',
		'sp_event',
		'sp_player',
		'sp_team'
	), '', '', '', array(
		'fields' => array(
			'page_color'   => array(
				'label' => __( 'Page Color', STM_CONFIGURATIONS ),
				'type'  => 'color_picker'
			),
			'footer_image' => array(
				'label' => __( 'Footer Image', STM_CONFIGURATIONS ),
				'type'  => 'image'
			),
			'footer_ca_text'  => array(
				'label' => __( 'Footer Call to Action Text', STM_CONFIGURATIONS ),
				'type'  => 'text',
			),
			'footer_ca_link_text'  => array(
				'label' => __( 'Footer Call to Action Link Text', STM_CONFIGURATIONS ),
				'type'  => 'text',
			),
			'footer_ca_link'  => array(
				'label' => __( 'Footer Call to Action Link', STM_CONFIGURATIONS ),
				'type'  => 'text',
			),
			'footer_ca_position' => array(
				'label'   => __( 'Footer Call to Action position', STM_CONFIGURATIONS ),
				'type'    => 'select',
				'options' => array(
					'customizer_default' => esc_html__( 'Customizer Default', STM_CONFIGURATIONS ),
					'center' => esc_html__( 'Center', STM_CONFIGURATIONS ),
					'left' => esc_html__( 'Left', STM_CONFIGURATIONS ),
					'right' => esc_html__( 'Right', STM_CONFIGURATIONS ),
				)
			),
		)
	) );

	STM_PostType::addMetaBox( 'page_options_testimonials', __( 'Page Options', STM_CONFIGURATIONS ), array( 'testimonial' ), '', '', '', array(
		'fields' => array(
			'text_color' => array(
				'label' => __( 'Text Color', STM_CONFIGURATIONS ),
				'type'  => 'color_picker'
			),
		)
	) );

	STM_PostType::addMetaBox( 'player_image', __( 'Player Additional media', STM_CONFIGURATIONS ), array( 'sp_player' ), '', '', '', array(
		'fields' => array(
			'player_image' => array(
				'label' => __( 'Player Preseason image (used in VC module)', STM_CONFIGURATIONS ),
				'type'  => 'image'
			),
		)
	) );

	STM_PostType::addMetaBox( 'player_statistics', __( 'Single page Player Visible Statistic', STM_CONFIGURATIONS ), array( 'sp_player' ), '', '', '', array(
		'fields' => array(
			'single_player_season_stats'             => array(
				'label'       => esc_html__( 'Choose season', 'stm-configurations' ),
				'type'        => 'select',
				'options'     => $seasons_array,
			),
			'single_player_league_stats'             => array(
				'label'       => esc_html__( 'Choose league', 'stm-configurations' ),
				'type'        => 'select',
				'options'     => $leagues_array,
			),
			'single_player_stats' => array(
				'label'       => esc_html__( 'Show statistic', 'stm-configurations' ),
				'type'        => 'stm-multiple-checkbox',
				'options'     => $statistics_array,
				'description' => esc_html__( 'This Statistic will be shown on single player page', 'stm-configurations' ),
			),
		)
	) );

	STM_PostType::addMetaBox( 'player_socials', __( 'Player Socials', STM_CONFIGURATIONS ), array( 'sp_player' ), '', '', '', array(
		'fields' => array(
			'facebook'  => array(
				'label' => __( 'Facebook', STM_CONFIGURATIONS ),
				'type'  => 'text',
			),
			'twitter'   => array(
				'label' => __( 'Twitter', STM_CONFIGURATIONS ),
				'type'  => 'text',
			),
			'instagram' => array(
				'label' => __( 'Instagram', STM_CONFIGURATIONS ),
				'type'  => 'text',
			),
			'dribbble'  => array(
				'label' => __( 'Dribbble', STM_CONFIGURATIONS ),
				'type'  => 'text',
			),
		)
	) );

	STM_PostType::addMetaBox( 'page_options_media', __( 'Page Options', STM_CONFIGURATIONS ), array( 'media_gallery' ), '', '', '', array(
		'fields' => array(
			'media_type' => array(
				'label'   => __( 'Media type', STM_CONFIGURATIONS ),
				'type'    => 'select',
				'options' => array(
					'image' => esc_html__( 'Image', STM_CONFIGURATIONS ),
					'audio' => esc_html__( 'Audio', STM_CONFIGURATIONS ),
					'video' => esc_html__( 'Video', STM_CONFIGURATIONS ),
				)
			),
			'embed_link' => array(
				'label' => __( 'Embed link', STM_CONFIGURATIONS ),
				'type'  => 'text',
			),
		)
	) );

	STM_PostType::addMetaBox( 'page_options_donations', __( 'Donation', STM_CONFIGURATIONS ), array( 'donation' ), '', '', '', array(
		'fields' => array(
			'raised_money'   => array(
				'label' => __( 'Raised money', STM_CONFIGURATIONS ),
				'type'  => 'text',
			),
			'donors'         => array(
				'label' => __( 'Donors count', STM_CONFIGURATIONS ),
				'type'  => 'text',
			),
			'goal'           => array(
				'label' => __( 'Goal', STM_CONFIGURATIONS ),
				'type'  => 'text',
			),
			'donor_subtitle' => array(
				'label' => __( 'Subtitle', STM_CONFIGURATIONS ),
				'type'  => 'text',
			),
			'donor_intro'    => array(
				'label' => __( 'Lead paragraph', STM_CONFIGURATIONS ),
				'type'  => 'textarea',
			),
		)
	) );

	STM_PostType::addMetaBox( 'donor_info', __( 'Donor Info', STM_CONFIGURATIONS ), array( 'donor' ), '', '', '', array(
		'fields' => array(
			'donor_email'  => array(
				'label' => __( 'Donor Email', STM_CONFIGURATIONS ),
				'type'  => 'text'
			),
			'donor_phone'  => array(
				'label' => __( 'Donor Phone', STM_CONFIGURATIONS ),
				'type'  => 'text'
			),
			'donor_event'  => array(
				'label' => __( 'Donation ID', STM_CONFIGURATIONS ),
				'type'  => 'text'
			),
			'donor_amount' => array(
				'label' => __( 'Donation amount', STM_CONFIGURATIONS ),
				'type'  => 'text'
			),
		)
	) );
}

function splash_pl_pa($arr) {
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}

/*Player Media*/
function splash_add_custom_meta_box()
{
	add_meta_box("demo-meta-box", "Player Media Gallery", "custom_meta_box_markup", "sp_player", "advanced", "high", null);
}

add_action("add_meta_boxes", "splash_add_custom_meta_box");

function custom_meta_box_markup($object) {
	wp_nonce_field(basename(__FILE__), "meta-box-nonce");

	$types = array(
		'image' => array(
			'fields' => array(
				'text' => __( 'Title*', STM_CONFIGURATIONS ),
				'image' => __( 'Image ID*', STM_CONFIGURATIONS ),
			)
		),
		'audio' => array(
			'fields' => array(
				'text' => __( 'Title*', STM_CONFIGURATIONS ),
				'image' => __( 'Image ID*', STM_CONFIGURATIONS ),
				'url' => __( 'URL*', STM_CONFIGURATIONS ),
			)
		),
		'video' => array(
			'fields' => array(
				'text' => __( 'Title*', STM_CONFIGURATIONS ),
				'image' => __( 'Image ID*', STM_CONFIGURATIONS ),
				'url' => __( 'URL*', STM_CONFIGURATIONS ),
			)
		)
	)
	?>
	<div id="stm-admin_tabs">
		<?php $player_media = get_post_meta($object->ID, 'stm_player_media', false); ?>
		<ul>
			<?php foreach($types as $type_name => $type): ?>
			<li><a href="#tabs-<?php echo $type_name; ?>"><?php echo ucfirst($type_name); ?>s</a></li>
			<?php endforeach; ?>
		</ul>

		<div class="form-table">
			<?php foreach($types as $type_name => $type): ?>
				<div id="tabs-<?php echo $type_name; ?>" data-slug="<?php echo $type_name; ?>">
					<h1><?php echo ucfirst($type_name); ?>s</h1>
					<?php if(!empty($player_media) and !empty($player_media[0]) and !empty($player_media[0][$type_name])): ?>

						<?php if(!empty($player_media[0][$type_name]['text'])): ?>
							<?php foreach($player_media[0][$type_name]['text'] as $field_key => $field): ?>
								<div class="stm-type-single">
									<i class="fa fa-close stm-delete-row"></i>
									<div><label><?php _e( 'Title*', STM_CONFIGURATIONS ); ?></label></div>
									<input type="text" name="stm_player_media[<?php echo $type_name; ?>][text][]" value="<?php echo $field; ?>" required />

									<div><label><?php _e( 'Image*', STM_CONFIGURATIONS ); ?></label></div>
									<?php if(!empty($player_media[0][$type_name]['image_type_text'][$field_key])): ?>
										<?php $preview = wp_get_attachment_image_src($player_media[0][$type_name]['image_type_text'][$field_key], 'stm-540-500'); ?>
										<input type="text" class="image_type_" name="stm_player_media[<?php echo $type_name; ?>][image_type_text][]" value="<?php echo $player_media[0][$type_name]['image_type_text'][$field_key]; ?>" required />
										<?php if(!empty($preview) and !empty($preview[0])): ?>
											<img class="custom_preview_image" src="<?php echo $preview[0]; ?>" />
											<a href="#" class="stm_row_add_image button-primary"><?php _e('Replace Image', STM_CONFIGURATIONS); ?></a>
											<a href="#" class="stm_row_remove_image button-primary"><?php _e('Remove Image', STM_CONFIGURATIONS); ?></a>
										<?php endif; ?>
									<?php else: ?>
										<input type="text" class="image_type_" name="stm_player_media[<?php echo $type_name; ?>][image_type_text][]" required />
									<?php endif; ?>

									<?php if($type_name !== 'image'): ?>
										<div><label><?php _e( 'URL*', STM_CONFIGURATIONS ); ?></label></div>
										<?php if(!empty($player_media[0][$type_name]['url'][$field_key])): ?>
											<input type="text" name="stm_player_media[<?php echo $type_name; ?>][url][]" value="<?php echo $player_media[0][$type_name]['url'][$field_key]; ?>" required />
										<?php else: ?>
											<input type="text" name="stm_player_media[<?php echo $type_name; ?>][url][]" required />
										<?php endif; ?>
									<?php endif; ?>

								</div>
							<?php endforeach; ?>
						<?php endif; ?>

					<?php endif; ?>
					<a href="#" class="add_new_type button-primary"><?php _e('Add row', STM_CONFIGURATIONS); ?></a>
				</div>
			<?php endforeach; ?>
		</div>

	</div>

	<script type="text/javascript">
		<?php foreach($types as $type_name => $type): ?>
			var new_field_<?php echo esc_attr($type_name); ?> = '';
			new_field_<?php echo esc_attr($type_name); ?> += '<div class="stm-type-single">';
			new_field_<?php echo esc_attr($type_name); ?> += '<i class="fa fa-close stm-delete-row"></i>';
			<?php foreach($type['fields'] as $defined_field_type => $defined_fields): ?>
				<?php
				$id = '';
				if($defined_field_type == 'image') {
					$id = 'image_type_';
					$defined_field_type = 'text';
				}
				?>
				new_field_<?php echo esc_attr($type_name); ?> += '<div><label><?php echo $defined_fields; ?></label></div>';
				new_field_<?php echo esc_attr($type_name); ?> += '<input class="<?php echo $id; ?>" type="<?php echo $defined_field_type; ?>" name="stm_player_media[<?php echo $type_name ?>][<?php echo $id.$defined_field_type ?>][]" required />';
				<?php if($id == 'image_type_'): ?>
					new_field_<?php echo esc_attr($type_name); ?> += '<img src="" class="custom_preview_image" />';
					new_field_<?php echo esc_attr($type_name); ?> += '<a href="#" class="stm_row_add_image button-primary"><?php _e('Add Image', STM_CONFIGURATIONS); ?></a>';
					new_field_<?php echo esc_attr($type_name); ?> += '<a href="#" class="stm_row_remove_image button-primary"><?php _e('Remove Image', STM_CONFIGURATIONS); ?></a>';
				<?php endif; ?>
			<?php endforeach; ?>
			new_field_<?php echo esc_attr($type_name); ?> += '</div>';
		<?php endforeach; ?>
		(function ($) {
			"use strict";

			/*Ready DOM scripts*/
			$(document).ready(function () {
				$("#stm-admin_tabs").tabs();

				$('.add_new_type').on('click', function(e){
					e.preventDefault();
					var fieldVal = $(this).closest('.ui-tabs-panel').attr('data-slug');
					var newFieldVal = eval('new_field' + '_' + fieldVal);
					$(this).closest('.ui-tabs-panel').append(newFieldVal);
				});

				$("body").on('click', '.stm_row_add_image', function(e){
					e.preventDefault();
					var btnClicked = $(this);
					console.log('dedede');
					var custom_uploader = wp.media({
						title   : "<?php _e( 'Select image', STM_CONFIGURATIONS ); ?>",
						button  : {
							text: "<?php _e( 'Attach', STM_CONFIGURATIONS ); ?>"
						},
						multiple: true
					}).on("select", function () {
						var attachment = custom_uploader.state().get("selection").first().toJSON();
						console.log(attachment, btnClicked.closest(".stm-type-single").find(".image_text_"));
						btnClicked.closest(".stm-type-single").find(".image_type_").val(attachment.id);
						btnClicked.closest(".stm-type-single").find(".custom_preview_image").attr("src", attachment.url);

					}).open();
				});

				$("body").on('click', '.stm_row_remove_image', function(e){
					e.preventDefault();
					var btnClicked = $(this);
					btnClicked.closest(".stm-type-single").find(".image_type_").val('');
					btnClicked.closest(".stm-type-single").find(".custom_preview_image").attr("src", '');
				});

				$('body').on('click', '.stm-delete-row', function(e){
					e.preventDefault();
					$(this).closest('.stm-type-single').remove();
				});
			})
		})(jQuery);
	</script>
<?php
}

function save_custom_meta_box($post_id, $post) {

	if(!current_user_can("edit_post", $post_id))
		return $post_id;

	if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
		return $post_id;

	$slug = "sp_player";
	if($slug != $post->post_type)
		return $post_id;

	if(isset($_POST['stm_player_media'])) {
		update_post_meta( $post_id, "stm_player_media", $_POST['stm_player_media'] );
	}
}

add_action("save_post_sp_player", "save_custom_meta_box", 10, 3);
