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


if ( !function_exists( 'shortcode_icon' ) )
{
	function shortcode_icon($atts, $content = null)
	{
		extract(shortcode_atts(
			array(
				'size' => 'small',
				'name' => ''
		), $atts));

		if($name) {
			$html = '<i class="shortcode-icon '.$size.' '.$name.'"></i>';
			return $html;
		}
	}

	add_shortcode('icon', 'shortcode_icon');
}
?>