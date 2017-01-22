<?php
	$top_bar_bg_color = get_theme_mod('top_bar_bg_color');
	$top_bar_text_color = get_theme_mod('top_bar_text_color');

	$style_opt = array();

	if(!empty($top_bar_bg_color)) {
		$style_opt['background-color'] = $top_bar_bg_color;
	}

	if(!empty($top_bar_text_color)) {
		$style_opt['color'] = $top_bar_text_color;
	}

	$style = splash_generate_inline_style($style_opt);
?>

<div id="stm-top-bar" <?php echo sanitize_text_field($style); ?>>

	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-6">

				<div class="stm-top-ticker-holder">
					<?php get_template_part('partials/header/top-bar-ticker'); ?>
				</div>

			</div>

			<div class="col-md-6 col-sm-6">

				<div class="clearfix">
					<div class="stm-top-bar_right">
						<div class="clearfix">
							<div class="stm-top-switcher-holder">
								<?php get_template_part('partials/header/top-bar-switcher'); ?>
							</div>

							<div class="stm-top-cart-holder">
								<?php get_template_part('partials/header/top-bar-cart'); ?>
							</div>
						</div>
					</div>

					<div class="stm-top-socials-holder">
						<?php get_template_part('partials/header/top-bar-socials'); ?>
					</div>

				</div>

			</div>
		</div>
	</div>

</div>