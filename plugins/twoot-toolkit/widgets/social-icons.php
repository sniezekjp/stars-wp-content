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

if(!class_exists('Twoot_Widget_Social_Icons')) {

	class Twoot_Widget_Social_Icons extends WP_Widget {

		public $widget_cssclass;
		public $widget_description;
		public $widget_id;
		public $widget_name;

		//Constructor
		public function __construct() {

			/* Widget variable settings. */
			$this->widget_cssclass 		= 'widget-social-icons';
			$this->widget_description 	= __( 'This widget will display a social icons section.', 'Twoot_Toolkit' );
			$this->widget_id            = TWOOT_TOOLKIT_SLUG. '_social_icons';
			$this->widget_name 			= __( 'Twoot Social Icons', 'Twoot_Toolkit' );

			$widget_ops = array( 
				'classname'   => $this->widget_cssclass, 
				'description' => $this->widget_description 
			);
			parent::__construct( $this->widget_id, $this->widget_name, $widget_ops );
		}

		//Form
		function form($instance) {
			$instance = wp_parse_args((array) $instance, array( 
				'title' => 'Social Icons'
			));
			$title = strip_tags($instance['title']);
			?>
			<div class="theme-widget-wrap">
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e('Title:','Twoot_Toolkit'); ?></label>
				<input  id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</div>

			<div class="theme-widget-wrap">
				<?php esc_html_e('Please set your social icons in the theme options first.','Twoot_Toolkit'); ?>
			</div>
			<?php
		}

		//Update & save the widget
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

			$icons = twoot_generator('icons');

			$current_icons = twoot_get_frontend_func('opt', 'opt', 'widget_social_icons');
			$all_icons = array('behance', 'dribbble', 'facebook', 'flickr', 'fivehundredpx', 'gplus', 'linkedin', 'instagram', 'pinterest', 'rss', 'soundcloud', 'tumblr', 'twitter', 'vimeo', 'youtube');

			echo $before_widget;

			if($title) { 
				echo $before_title . $title . $after_title; 
			}

			echo '<div class="social-icons-wrap clearfix">';

			if(is_array($current_icons) && !empty($current_icons)) {
				foreach($current_icons as $current_icon)
				{
					if(in_array($current_icon, $all_icons, true))
					{
						if($icons[$current_icon]) { 
							echo '<a href="'.$icons[$current_icon].'" class="'.$current_icon.'" rel="external"><i class="icon icon-'.$current_icon.'"></i></a>'; 
						}
					}
				}
			}

			echo '</div>';

			echo $after_widget;
		}
	}
	
	register_widget('Twoot_Widget_Social_Icons');
}
?>