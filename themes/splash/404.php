<?php get_header(); ?>

	<div class="stm-default-page stm-default-page-404">
		<div class="container">
			<div class="text-center heading-font">
				<div class="stm-red stm-404-warning">!</div>
				<div class="stm-red stm-404-warning"><?php esc_html_e('404', 'splash'); ?></div>
				<div class="h1 text-transform"><?php esc_html_e('Page not found', 'splash'); ?></div>
				<div class="h5 text-transform">
					<?php esc_html_e('It looks like nothing was found at this location. Maybe try a search?', 'splash'); ?>
				</div>
			</div>
		</div>
	</div>


<?php get_footer(); ?>