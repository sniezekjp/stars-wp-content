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

if(!class_exists('Twoot_Widget_Comments')) {

	class Twoot_Widget_Comments extends WP_Widget {

		public $widget_cssclass;
		public $widget_description;
		public $widget_id;
		public $widget_name;

		//Constructor
		public function __construct() {

			/* Widget variable settings. */
			$this->widget_cssclass 		= 'widget-comments widget-post';
			$this->widget_description 	= __( 'This widget will display a comments section.', 'Twoot_Toolkit' );
			$this->widget_id            = TWOOT_TOOLKIT_SLUG. '_comments';
			$this->widget_name 			= __( 'Twoot Comments', 'Twoot_Toolkit' );

			$widget_ops = array( 
				'classname'   => $this->widget_cssclass, 
				'description' => $this->widget_description 
			);
			parent::__construct( $this->widget_id, $this->widget_name, $widget_ops );
		}

		//Form
		function form($instance) {
			$instance = wp_parse_args((array) $instance, array( 
				'title' => 'Comments',
				'showposts' => 3,
				'avatar' => 'yes'
			));
			$title = strip_tags($instance['title']);
			$showposts = strip_tags($instance['showposts']);
			$avatar = strip_tags($instance['avatar']);
			?>
			<div class="theme-widget-wrap">
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e('Title:','MATT'); ?></label>
				<input  id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</div>

			<div class="theme-widget-wrap">
			<label for="<?php echo $this->get_field_id( 'showposts' ); ?>"><?php esc_html_e('Showposts:','MATT'); ?></label>
			<input  id="<?php echo $this->get_field_id( 'showposts' ); ?>" name="<?php echo $this->get_field_name( 'showposts' ); ?>" type="text" value="<?php echo esc_attr( $showposts ); ?>" />
			</div>

			<div class="theme-widget-wrap">
			<label for="<?php echo $this->get_field_id( 'avatar' ); ?>"><?php _e('Avatar:','Twoot_Toolkit'); ?></label>
			<select name="<?php echo $this->get_field_name('avatar'); ?>">
				<option value="yes" <?php selected('yes', $avatar); ?>><?php _e('Yes','Twoot_Toolkit'); ?></option>
				<option value="no" <?php selected('no', $avatar); ?>><?php _e('No','Twoot_Toolkit'); ?></option>
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

			$title = apply_filters('widget_title', $instance['title']);
			$showposts = $instance['showposts'];
			$avatar = $instance['avatar'];	
			$my_email = get_option('admin_email'); 

			$args = array(
				'status' => 'approve',
				'type' => 'comment',
				'post_type' => array('post', 'page', 'portfolio', 'product'),
				'number' => $showposts
			);

			$comments = get_comments($args);
		?>
		<?php echo $before_widget; ?>
		<?php if($title) { echo $before_title . $title . $after_title; } ?>
			<ul>
				<?php foreach ($comments as $comment) : ?>
					<?php if ($comment->comment_author_email != $my_email) : ?>
					<li class="clearfix<?php if($avatar != 'yes') { echo ' has-not-thumbnail'; } ?>">
					<?php if($avatar == 'yes') : ?>
					<figure class="featured-image img-preload img-hover post-image">
						<a href="<?php echo get_permalink($comment->comment_post_ID).'#comment-'.$comment->comment_ID; ?>">
						<?php echo get_avatar($comment->comment_author_email,60); ?>
						<span class="overlay"></span>
						</a>
					</figure>
					<?php endif; ?>
					<section class="post-entry">
						<div class="title"><?php echo $comment->comment_author; ?>:
							<a href="<?php echo get_permalink($comment->comment_post_ID).'#comment-'.$comment->comment_ID; ?>">
								<?php echo twoot_get_frontend_func('text_truncate',  strip_tags($comment->comment_content), 60, true, '...'); ?>
							</a>
						</div>
					</section>
					</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		<?php echo $after_widget; ?>
		<?php
		}
	}

	register_widget('Twoot_Widget_Comments');
}
?>