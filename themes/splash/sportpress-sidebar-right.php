<?php
/*
Template Name: SportsPress Sidebar Right
*/
?>

<?php get_header(); ?>

<?php
	$post_types_content = splash_sportspress_side_posts();
?>



<div class="container stm-sportspress-sidebar-right">
	<div class="row">
		<div class="col-md-9">
			<?php foreach($post_types_content as $post_type => $post_type_content): ?>
				<?php if ( get_post_type() == $post_type ): ?>
					<!--CALENDAR-->
					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="<?php echo sanitize_text_field($post_type_content['class']); ?>">
							<div class="container">
								<?php if ( have_posts() ) :
									while ( have_posts() ) : the_post();
										get_template_part('partials/global/sportspress/' . $post_type_content['template'] );
									endwhile;
								endif; ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<div class="col-md-3">
			<?php get_sidebar('sportspress'); ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>