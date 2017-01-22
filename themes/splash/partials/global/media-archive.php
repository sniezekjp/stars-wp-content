<?php
/*SIDEBAR SETTINGS*/
$sidebar_settings = splash_get_sidebar_settings( 'media_sidebar', 'media_sidebar_position', 'no_sidebar', 'right' );
$sidebar_id       = $sidebar_settings['id'];

$sidebar_settings_position = 'none';

if ( ! empty( $sidebar_id ) ) {
	$sidebar_settings_position = $sidebar_settings['position'];
}

$stm_sidebar_layout_mode = splash_sidebar_layout_mode( $sidebar_settings['position'], $sidebar_id );

if ( $sidebar_settings_position == 'none' ) {
	$load_by = 6;
} else {
	$load_by = 7;
}

/*ALL MEDIA ARGS*/
$all_media_args = array(
	'post_type'      => 'media_gallery',
	'post_status'    => 'publish',
	'posts_per_page' => $load_by,
	'meta_key'       => '_thumbnail_id',
);
$media_args     = array();
$media_args     = array_merge( $all_media_args, $media_args );
$all_medias     = new WP_Query( $media_args );

/*ALL IMAGE ARGS*/
$image_args = array(
	'meta_query' => array(
		array(
			'key'     => 'media_type',
			'value'   => 'image',
			'compare' => '='
		)
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
		)
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
		)
	)
);
$video_args = array_merge( $all_media_args, $video_args );
$all_videos = new WP_Query( $video_args );
?>

<?php if ( $all_medias->have_posts() ): ?>
	<div class="stm-media-archive stm-media-archive-<?php echo esc_attr( $sidebar_settings_position ); ?>">
		<div class="container">
			<div class="row">
				<?php echo wp_kses_post( $stm_sidebar_layout_mode['content_before'] ); ?>
				<div class="stm-media-tabs">
					<div class="clearfix">
						<div class="stm-title-left">
							<h3 class="stm-main-title-unit"><?php esc_html_e( 'Media', 'splash' ); ?></h3>
						</div>
						<div class="stm-media-tabs-nav">
							<ul class="stm-list-duty heading-font" role="tablist">
								<li class="active">
									<a href="#all_media" aria-controls="all_media" role="tab" data-toggle="tab">
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
						<div role="tabpanel" class="tab-pane fade in active" id="all_media">
							<div class="stm-medias-unit-wider">
								<div class="stm-medias-unit clearfix">

									<?php if ( $all_medias->have_posts() ) {
										$post_position = 0;
										$style         = 'style_' . rand( 1, 3 );
										while ( $all_medias->have_posts() ) {
											$all_medias->the_post();
											$post_position ++;
											if ( $post_position % 6 == 0 ) {
												$style = 'style_' . rand( 1, 3 );
											}
											stm_single_media_output( get_the_ID(), $post_position, $style, $sidebar_settings_position );
										}
									}; ?>

								</div>
								<?php if ( $all_medias->found_posts > $load_by ): ?>
									<div class="col-md-12 stm-media-load-more">
										<a class="button" data-category="all" data-page="1"
										   data-load="<?php echo esc_attr( $load_by ); ?>"><span><?php esc_html_e( 'Show more', 'splash' ); ?></span></a>
									</div>
								<?php endif; ?>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="image_media">
							<div class="stm-medias-unit-wider">
								<div class="stm-medias-unit clearfix">
									<?php if ( $all_images->have_posts() ) {
										$post_position = 0;
										$style         = 'style_' . rand( 1, 3 );
										while ( $all_images->have_posts() ) {
											$all_images->the_post();
											$post_position ++;
											if ( $post_position % 6 == 0 ) {
												$style = 'style_' . rand( 1, 3 );
											}
											stm_single_media_output( get_the_ID(), $post_position, $style, $sidebar_settings_position );
										}
									}; ?>
								</div>
								<?php if ( $all_images->found_posts > $load_by ): ?>
									<div class="col-md-12 stm-media-load-more">
										<a class="button" data-category="image" data-page="1"
										   data-load="<?php echo esc_attr( $load_by ); ?>"><span><?php esc_html_e( 'Show more', 'splash' ); ?></span></a>
									</div>
								<?php endif; ?>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="audio_media">
							<div class="stm-medias-unit-wider">
								<div class="stm-medias-unit clearfix">
									<?php if ( $all_audios->have_posts() ) {
										$post_position = 0;
										$style         = 'style_' . rand( 1, 3 );
										while ( $all_audios->have_posts() ) {
											$all_audios->the_post();
											$post_position ++;
											if ( $post_position % 6 == 0 ) {
												$style = 'style_' . rand( 1, 3 );
											}
											stm_single_media_output( get_the_ID(), $post_position, $style, $sidebar_settings_position );
										}
									}; ?>
								</div>
								<?php if ( $all_audios->found_posts > $load_by ): ?>
									<div class="col-md-12 stm-media-load-more">
										<a class="button" data-category="audio" data-page="1"
										   data-load="<?php echo esc_attr( $load_by ); ?>"><span><?php esc_html_e( 'Show more', 'splash' ); ?></span></a>
									</div>
								<?php endif; ?>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="video_media">
							<div class="stm-medias-unit-wider">
								<div class="stm-medias-unit clearfix">
									<?php if ( $all_videos->have_posts() ) {
										$post_position = 0;
										$style         = 'style_' . rand( 1, 3 );
										while ( $all_videos->have_posts() ) {
											$all_videos->the_post();
											$post_position ++;
											if ( $post_position % 6 == 0 ) {
												$style = 'style_' . rand( 1, 3 );
											}
											stm_single_media_output( get_the_ID(), $post_position, $style, $sidebar_settings_position );
										}
									}; ?>
								</div>
								<?php if ( $all_videos->found_posts > $load_by ): ?>
									<div class="col-md-12 stm-media-load-more">
										<a class="button" data-category="video" data-page="1"
										   data-load="<?php echo esc_attr( $load_by ); ?>"><span><?php esc_html_e( 'Show more', 'splash' ); ?></span></a>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<?php echo wp_kses_post( $stm_sidebar_layout_mode['content_after'] ); ?>

				<!--Sidebar-->
				<?php splash_display_sidebar(
					$sidebar_id,
					$stm_sidebar_layout_mode['sidebar_before'],
					$stm_sidebar_layout_mode['sidebar_after'],
					$sidebar_settings['blog_sidebar']
				); ?>

			</div>
		</div>
	</div>
<?php else: ?>
	<h4><?php esc_html_e( 'No Media found', 'splash' ); ?></h4>
<?php endif; ?>

<?php wp_reset_postdata(); ?>