<?php
if(!is_page_template('coming-soon.php')):
	$footer_image = get_theme_mod('footer_image');

	$footer_image_page = get_post_meta(get_the_ID(), 'footer_image', true);
	if(!empty($footer_image_page)) {
		$footer_image_page = wp_get_attachment_image_src($footer_image_page, 'full');
		if(!empty($footer_image_page[0])) {
			$footer_image = $footer_image_page[0];
		}
	}

	$footer_ca_text = get_theme_mod('footer_ca_text', '');
	$footer_ca_link = get_theme_mod('footer_ca_link', '');
	$footer_ca_link_text = get_theme_mod('footer_ca_link_text', '');
	$footer_ca_position = get_theme_mod('footer_ca_position', 'center');

	$footer_ca_text_page = get_post_meta(get_the_id(), 'footer_ca_text', true);
	$footer_ca_link_page = get_post_meta(get_the_id(), 'footer_ca_link', true);
	$footer_ca_link_text_page = get_post_meta(get_the_id(), 'footer_ca_link_text', true);
	$footer_ca_position_page = get_post_meta(get_the_id(), 'footer_ca_position', true);

	if(!empty($footer_ca_text_page)) {
		$footer_ca_text = $footer_ca_text_page;
	}

	if(!empty($footer_ca_link_page)) {
		$footer_ca_link = $footer_ca_link_page;
	}

	if(!empty($footer_ca_link_text_page)) {
		$footer_ca_link_text = $footer_ca_link_text_page;
	}

	if(!empty($footer_ca_position_page) and $footer_ca_position_page != 'customizer_default') {
		$footer_ca_position = $footer_ca_position_page;
	}

	$first_word = '';

	if(!empty($footer_ca_text)) {
		$footer_ca_text = explode(' ', $footer_ca_text);
		if(!empty($footer_ca_text[0])) {
			$first_word = $footer_ca_text[0];
			array_shift($footer_ca_text);
			if(!empty($footer_ca_text)) {
				$footer_ca_text = implode( ' ', $footer_ca_text );
			}
		}
	}

	if(!empty($footer_image)): ?>
		<div class="stm-footer-image" style="background-image: url('<?php echo esc_url($footer_image); ?>')">

			<div class="inner text-<?php echo esc_attr($footer_ca_position); ?>">
				<div class="container">
					<div class="heading-font title">
						<?php if(!empty($first_word)): ?>
							<span class="stm-red"><?php echo esc_attr($first_word); ?> </span>
						<?php endif; ?>
						<?php if(!empty($footer_ca_text)): ?>
							<span class="stm-text"><?php echo esc_attr($footer_ca_text); ?></span>
						<?php endif; ?>
					</div>
					<div class="clearfix"></div>
					<?php if(!empty($footer_ca_link) and !empty($footer_ca_link_text)): ?>
						<a href="<?php echo esc_url($footer_ca_link); ?>" class="button btn-md" target="_blank">
							<?php echo esc_attr($footer_ca_link_text); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>

		</div>
	<?php endif;
endif; ?>