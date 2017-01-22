<?php

$number = $title = '';
$atts   = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if ( empty( $number ) ) {
	$number = 6;
}

if(empty($disable_masonry)) {
	$disable_masonry = '';
}

/*ALL MEDIA ARGS*/
$all_media_args = array(
	'post_type'      => 'media_gallery',
	'post_status'    => 'publish',
	'posts_per_page' => intval( $number ),
	'meta_key'       => '_thumbnail_id',
);
$media_args     = array(
	'orderby' => 'date'
);

$media_args     = array_merge( $all_media_args, $media_args );
$all_medias     = new WP_Query( $media_args );

/*ALL IMAGE ARGS*/
$image_args = array(
	'meta_query' => array(
		array(
			'key'     => 'media_type',
			'value'   => 'image',
			'compare' => '='
		),
		'relation' => 'AND'
	)
);
$image_args = array_merge( $all_media_args, $image_args );
$all_images = new WP_Query( $image_args );

/*ALL AUDIO ARGS*/
$audio_args = array(
	'meta_query' => array(
		array(
			'key'     => 'media_type',
			'value'   => 'audio',
			'compare' => '='
		),
		'relation' => 'AND'
	)
);
$audio_args = array_merge( $all_media_args, $audio_args );
$all_audios = new WP_Query( $audio_args );

/*ALL VIDEO ARGS*/
$video_args = array(
	'meta_query' => array(
		array(
			'key'     => 'media_type',
			'value'   => 'video',
			'compare' => '='
		),
		'relation' => 'AND'
	)
);
$video_args = array_merge( $all_media_args, $video_args );
$all_videos = new WP_Query( $video_args );
?>

<?php if ( $all_medias->have_posts() ): ?>
	<div class="stm-media-tabs">
		<div class="clearfix">
			<?php if ( ! empty( $title ) ): ?>
				<div class="stm-title-left">
					<h3 class="stm-main-title-unit"><?php echo esc_attr( $title ); ?></h3>
				</div>
			<?php endif; ?>
			<div class="stm-media-tabs-nav">
				<ul class="stm-list-duty heading-font" role="tablist">
					<li class="active">
						<a href="#all_medias" aria-controls="all_medias" role="tab" data-toggle="tab">
							<span><?php esc_html_e( 'All', 'splash' ); ?></span>
						</a>
					</li>
					<?php if ( $all_images->have_posts() ): ?>
						<li>
							<a href="#image_media" aria-controls="image_media" role="tab" data-toggle="tab">
								<span><?php esc_html_e( 'Images', 'splash' ); ?></span>
							</a>
						</li>
					<?php endif; ?>
					<?php if ( $all_audios->have_posts() ): ?>
						<li>
							<a href="#audio_media" aria-controls="audio_media" role="tab" data-toggle="tab">
								<span><?php esc_html_e( 'Audio', 'splash' ); ?></span>
							</a>
						</li>
					<?php endif; ?>
					<?php if ( $all_videos->have_posts() ): ?>
						<li>
							<a href="#video_media" aria-controls="video_media" role="tab" data-toggle="tab">
								<span><?php esc_html_e( 'Video', 'splash' ); ?></span>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane fade in active" id="all_medias">
				<div class="stm-medias-unit-wider">
					<div class="stm-medias-unit clearfix">
						<?php if ( $all_medias->have_posts() ) {
							$post_position = 0;
							while ( $all_medias->have_posts() ) {
								$all_medias->the_post();
								$post_position ++;
								stm_single_media_output( get_the_ID(), $post_position, 'style_1', 'none', $disable_masonry );
							}
						}; ?>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="image_media">
				<div class="stm-medias-unit-wider">
					<div class="stm-medias-unit clearfix">
						<?php if ( $all_images->have_posts() ) {
							$post_position = 0;
							while ( $all_images->have_posts() ) {
								$all_images->the_post();
								$post_position ++;
								stm_single_media_output( get_the_ID(), $post_position, 'style_1', 'none', $disable_masonry );
							}
						}; ?>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="audio_media">
				<div class="stm-medias-unit-wider">
					<div class="stm-medias-unit clearfix">
						<?php if ( $all_audios->have_posts() ) {
							$post_position = 0;
							while ( $all_audios->have_posts() ) {
								$all_audios->the_post();
								$post_position ++;
								stm_single_media_output( get_the_ID(), $post_position, 'style_1', 'none', $disable_masonry );
							}
						}; ?>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="video_media">
				<div class="stm-medias-unit-wider">
					<div class="stm-medias-unit clearfix">
						<?php if ( $all_videos->have_posts() ) {
							$post_position = 0;
							while ( $all_videos->have_posts() ) {
								$all_videos->the_post();
								$post_position ++;
								stm_single_media_output( get_the_ID(), $post_position, 'style_1', 'none', $disable_masonry );
							}
						}; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php else: ?>
	<h4><?php esc_html_e( 'No Media found', 'splash' ); ?></h4>
<?php endif; ?>

<?php wp_reset_postdata(); ?>