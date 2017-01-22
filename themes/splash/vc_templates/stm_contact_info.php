<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if(!empty($image)) {
	$post_thumbnail = wpb_getImageBySize( array(
		'attach_id'  => $image,
		'thumb_size' => $image_size
	) );
}

?>

<div class="stm-contact-info">
	<?php if(!empty($post_thumbnail['thumbnail'])): ?>
		<div class="image">
			<?php echo wp_kses_post($post_thumbnail['thumbnail']); ?>
		</div>
	<?php endif; ?>

	<?php if(!empty($title)): ?>
		<div class="title h5"><?php echo esc_attr($title); ?></div>
	<?php endif; ?>

	<?php if(!empty($subtitle)): ?>
		<div class="subtitle h6"><?php echo esc_attr($subtitle); ?></div>
	<?php endif; ?>

	<div class="stm-contacts">
		<?php if(!empty($phone)): ?>
			<div class="stm-single-contact stm-phone">
				<i class="fa fa-phone"></i>
				<div class="contact-label"><?php esc_html_e('Phone', 'splash'); ?></div>
				<div class="contact-value h4"><?php echo esc_attr($phone); ?></div>
			</div>
		<?php endif; ?>

		<?php if(!empty($fax)): ?>
			<div class="stm-single-contact stm-fax">
				<i class="fa fa-fax"></i>
				<div class="contact-label"><?php esc_html_e('Fax', 'splash'); ?></div>
				<div class="contact-value h4"><?php echo esc_attr($fax); ?></div>
			</div>
		<?php endif; ?>

		<?php if(!empty($email)): ?>
			<div class="stm-single-contact stm-email">
				<i class="fa fa-envelope"></i>
				<div class="contact-label"><?php esc_html_e('Email', 'splash'); ?></div>
				<div class="contact-value">
					<a href="mailto:<?php echo esc_attr($email) ?>">
						<?php echo esc_attr($email); ?>
					</a>
				</div>
			</div>
		<?php endif; ?>

		<?php if(!empty($url)): ?>
			<div class="stm-single-contact stm-url">
				<i class="fa fa-link"></i>
				<div class="contact-value">
					<a href="<?php echo esc_url($url) ?>" target="_blank">
						<?php echo esc_attr($url); ?>
					</a>
				</div>
			</div>
		<?php endif; ?>

	</div>
</div>