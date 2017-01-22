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

if ( !function_exists( 'shortcode_faqs' ) )
{
	function shortcode_faqs($atts, $content = null)
	{
		extract(shortcode_atts(array(
			'counts' => '12',
			'cats'=> '',
			'posts' => '',
			'order' => 'DESC',
			'orderby' => 'date',
			'filter' => 'yes',
			'paging' => 'yes',
			'post_type'	=> 'faq',
			'taxonomy'  => 'faq_cat'
		), $atts));

		$q = new Twoot_Template_Faq(array(
			'counts' => $counts,
			'cats'=> $cats,
			'posts' => $posts,
			'order' => $order,
			'orderby' => $orderby,
			'filter' => $filter,
			'paging' => $paging,
			'post_type'	=> $post_type,
			'taxonomy'  => $taxonomy
		));

		return $q->faq();
	}

	add_shortcode('faqs', 'shortcode_faqs');
}
?>