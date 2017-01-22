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


if ( !function_exists( 'shortcode_hgroup' ) )
{
	function shortcode_hgroup($atts, $content = null)
	{
		extract(shortcode_atts(
			array(
				'mt' => '',
				'mb' => '',
				'tag' => 'h3',
				'font_family' => '',
				'font_size' => '',
				'font_weight' => '',
				'font_style' => '',
				'text_transform' => '',
				'text_align' => '',
				'text_color' => ''
		), $atts));

		$css = $mt? 'margin-top:'.$mt.'px;':'';
		$css .= $mb? 'margin-bottom:'.$mb.'px;':'';
		$css .= $font_family? 'font-family:"'.$font_family.'";':'';
		$css .= $font_size? 'font-size:'.$font_size.'px;':'';
		$css .= $font_size? 'font-size:'.($font_size/10).'rem;':'';
		$css .= $font_weight? 'font-weight:'.$font_weight.';':'';
		$css .= $font_style? 'font-style:'.$font_style.';':'';
		$css .= $text_transform? 'text-transform:'.$text_transform.';':'';
		$css .= $text_align? 'text-align:'.$text_align.';':'';
		$css .= $text_color? 'color:'.$text_color.';':'';

		$html = '<'.$tag.' class="shortcode-group" style="'.$css.'">'.do_shortcode($content).'</'.$tag.'>';

		return $html;
	}

	add_shortcode('hgroup', 'shortcode_hgroup');
}
?>