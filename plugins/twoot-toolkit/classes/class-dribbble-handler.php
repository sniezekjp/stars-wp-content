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


if( ! class_exists( 'Twoot_Dribbble_Handler') ) {
/**
 * Twoot_Dribbble_Handler Class
 *
 * @class Twoot_Dribbble_Handler
 * @version	1.0
 * @since 1.0
 * @package ThemeWoot
 * @author ThemeWoot Team 
 */
class Twoot_Dribbble_Handler {


	/**
	 * Return the response of a call to wp_remote_get
	 *
	 * @param string $username
	 */
	public function remote_get( $username, $counts ) {

		// Fetch the Dribbble
		$response 	= wp_remote_get( 'http://api.dribbble.com/players/' . $username . '/shots/?per_page='.$counts );

		return $response;
	}


	/**
	 * Parse the RSS feed to an XML object
	 *
	 * @param string $username
	 */
	public function decoded_response_body( $username, $counts ) {

		$response = $this->remote_get( $username, $counts );

		return json_decode(wp_remote_retrieve_body( $response ));
	}


	/**
	 * Save Transient
	 *
	 * @param string $username
	 * @param string $key
	 * @param string $cache
	 */
	public function save_transient( $username, $key, $cache, $counts ) {

		if (get_transient($key)) {

			return get_option($key);

		} else {

			if(!empty($username)) {

				$dribbble_feed=$this->decoded_response_body( $username, $counts );

				if( !is_wp_error( $dribbble_feed ) && isset( $dribbble_feed ) ) {

					$response = $this->remote_get( $username, $counts );

					if( $response['headers']['status'] == 200 ) {

						$dribbbles =  $dribbble_feed->shots;

						if( $cache == false ) {
							return $dribbbles;
						} else {
							set_transient($key, $dribbbles, $cache*60*60);
							update_option($key, $dribbbles);

							return get_option($key);
						}
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
	 public function get_recent_media( $username, $key, $cache, $counts ) {

		$dribbbles=$this->save_transient( $username, $key, $cache, $counts );

		return $dribbbles;
	 }
}
}