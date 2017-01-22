<?php
/*
Template Name: SportsPress Sidebar Left
*/
get_header();

$content = 'col-md-9';
$has_sidebar = true;
if(!empty($_GET['sidebar-full'])) {
	$has_sidebar = false;
	$content = 'col-md-12';
}

$post_types_content = splash_sportspress_side_posts();

?>

<div class="container stm-sportspress-sidebar-left">
	<div class="row">
		<?php if($has_sidebar): ?>
			<div class="col-md-3">
				<?php get_sidebar('sportspress'); ?>
			</div>
		<?php endif; ?>
		<div class="<?php echo esc_attr($content); ?>">
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
	</div>
</div>

<?php get_footer(); ?>