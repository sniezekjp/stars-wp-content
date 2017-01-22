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

if ( !function_exists( 'shortcode_video' ) ) {

	function shortcode_video($atts, $content = null) {
		extract(shortcode_atts(
			array(
				'type' => '',
				'url' => '',
				'embed' => '',
				'width' => '',
				'height' => ''
		), $atts));

		$tag='iframe';
		if($width == false) { $width = 1170; }
		if($height == false) { $height = $width * 9/16; }

		if($type=='youtube')
		{
			$args = array (
				'http://www.youtube.com/watch?v=', 
				'http://youtu.be/',
				'http://www.youtube.com/embed/'
			);
		}
		else
		{
			$args = array (
				'http://vimeo.com/',
				'http://player.vimeo.com/video/'
			);
		}
		$id = trim(str_replace( $args, '', $url ));

		$html = '<div class="shortcode-video fitvids">';
		if($embed) {
			$html .= $embed;
		}else{
			if($type=='youtube') {
				$html .= '<'.$tag.' width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$id.'?rel=0" frameborder="0" allowfullscreen></'.$tag.'>';
			}elseif($type=='vimeo') {
				$html .= '<'.$tag.' width="'.$width.'" height="'.$height.'" src="http://player.vimeo.com/video/'.$id.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></'.$tag.'>';
			}
		}
		$html .= '</div>';

		return $html;
	}

	add_shortcode('video', 'shortcode_video');
}
?>