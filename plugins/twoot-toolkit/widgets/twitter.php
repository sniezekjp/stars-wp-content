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

if(!class_exists('Twoot_Widget_Twitter')) {

	class Twoot_Widget_Twitter extends WP_Widget {

		public $widget_cssclass;
		public $widget_description;
		public $widget_id;
		public $widget_name;

		//Constructor
		public function __construct() {

			/* Widget variable settings. */
			$this->widget_cssclass 		= 'widget-twitters widget-post';
			$this->widget_description 	= __( 'This widget will display a twitters section.', 'Twoot_Toolkit' );
			$this->widget_id            = TWOOT_TOOLKIT_SLUG. '_twitter';
			$this->widget_name 			= __( 'Twoot Twitter', 'Twoot_Toolkit' );

			$widget_ops = array( 
				'classname'   => $this->widget_cssclass, 
				'description' => $this->widget_description 
			);
			parent::__construct( $this->widget_id, $this->widget_name, $widget_ops );
		}

		//Form
		function form($instance) {
			$instance = wp_parse_args((array) $instance, array( 
				'title' => 'Twitter',
				'counts' => 3,
				'cache' => 12
			));
			$title = strip_tags($instance['title']);
			$counts = strip_tags($instance['counts']);
			$cache = strip_tags($instance['cache']);
			?>
			<div class="theme-widget-wrap">
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e('Title:','Twoot_Toolkit'); ?></label>
				<input  id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</div>

			<div class="theme-widget-wrap">
				<label for="<?php echo $this->get_field_id( 'counts' ); ?>"><?php esc_html_e('Counts:','Twoot_Toolkit'); ?></label>
				<input  id="<?php echo $this->get_field_id( 'counts' ); ?>" name="<?php echo $this->get_field_name( 'counts' ); ?>" type="text" value="<?php echo esc_attr( $counts ); ?>" />
			</div>

			<div class="theme-widget-wrap">
				<label for="<?php echo $this->get_field_id( 'cache' ); ?>"><?php esc_html_e('Cache:','Twoot_Toolkit'); ?></label>
				<input  id="<?php echo $this->get_field_id( 'cache' ); ?>" name="<?php echo $this->get_field_name( 'cache' ); ?>" type="text" value="<?php echo esc_attr( $cache ); ?>" />
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

			// Refresh Cache
			delete_option('cache_'.$this->id_base.'-'.$this->number);
		}

		//Prints the widget
		function widget($args, $instance) {
			extract($args, EXTR_SKIP);

			$opts = get_option( TWOOT_TOOLKIT_OPTIONS );
			$title = apply_filters('widget_title', $instance['title']);
			$username = trim($opts['twitter_username']);
			$key = 'cache_'.$widget_id;
			$consumer_key = trim($opts['twitter_ck']);
			$consumer_secret = trim($opts['twitter_cs']);
			$access_token = trim($opts['twitter_at']);
			$access_token_secret = trim($opts['twitter_ats']);
			$counts = $instance['counts'];
			$cache = $instance['cache'];

			$do_query = new Twoot_Twitter_Handler();
			$twitters=$do_query->get_recent_media( $username, $key, $consumer_key, $consumer_secret, $access_token, $access_token_secret, $cache, $counts );

			echo $before_widget;

			if($title) { 
				echo $before_title . $title . $after_title; 
			}

			if( $twitters ) {
				$i = 0;
				echo '<ul class="tweets-feed clearfix">';

				foreach( $twitters as $twitter ) {

					if( $i == $counts ) {
						break;
					}
					
					echo '<li>';
					echo twoot_get_frontend_func('twitter_convert_links', $twitter->text);
					echo '<span class="date meta"><a class="twitter_time" target="_blank" href="http://twitter.com/'.$username.'/statuses/'.$twitter->id_str.'">'. twoot_get_frontend_func('twitter_relative_time', $twitter->created_at).'</a></span>';
					echo '</li>';
					
					$i++;
				}

				echo '</ul>';
			} else {
				echo '<div class="not-items">'.__('Oops, our Twitter feed is unavailable at the moment.', 'Twoot_Toolkit').'</div>';
			}
			
			echo $after_widget;
		}
	}
	
	register_widget('Twoot_Widget_Twitter');
}
?>