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


if ( !function_exists( 'shortcode_social_icon' ) ) {

	function shortcode_social_icon($atts, $content = null) {
		extract(shortcode_atts(array(
			'type' => '',
			'link' => '#'
		), $atts));

		$html = '<a href="'.$link.'" title="'.ucwords($type).'" class="shortcode-social-icon '.$type.'" rel="external"><i class="icon icon-'.$type.'"></i></a>';

		return $html;
	}

	add_shortcode('social_icon', 'shortcode_social_icon');
}
?>