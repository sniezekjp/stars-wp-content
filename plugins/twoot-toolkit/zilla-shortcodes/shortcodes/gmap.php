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

if ( !function_exists( 'shortcode_gmap' ) ) {
	function shortcode_gmap($atts, $content = null) {
		extract(shortcode_atts(
			array(
				'address' => '',
				'lat' => '',
				'lng' => '',
				'zoom' => '14',
				'height' => '500'
		), $atts));

		$by_latlng = '
		<script type="text/javascript">
		jQuery(document).ready(function() {
			 jQuery("#gmap").gmap3({
				marker: {
					latLng: ['.$lat.', '.$lng.']
				},
				map: {
					options: { 
						zoom: '.$zoom.',  
						scrollwheel: false,
						navigationControl: true,
                        mapTypeControl: false
					}
				}
			 });
		});
		</script>
		';

		$by_address = '
		<script type="text/javascript">
		jQuery(document).ready(function() {
			 jQuery("#gmap").gmap3({
				marker: {
					address: "'.$address.'"
				},
				map: {
					options: { 
						zoom: '.$zoom.',  
						scrollwheel: false,
						navigationControl: true,
                        mapTypeControl: false
					}
				}
			 });
		});
		</script>
		';

		$html = '<div class="shortcode-gmap">';
		$html .= '<div id="gmap" style="width:100%; height:'.$height.'px;"></div>';
		$html .= '</div>';
		$html .= $lat && $lng? $by_latlng:$by_address;

		return $html;
	}

	add_shortcode('gmap', 'shortcode_gmap');
}
?>