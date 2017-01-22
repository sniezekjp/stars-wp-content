<?php
	$sidebar_id = get_theme_mod('donation_sidebar', 'primary_sidebar');
	$sidebar_position = get_theme_mod('donation_sidebar_position', 'left');

	if( !empty($sidebar_id) ) {
		$blog_sidebar = get_post( $sidebar_id );
	} else {
		$blog_sidebar = '';
	}

	if($sidebar_id == 'no_sidebar') {
		$sidebar_id = false;
	}

	$stm_sidebar_layout_mode = splash_sidebar_layout_mode($sidebar_position, $sidebar_id);

	$donation_subtitle = get_post_meta(get_the_id(), 'donor_subtitle', true);
	$donation_intro = get_post_meta(get_the_id(), 'donor_intro', true);

	$paypal_email = get_theme_mod('paypal_email', '');

?>

<div class="row">
	<?php echo wp_kses_post($stm_sidebar_layout_mode['content_before']); ?>
		<div class="stm-small-title-box">
			<?php get_template_part('partials/global/title-box'); ?>
		</div>

		<?php if(!empty($donation_subtitle)): ?>
			<div class="stm-donation-subtitle">
				<?php echo esc_attr($donation_subtitle); ?>
			</div>
		<?php endif; ?>

		<?php if(!empty($donation_intro)): ?>
			<div class="stm-donation-intro">
				<?php echo esc_attr($donation_intro); ?>
			</div>
		<?php endif; ?>

		<!--Post thumbnail-->
		<?php if ( has_post_thumbnail() ): ?>
			<div class="post-thumbnail">
				<?php the_post_thumbnail( 'stm-1170-650', array( 'class' => 'img-responsive' ) ); ?>
			</div>
		<?php endif; ?>

		<div class="clearfix">
			<div class="stm-donation-cash">
				<?php splash_donors_text(get_the_ID()); ?>
			</div>

			<div class="stm-donate">
				<a href="#" data-toggle="modal" data-target="#donationModal" class="button"><?php esc_html_e('Donate now', 'splash'); ?></a>
			</div>

		</div>

		<div class="post-content">
			<?php the_content(); ?>
			<div class="clearfix"></div>
		</div>

		<?php splash_pages_pagination(); ?>

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