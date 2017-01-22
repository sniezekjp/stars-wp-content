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

if(!class_exists('Twoot_Widget_Portfolio_Tags')) {

	class Twoot_Widget_Portfolio_Tags extends WP_Widget {

		public $widget_cssclass;
		public $widget_description;
		public $widget_id;
		public $widget_name;

		//Constructor
		public function __construct() {

			/* Widget variable settings. */
			$this->widget_cssclass 		= 'widget_tag_cloud';
			$this->widget_description 	= __( 'This widget will display a portfolio tag section.', 'Twoot_Toolkit' );
			$this->widget_id            = TWOOT_TOOLKIT_SLUG. '_portfolio_tags';
			$this->widget_name 			= __( 'Twoot Portfolio Tags', 'Twoot_Toolkit' );

			$widget_ops = array( 
				'classname'   => $this->widget_cssclass, 
				'description' => $this->widget_description 
			);
			parent::__construct( $this->widget_id, $this->widget_name, $widget_ops );
		}

		//Form
		function form($instance) {
			$instance = wp_parse_args((array) $instance, array( 
				'title' => 'Tags',
				'number' => '20',
				'orderby' => 'name',
				'order' => 'ASC'
			));
			$title = strip_tags($instance['title']);
			$number = strip_tags($instance['number']);
			$orderby = strip_tags($instance['orderby']);
			$order = strip_tags($instance['order']);
			?>
			<div class="theme-widget-wrap">
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'Twoot_Toolkit'); ?></label>
				<input  id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</div>

			<div class="theme-widget-wrap">
				<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Number:', 'Twoot_Toolkit'); ?></label>
				<input  id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
			</div>

			<div class="theme-widget-wrap">
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e('Orderby:','Twoot_Toolkit'); ?></label>
			<select name="<?php echo $this->get_field_name('orderby'); ?>">
				<option value="name" <?php selected('name', $orderby); ?>><?php _e('Name','Twoot_Toolkit'); ?></option>
				<option value="count" <?php selected('count', $orderby); ?>><?php _e('Count','Twoot_Toolkit'); ?></option>
			</select>
			</div>

			<div class="theme-widget-wrap">
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e('Order:','Twoot_Toolkit'); ?></label>
			<select name="<?php echo $this->get_field_name('order'); ?>">
				<option value="ASC" <?php selected('ASC', $order); ?>><?php _e('ASC','Twoot_Toolkit'); ?></option>
				<option value="DESC" <?php selected('DESC', $order); ?>><?php _e('DESC','Twoot_Toolkit'); ?></option>
				<option value="RAND" <?php selected('RAND', $order); ?>><?php _e('RAND','Twoot_Toolkit'); ?></option>
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
			$number = $instance['number'];
			$orderby = $instance['orderby'];
			$order = $instance['order'];

			$args = array(
				'smallest' => 12,
				'largest' => 12,
				'unit' => 'px',
				'number' => $number,
				'orderby' => $orderby,
				'order' => $order,
				'taxonomy' => 'portfolio_tag'
			);
		?>
		<?php echo $before_widget; ?>
		<?php if($title) { echo $before_title . $title . $after_title; } ?>
			<div class="tagcloud clearfix"><?php wp_tag_cloud($args); ?></div>
		<?php echo $after_widget; ?>
		<?php
		}
	}

	register_widget('Twoot_Widget_Portfolio_Tags');
}
?>