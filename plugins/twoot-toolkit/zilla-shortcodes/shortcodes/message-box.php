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

if ( !function_exists( 'shortcode_message_box' ) ) {
	function shortcode_message_box($atts, $content = null) {
		extract(shortcode_atts(
			array(
				'style' => 'default',
				'close' => 'yes'
		), $atts));

		$class = $close == 'yes'? 'shortcode-message-box close':'shortcode-message-box';

		$html = '<div class="'.$class.'">'."\n";
		$html .= '<div class="message-box '.$style.'">';
		$html .= do_shortcode($content);
		if($close == 'yes') { 
			$html .= '<a href="#" class="close"><i class="icon"></i></a>';
		}
		$html .= '</div>'."\n";
		$html .= '</div>'."\n";

		return $html;
	}

	add_shortcode('message_box', 'shortcode_message_box');
}
?>