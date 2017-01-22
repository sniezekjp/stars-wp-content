<?php get_header();?>

	<?php
		$post_types = splash_sportspress_side_posts();
		$post_type = get_post_type();
	?>


	<?php if(!empty($post_types[$post_type])):
		$current = $post_types[$post_type]; ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="<?php echo esc_attr($current['class']) ?>">
				<div class="container">
					<?php if ( have_posts() ) :
						while ( have_posts() ) : the_post();
							get_template_part('partials/global/sportspress/' . $current['template']);
						endwhile;
					endif; ?>
				</div>
			</div>
		</div>
	<?php else: ?>
		<!--SINGLE POST-->
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="stm-single-post stm-default-page">
				<div class="container">
					<?php if ( have_posts() ) :
						while ( have_posts() ) : the_post();
							get_template_part('partials/global/post-content');
						endwhile;
					endif; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php get_footer();?>