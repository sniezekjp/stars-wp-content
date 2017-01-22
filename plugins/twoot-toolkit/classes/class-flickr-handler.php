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


if( ! class_exists( 'Twoot_Flickr_Handler') ) {
/**
 * Twoot_Flickr_Handler Class
 *
 * @class Twoot_Flickr_Handler
 * @version	1.0
 * @since 1.0
 * @package ThemeWoot
 * @author ThemeWoot Team 
 */
class Twoot_Flickr_Handler {

	/**
	 * Return the response of a call to wp_remote_get
	 *
	 * @param string $username
	 */
	public function remote_get( $username ) {

		// Fetch the RSS feed from Flickr
		$rss_feed = wp_remote_get('http://api.flickr.com/services/feeds/photos_public.gne?id='.$username.'&format=rss');

		return $rss_feed;
	}


	/**
	 * Parse the RSS feed to an XML object
	 *
	 * @param string $username
	 */
	public function decoded_response_body( $username ) {

		$response = $this->remote_get( $username );
		$rss_feed = @simplexml_load_string( $response['body'] );

		return $rss_feed;
	}


	/**
	 * Save Transient
	 *
	 * @param string $username
	 * @param string $key
	 * @param string $cache
	 * @param string $counts
	 */
	public function save_transient( $username, $key, $cache, $counts ) {

		if (get_transient($key)) {

			return get_option($key);

		} else {

			if(!empty($username)) {

				$rss_feed=$this->decoded_response_body( $username );

				if( !is_wp_error( $rss_feed ) && isset( $rss_feed ) ) {
					$flickrs = $rss_feed->channel->item;

					if( count($flickrs) ) {
						$i = 0;
						$query = '<ul class="flickrs clearfix">';

						foreach( $flickrs as $flickr ) {

							if( $i == $counts ) { 
								break; 
							}

							// Get thumbnail size
							preg_match( '/<img[^>]*>/i', $flickr->description, $flickr_tag );
							preg_match( '/(?<=src=[\'|"])[^\'|"]*?(?=[\'|"])/i', $flickr_tag[0], $flickr_src );

							if ( preg_match( '/(_m.jpg)$/',$flickr_src[0] ) ){
								$thumb = preg_replace('/(_m.jpg)$/', '_s.jpg', $flickr_src[0] );
							} elseif( preg_match( '/(_m.png)$/', $flickr_src[0] ) ){
								$thumb = preg_replace('/(_m.png)$/', '_s.png', $flickr_src[0] );
							} elseif( preg_match( '/(_m.gif)$/', $flickr_src[0] ) ){
								$thumb = preg_replace( '/(_m.gif)$/', '_s.gif', $flickr_src[0] );
							}

							$query .= '<li class="img-preload img-hover">';
							$query .= '<a href="'.$flickr->link.'" title="'.$flickr->title.'" rel="external"><img src="'.$thumb.'" alt="'.$flickr->title.'" /><span class="overlay"></span></a>';
							$query .= '</li>';

							$i++;
						}

						$query .= '</ul>';
					}

					if( $cache == false ) {
						return $query;
					} else {
						set_transient($key, $query, $cache*60*60);
						update_option($key, $query);

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
	 * @param string $counts
	 */
	 public function get_recent_media( $username, $key, $cache, $counts ) {

		$get_flickrs=$this->save_transient( $username, $key, $cache, $counts );

		if($get_flickrs) {
			$html = $get_flickrs;
		} else {
			$html = '<div class="not-items">'.__('Oops, our Flickr feed is unavailable at the moment, please try to refresh the page.', 'Twoot_Toolkit').' - <a href="http://www.flickr.com/photos/'.$username.'/">'.__('Check our images on Flickr!', 'Twoot_Toolkit').'</a></div>';
		}

		return $html;
	 }
}
}