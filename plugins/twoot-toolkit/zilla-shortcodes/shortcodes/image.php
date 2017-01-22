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


if ( !function_exists( 'shortcode_image' ) )
{
	function shortcode_image($atts, $content = null)
	{
		extract(shortcode_atts(
			array(
				'title' => '',
				'url' => '',
				'width' => 460,
				'height' => 245,
				'crop' => 'yes',
				'link' => '',
				'lightbox' => 'yes'
		), $atts));

		$_title = $title? ' title="'.$title.'"':'';
		$crop = $crop=='yes'? true:false;

		$html = '<div class="shortcode-image">';

		$html .= '<div class="img img-hover">';
		if($link) {
			$html .= '<a href="'.$link.'"'.$_title.'>';
			$html .= twoot_get_frontend_func('resize_thumbnail_by_url', $url, $title, $width, $height, $crop);
			$html .= '<div class="overlay"></div>';
			$html .= '</a>';
		} elseif($lightbox=='yes') {
			$html .= '<a href="'.$url.'"'.$_title.' class="fancybox-gallery">';
			$html .= twoot_get_frontend_func('resize_thumbnail_by_url', $url, $title, $width, $height, $crop);
			$html .= '<div class="overlay"></div>';
			$html .= '</a>';
		} else {
			$html .= twoot_get_frontend_func('resize_thumbnail_by_url', $url, $title, $width, $height, $crop);
			$html .= '<div class="overlay"></div>';
		}
		$html .= '</div>';

		if($title) {
			$html .= '<div class="image-caption">'.$title.'</div>';
		}

		$html .= '</div>';

		return $html;
	}

	add_shortcode('image', 'shortcode_image');
}




if ( !function_exists( 'shortcode_vc_image' ) )
{
	function shortcode_vc_image($atts, $content = null)
	{
		extract(shortcode_atts(
			array(
				'title' => '',
				'id' => '',
				'width' => 460,
				'height' => 245,
				'crop' => 'yes',
				'link' => '',
				'lightbox' => 'yes'
		), $atts));

		$_title = $title? ' title="'.$title.'"':'';
		$crop = $crop=='yes'? true:false;

		$html = '<div class="shortcode-image">';

		$html .= '<div class="img img-hover">';
		if($link) {
			$html .= '<a href="'.$link.'"'.$_title.'>';
			$html .= twoot_get_frontend_func('resize_thumbnail', $id, $title, $width, $height, $crop);
			$html .= '<div class="overlay"></div>';
			$html .= '</a>';
		} elseif($lightbox=='yes') {
			$html .= '<a href="'.twoot_get_frontend_func('thumbnail_url', $id).'"'.$_title.' class="fancybox-gallery">';
			$html .= twoot_get_frontend_func('resize_thumbnail', $id, $title, $width, $height, $crop);
			$html .= '<div class="overlay"></div>';
			$html .= '</a>';
		} else {
			$html .= twoot_get_frontend_func('resize_thumbnail', $id, $title, $width, $height, $crop);
			$html .= '<div class="overlay"></div>';
		}
		$html .= '</div>';

		if($title) {
			$html .= '<div class="image-caption">'.$title.'</div>';
		}

		$html .= '</div>';

		return $html;
	}

	add_shortcode('vc_image', 'shortcode_vc_image');
}
?>