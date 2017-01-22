			</div> <!--main-->

			<?php get_template_part('partials/footer/footer-image'); ?>
		</div> <!--wrapper-->
		<div class="stm-footer">
			<?php get_template_part('partials/footer/footer-default'); ?>
		</div>

		<?php get_template_part('partials/global/modals/modals-controller'); ?>

		<?php
			if ( get_theme_mod( 'frontend_customizer' ) ) {
				get_template_part( 'partials/global/frontend_customizer' );
			}
		?>

	<?php wp_footer(); ?>
	</body>
</html>