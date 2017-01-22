<div class="col-md-4 col-sm-6">
	<div <?php post_class('stm-single-post-loop'); ?>>
		<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">

			<?php if(has_post_thumbnail() and !is_search()): ?>
				<div class="image">
					<div class="stm-plus"></div>
					<?php the_post_thumbnail('stm-570-350', array('class' => 'img-responsive')); ?>
					<?php if(is_sticky(get_the_id())): ?>
						<div class="stm-sticky-post heading-font"><?php esc_html_e('Sticky Post','splash'); ?></div>
					<?php endif; ?>
				</div>
			<?php else: ?>
				<?php if(is_sticky(get_the_id())): ?>
					<div class="stm-sticky-post stm-sticky-no-image heading-font"><?php esc_html_e('Sticky Post','splash'); ?></div>
				<?php endif; ?>
			<?php endif; ?>


			<div class="date heading-font">
				<?php echo esc_attr(get_the_date()); ?>
			</div>

			<div class="title heading-font">
				<?php the_title(); ?>
			</div>
		</a>

		<div class="content">
			<?php the_excerpt(); ?>
		</div>

		<div class="post-meta heading-font">
			<?php $comments_num = get_comments_number(get_the_id()); ?>
			<?php if($comments_num): ?>
				<div class="comments-number">
					<a href="<?php the_permalink() ?>#comments">
						<i class="fa fa-commenting"></i>
						<span><?php echo esc_attr($comments_num); ?></span>
					</a>
				</div>
			<?php else: ?>
				<div class="comments-number">
					<a href="<?php the_permalink() ?>#comments">
						<i class="fa fa-commenting"></i>
						<span>0</span>
					</a>
				</div>
			<?php endif; ?>

			<?php $posttags = get_the_tags();
			if ($posttags): ?>
				<div class="post_list_item_tags">
					<?php $count = 0; foreach($posttags as $tag): $count++; ?>
						<?php if($count == 1): ?>
							<a href="<?php echo get_tag_link($tag->term_id); ?>">
								<i class="fa fa-tag"></i>
								<?php echo($tag->name); ?>
							</a>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

	</div>
</div>