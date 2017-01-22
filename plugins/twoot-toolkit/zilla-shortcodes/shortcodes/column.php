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

if ( !function_exists( 'shortcode_columns' ) )
{
	function shortcode_columns( $atts, $content = null) {
		global $columns_array;
		$columns_array = array();

		do_shortcode($content);

		$html = '<div class="shortcode-columns outer clearfix">';
		
		foreach( $columns_array as $column ) {
			switch($column['col']) {
				case '1/2': $grid = 'six'; break;
				case '1/3': $grid = 'four'; break;
				case '1/4': $grid = 'three'; break;
				case '1/6': $grid = 'two'; break;
				case '2/3': $grid = 'eight'; break;
				case '3/4': $grid = 'nine'; break;
				case '5/6': $grid = 'ten'; break;
			}

			$html .= '<div class="'.$grid.' column"><div class="inner">' .do_shortcode($column['content']). '</div></div>'."\n";
		}
			
		$html .= '</div>';
		
		return $html;
	}


	function shortcode_column( $atts, $content = null) {
		extract(shortcode_atts(array(
			'col' => '1/2'
		), $atts));

		global $columns_array;

		$columns_array[] = array(
			'col' => $col,
			'content' => $content
		);
	}

	add_shortcode('columns', 'shortcode_columns');
	add_shortcode('column', 'shortcode_column');
}
?>