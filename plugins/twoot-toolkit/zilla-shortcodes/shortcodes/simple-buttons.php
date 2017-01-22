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



/*
* Pre
*/
if ( !function_exists( 'shortcode_pre' ) ) {

	function shortcode_pre($atts, $content = null) {
		$output = '<div class="shortcode-pre">'."\n";
		$output .= '<div class="code">'.$content.'</div>'."\n";
		$output .= '</div>'."\n";

		return $output;
	}

	add_shortcode('pre', 'shortcode_pre');
}






/*
* Opt
*/
if ( !function_exists( 'shortcode_opt' ) ) {

	function shortcode_opt($atts, $content = null) {
		extract(shortcode_atts(
			array(
				'title' => '',
				'desc' => ''
		), $atts));

		 $array = array (
			'&#8216;' => "'", 
			'&#8217;' => "'", 
			'&#8241;' => "'", 
			'&#8242;' => "'", 
			'&#8221;' => "''", 
			'&#8222;' => "''"
		);
		$content = strtr($content, $array);

		$output = '<div class="shortcode-opt">'."\n";
		$output .= '<h6 class="title">'.$title.'</h6>'."\n";
		$output .= '<p class="desc">'.stripslashes($desc).'</p>'."\n";
		$output .= '<code>'.do_shortcode($content).'</code>'."\n";
		$output .= '</div>'."\n";

		return $output;
	}

	add_shortcode('opt', 'shortcode_opt');
}





/*
* Red
*/
if ( !function_exists( 'shortcode_red' ) ) {

	function shortcode_red($atts, $content = null) {
		$output = '<span class="red">'.$content.'</span>'."\n";

		return $output;
	}

	add_shortcode('red', 'shortcode_red');
}





/*
* Blue
*/
if ( !function_exists( 'shortcode_blue' ) ) {

	function shortcode_blue($atts, $content = null) {
		$output = '<span class="blue">'.$content.'</span>'."\n";

		return $output;
	}

	add_shortcode('blue', 'shortcode_blue');
}





/*
* Clear
*/
if ( !function_exists( 'shortcode_clear' ) ) {

	function shortcode_clear($atts, $content = null) {
		$output = '<div class="clearfix"></div>'."\n";

		return $output;
	}

	add_shortcode('clear', 'shortcode_clear');
}





/*
* Hr
*/
if ( !function_exists( 'shortcode_hr' ) ) {

	function shortcode_hr($atts, $content = null) {
		extract(shortcode_atts(
			array(
				'top' => '',
				'bottom' => ''
		), $atts));

		$class = $top!=false? 'margin-top:'.$top.'px;':'';
		$class .= $bottom!=false? 'margin-bottom:'.$bottom.'px;':'';

		$output = '<div class="shortcode-hr" style="'.$class.'"></div>'."\n";

		return $output;
	}

	add_shortcode('hr', 'shortcode_hr');
}






/*
* Br
*/
if ( !function_exists( 'shortcode_br' ) ) {

	function shortcode_br($atts, $content = null) {
		extract(shortcode_atts(
			array(
				'top' => '',
		), $atts));

		$output = '<div class="shortcode-br clearfix" style="margin-top:'.$top.'px;"></div>'."\n";

		return $output;
	}

	add_shortcode('br', 'shortcode_br');
}






/*
* Row
*/
if ( !function_exists( 'shortcode_row' ) ) {

	function shortcode_row($atts, $content = null) {

		$output = '<div class="container">';
		$output .= '<div class="inner">';
		$output .= do_shortcode($content);
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	add_shortcode('row', 'shortcode_row');
}

?>