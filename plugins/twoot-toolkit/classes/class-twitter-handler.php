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


if( ! class_exists( 'Twoot_Twitter_Handler') ) {
/**
 * Twoot_Twitter_Handler Class
 *
 * @class Twoot_Twitter_Handler
 * @version	1.0
 * @since 1.0
 * @package ThemeWoot
 * @author ThemeWoot Team 
 */
class Twoot_Twitter_Handler {

	/**
	 * Return the response of a call to wp_remote_get
	 *
	 * @param string $endpoint
	 * @param string $parameters
	 */
	public function remote_get( $parameters ) {

		$query = http_build_query($parameters);
		$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json?' . $query;

		return $url;
	}


	/**
	 * Returns the json_decoded response body
	 *
	 * @param string $endpoint
	 * @param array $parameters
	 */
	public function decoded_response_body( $consumer_key, $consumer_secret, $access_token, $access_token_secret, $parameters ) {

		require_once('class-twitteroauth.php');

		$connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);

		$response = $connection->get($this->remote_get( $parameters ));

		return $response;
	}


	/**
	 * Save Transient
	 *
	 * @param string $username
	 * @param string $key
	 * @param string $cache
	 */
	public function save_transient( $username, $key, $consumer_key, $consumer_secret, $access_token, $access_token_secret, $cache, $counts, $parameters=array() ) {

		if (get_transient( $key )) {

			return get_option($key);

		} else {

			if(!empty($username) && !empty($consumer_key) && !empty($consumer_secret) && !empty($access_token) && !empty($access_token_secret)) {

				$defaults = array(
					'screen_name' => $username,
					'count' => $counts
				);

				$parameters = wp_parse_args($parameters, $defaults);

				$twitter_feed = $this->decoded_response_body( $consumer_key, $consumer_secret, $access_token, $access_token_secret, $parameters );

				if( !is_wp_error( $twitter_feed ) && isset( $twitter_feed ) ) {

					$twitters = $twitter_feed;

					if( $cache == false ) {
						return $twitters;
					} else {
						set_transient($key, $twitters, $cache*60*60);
						update_option($key, $twitters);

						return get_option($key);
					}
				}
			}
		}
	}


	/**
	 * Get Recent Media
	 *
	 * @param string $username
	 * @param string $key
	 * @param string $cache
	 */
	 public function get_recent_media( $username, $key, $consumer_key, $consumer_secret, $access_token, $access_token_secret, $cache, $counts ) {

		$twitters=$this->save_transient( $username, $key, $consumer_key, $consumer_secret, $access_token, $access_token_secret, $cache, $counts, $parameters=array() );

		return $twitters;
	 }
}
}