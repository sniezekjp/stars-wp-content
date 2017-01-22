<?php
	$footer_left_text = get_theme_mod('footer_left_text', esc_html__('Copyright (c) 2016 Splash.', 'splash'));
	$footer_right_text = get_theme_mod('footer_right_text', esc_html__('Theme by Stylemix Themes.', 'splash'));

	$stm_socials = splash_socials('footer_socials');
	$footer_socials_text = get_theme_mod('footer_socials_text', esc_html__('Follow Us:', 'splash'));
?>

<div id="stm-footer-bottom">
	<div class="container">
		<div class="clearfix">

			<div class="footer-bottom-left">
				<?php if(!empty($footer_left_text)): ?>
					<div class="footer-bottom-left-text">
						<?php echo wp_kses_post($footer_left_text); ?>
					</div>
				<?php endif; ?>
			</div>


			<div class="footer-bottom-right">
				<div class="clearfix">

					<?php if(!empty($footer_right_text)): ?>
						<div class="footer-bottom-right-text">
							<?php echo wp_kses_post($footer_right_text); ?>
						</div>
					<?php endif; ?>

					<?php if(!empty($stm_socials)): ?>

						<div class="footer-socials-unit">
							<?php if(!empty($footer_socials_text)): ?>
								<div class="h6 footer-socials-title">
									<?php echo esc_attr($footer_socials_text); ?>
								</div>
							<?php endif; ?>
							<ul class="footer-bottom-socials stm-list-duty">
								<?php foreach($stm_socials as $key => $value): ?>
									<li class="stm-social-<?php echo esc_attr($key); ?>">
										<a href="<?php echo esc_attr($value); ?>" target="_blank">
											<i class="fa fa-<?php echo esc_attr($key); ?>"></i>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>

				</div>
			</div>

		</div>
	</div>
</div>