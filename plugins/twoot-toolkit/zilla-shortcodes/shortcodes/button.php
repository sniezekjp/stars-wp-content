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

if ( !function_exists( 'shortcode_button' ) ) {
	function shortcode_button($atts, $content = null) {
		extract(shortcode_atts(
			array(
				'style' => 'default',
				'size' => 'medium',
				'link' => '',
				'target' => 'self'
		), $atts));

		if($content) {
			$html = '<a href="'.$link.'" target="_'.$target.'" class="shortcode-button button button-'.$style.' button-'.$size.'">'.do_shortcode($content).'</a>'."\n";
			return $html;
		}
	}

	add_shortcode('button', 'shortcode_button');
}
?>