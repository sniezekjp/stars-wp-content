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

if ( !function_exists( 'shortcode_price_table' ) ) {

	function shortcode_price_table( $atts, $content = null) {
		extract(shortcode_atts(array(
			'title' => 'Your title',
			'currency' => '$',
			'price' => '29',
			'sub_price' => '95',
			'time' => 'per month',
			'active' => 'no',
			'button_text' => 'Purchase',
			'button_link' => ''
		), $atts));

		$current_class=$active=='yes' ?'active':'normal';

		$html = '<div class="shortcode-price-table '.$current_class.'">';
		$html .= '<h3 class="title item-title">'.$title.'</h3>';
		$html .= '<div class="price">'.$currency.$price.'<span class="sub-price">.'.$sub_price.'</span><em class="time">'.$time.'</em></div>';
		$html .= '<div class="content">'.do_shortcode($content).'</div>';
		if($button_text && $button_link) {
			$html .= '<div class="btn"><a href="'.$button_link.'" class="button button-medium" rel="external">'.$button_text.'</a></div>';
		}
		$html .= '</div>';

		return $html;
	}

	add_shortcode('price_table', 'shortcode_price_table');
}
?>