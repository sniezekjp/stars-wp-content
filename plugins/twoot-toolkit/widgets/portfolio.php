<?php
/**
 * @package WordPress
 * @subpackage ThemeWoot
 * @author ThemeWoot Team 
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if(!class_exists('Twoot_Widget_Portfolio')) {

	class Twoot_Widget_Portfolio extends WP_Widget {

		public $widget_cssclass;
		public $widget_description;
		public $widget_id;
		public $widget_name;

		//Constructor
		public function __construct() {

			/* Widget variable settings. */
			$this->widget_cssclass 		= 'widget-portfolio widget-post';
			$this->widget_description 	= __( 'This widget will display a portfolio section.', 'Twoot_Toolkit' );
			$this->widget_id            = TWOOT_TOOLKIT_SLUG. '_portfolio';
			$this->widget_name 			= __( 'Twoot Portfolio Posts', 'Twoot_Toolkit' );

			$widget_ops = array( 
				'classname'   => $this->widget_cssclass, 
				'description' => $this->widget_description 
			);
			parent::__construct( $this->widget_id, $this->widget_name, $widget_ops );
		}

		//Form
		function form($instance) {
			$instance = wp_parse_args((array) $instance, array( 
				'title' => 'Portfolios',
				'counts' => 3,
				'cats' => '',
				'posts' => '',
				'orderby' => 'date',
				'order' => 'ASC'
			));
			$title = strip_tags($instance['title']);
			$counts = strip_tags($instance['counts']);
			$cats = strip_tags($instance['cats']);
			$posts = strip_tags($instance['posts']);
			$orderby = strip_tags($instance['orderby']);
			$order = strip_tags($instance['order']);
			?>
			<div class="theme-widget-wrap">
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:','Twoot_Toolkit'); ?></label>
				<input  id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</div>

			<div class="theme-widget-wrap">
			<label for="<?php echo $this->get_field_id( 'counts' ); ?>"><?php _e('Counts:','Twoot_Toolkit'); ?></label>
			<input  id="<?php echo $this->get_field_id( 'counts' ); ?>" name="<?php echo $this->get_field_name( 'counts' ); ?>" type="text" value="<?php echo esc_attr( $counts ); ?>" />
			</div>

			<div class="theme-widget-wrap">
				<label for="<?php echo $this->get_field_id( 'cats' ); ?>"><?php _e('Cats:','Twoot_Toolkit'); ?></label>
				<textarea  id="<?php echo $this->get_field_id( 'cats' ); ?>" name="<?php echo $this->get_field_name( 'cats' ); ?>"  rows="3"><?php echo esc_attr( $cats ); ?></textarea>
				<p class="theme-description"><?php _e('Category IDs, separated by commas.', 'Twoot_Toolkit'); ?></p>
			</div>

			<div class="theme-widget-wrap">
				<label for="<?php echo $this->get_field_id( 'posts' ); ?>"><?php _e('Posts:','Twoot_Toolkit'); ?></label>
				<textarea  id="<?php echo $this->get_field_id( 'posts' ); ?>" name="<?php echo $this->get_field_name( 'posts' ); ?>"  rows="3"><?php echo esc_attr( $posts ); ?></textarea>
				<p class="theme-description"><?php _e('Post IDs, separated by commas.', 'Twoot_Toolkit'); ?></p>
			</div>

			<div class="theme-widget-wrap">
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e('Orderby:','Twoot_Toolkit'); ?></label>
			<select name="<?php echo $this->get_field_name('orderby'); ?>">
				<option value="date" <?php selected('date', $orderby); ?>><?php _e('Date','Twoot_Toolkit'); ?></option>
				<option value="comment_count" <?php selected('comment_count', $orderby); ?>><?php _e('Comment','Twoot_Toolkit'); ?></option>
				<option value="rand" <?php selected('rand', $orderby); ?>><?php _e('Rand','Twoot_Toolkit'); ?></option>
				<option value="ID" <?php selected('ID', $orderby); ?>><?php _e('ID','Twoot_Toolkit'); ?></option>
				<option value="title" <?php selected('title', $orderby); ?>><?php _e('title','Twoot_Toolkit'); ?></option>
			</select>
			</div>

			<div class="theme-widget-wrap">
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e('Order:','Twoot_Toolkit'); ?></label>
			<select name="<?php echo $this->get_field_name('order'); ?>">
				<option value="ASC" <?php selected('ASC', $order); ?>><?php _e('ASC','Twoot_Toolkit'); ?></option>
				<option value="DESC" <?php selected('DESC', $order); ?>><?php _e('DESC','Twoot_Toolkit'); ?></option>
			</select>
			</div>
			<?php
		}

		//Update & Save The Widget
		function update($new_instance, $old_instance) {
			$instance = $old_instance;	
			foreach($new_instance as $key=>$value)
			{
				$instance[$key]	= strip_tags($new_instance[$key]);
			}
			return $instance;
		}

		//Prints the widget
		function widget($args, $instance) {
			extract($args, EXTR_SKIP);
			global $post;

			$title = apply_filters('widget_title', $instance['title']);
			$counts = $instance['counts'];
			$cats = $instance['cats'];
			$posts = $instance['posts'];
			$orderby = $instance['orderby'];
			$order = $instance['order'];

			// Get Query
			$query = new Twoot_Query(array(
				'counts' => $counts,
				'cats'=> $cats,
				'posts' => $posts,
				'order' => $order,
				'orderby' => $orderby,
				'post_type'	=> 'portfolio',
				'taxonomy'  => 'portfolio_cat'
			));

			$do_query = new WP_Query($query->do_template_query());
		?>
		<?php echo $before_widget; ?>
		<?php if($title) { echo $before_title . $title . $after_title; } ?>
			<ul>
				<?php while ($do_query->have_posts()) : $do_query->the_post(); ?>
				<li class="clearfix<?php if(!has_post_thumbnail()) { echo ' has-not-thumbnail'; } ?>">
				<?php if(has_post_thumbnail()) : ?>
				<figure class="featured-image img-preload img-hover post-image">
					<a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail( $post->ID, 'thumbnail' ); ?>
					<div class="overlay"></div>
					</a>
				</figure>
				<?php endif; ?>
				<section class="post-entry">
				<div class="title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'Twoot_Toolkit' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a></div>
				<div class="desc"><?php echo twoot_generator('the_excerpt', 40, true, '...'); ?></div>
				</section>
				</li>
				<?php endwhile; wp_reset_postdata(); ?>
			</ul>
		<?php echo $after_widget; ?>
		<?php
		}
	}

	register_widget('Twoot_Widget_Portfolio');
}
?>