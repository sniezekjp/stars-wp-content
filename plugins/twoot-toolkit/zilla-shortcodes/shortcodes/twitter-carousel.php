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

if ( !function_exists( 'shortcode_twitter_carousel' ) ) {

	function shortcode_twitter_carousel($atts, $content = null) {
		extract(shortcode_atts(
			array(
				'counts' => 5,
				'cache' => 1,
				'auto' => 'true',
				'speed' => '800',
				'pause' => '5000',
				'mode' => 'fade'
		), $atts));

		$opts = get_option( TWOOT_TOOLKIT_OPTIONS );
		$username = trim($opts['twitter_username']);
		$key = 'cache_twitter_carousel';
		$consumer_key = trim($opts['twitter_ck']);
		$consumer_secret = trim($opts['twitter_cs']);
		$access_token = trim($opts['twitter_at']);
		$access_token_secret = trim($opts['twitter_ats']);

		$do_query = new Twoot_Twitter_Handler();
		$twitters=$do_query->get_recent_media( $username, $key, $consumer_key, $consumer_secret, $access_token, $access_token_secret, $cache, $counts );

		$html = '<div class="shortcode-twitter-carousel">';

		if( $twitters ) {
			$i = 0;
			$html .= '<div class="icon"><i class="icon-twitter-bird"></i></div>';
			$html .= '<ul class="twitter-carousel" data-auto="'.$auto.'" data-speed="'.$speed.'" data-pause="'.$pause.'" data-mode="'.$mode.'">';

			foreach( $twitters as $twitter ) {

				if( $i == $counts ) {
					break;
				}

				$html .= '<li>';
				$html .= twoot_get_frontend_func('twitter_convert_links', $twitter->text);
				$html .= '<span class="date meta"><a class="twitter_time" target="_blank" href="http://twitter.com/'.$username.'/statuses/'.$twitter->id_str.'">'. twoot_get_frontend_func('twitter_relative_time', $twitter->created_at).'</a></span>';
				$html .= '</li>';
				
				$i++;
			}
			$html .= '</ul>';
			$html .= '<div class="follow-us"><strong>'.__('Follow Us', 'Twoot_Toolkit').'</strong> - <a href="http://twitter.com/'.$username.'" rel="external">@'.$username.'</a></div>';

		} else {
			$html .= '<div class="not-items">'.__('Oops, our Twitter feed is unavailable at the moment.', 'Twoot_Toolkit').'</div>';
		}

		$html .= '</div>';
	
		return $html;
	}

	add_shortcode('twitter_carousel', 'shortcode_twitter_carousel');
}
?>