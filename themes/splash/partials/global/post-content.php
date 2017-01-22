<?php
	$sidebar_id = get_theme_mod('sidebar_blog', 'primary_sidebar');
	$sidebar_position = get_theme_mod('sidebar_position', 'left');

	if( !empty($sidebar_id) ) {
		$blog_sidebar = get_post( $sidebar_id );
	} else {
		$blog_sidebar = '';
	}

	if($sidebar_id == 'no_sidebar') {
		$sidebar_id = false;
	}

	$stm_sidebar_layout_mode = splash_sidebar_layout_mode($sidebar_position, $sidebar_id);
	$format = get_post_format();
?>

<div class="row stm-format-<?php echo esc_attr($format); ?>">
	<?php echo wp_kses_post($stm_sidebar_layout_mode['content_before']); ?>
		<div class="stm-small-title-box">
			<?php get_template_part('partials/global/title-box'); ?>
		</div>

		<!--Post thumbnail-->
		<?php if ( has_post_thumbnail() ): ?>
			<div class="post-thumbnail">
				<?php the_post_thumbnail( 'stm-1170-650', array( 'class' => 'img-responsive' ) ); ?>
			</div>
		<?php endif; ?>

		<div class="stm-single-post-meta clearfix heading-font">

			<div class="stm-meta-left-part">
				<div class="stm-date">
					<i class="fa fa-calendar-o"></i>
					<?php echo get_the_date(); ?>
				</div>
				<div class="stm-author">
					<i class="fa fa-user"></i>
					<?php the_author(); ?>
				</div>
			</div>

			<div class="stm-comments-num">
				<a href="<?php comments_link(); ?>" class="stm-post-comments">
					<i class="fa fa-commenting"></i>
					<?php comments_number(); ?>
				</a>
			</div>

		</div>


		<div class="post-content">
			<?php the_content(); ?>
			<div class="clearfix"></div>
		</div>

		<?php splash_pages_pagination(); ?>


		<div class="stm-post-meta-bottom heading-font clearfix">
			<div class="stm_post_tags">
				<?php the_tags( '<i class="fa fa-tag"></i>',',' ); ?>
			</div>

			<div class="stm_post_share">
				<span class="st_sharethis_large" displaytext=""></span>
				<script type="text/javascript">var switchTo5x=true;</script>
				<script type="text/javascript" src="//w.sharethis.com/button/buttons.js"></script>
				<script type="text/javascript">stLight.options({doNotHash: false, doNotCopy: false, hashAddressBar: false,onhover: false});</script>
				<div class="stm-share"><i class="fa fa-share-alt"></i><?php esc_html_e('Share', 'splash'); ?></div>
			</div>
		</div>

		<?php if ( get_the_author_meta('description') ) : ?>
			<div class="stm_author_box clearfix">
				<div class="author_avatar">
					<?php echo get_avatar( get_the_author_meta( 'email' ), 174 ); ?>
				</div>
				<div class="author_info">
					<div class="author_name">
						<h6 class="text-transform"><?php esc_html_e( 'About the Author:', 'splash' ); ?>
							<span class="stm-red"><?php the_author_meta('nickname'); ?></span>
						</h6>
					</div>
					<div class="author_content">
						<?php echo get_the_author_meta( 'description' ); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<!--Comments-->
		<?php if ( comments_open() || get_comments_number() ) { ?>
			<div class="stm_post_comments">
				<?php comments_template(); ?>
			</div>
		<?php } ?>

	<?php echo wp_kses_post($stm_sidebar_layout_mode['content_after']); ?>


	<!--Sidebar-->
	<?php splash_display_sidebar(
		$sidebar_id,
		$stm_sidebar_layout_mode['sidebar_before'],
		$stm_sidebar_layout_mode['sidebar_after'],
		$blog_sidebar
	); ?>
</div>