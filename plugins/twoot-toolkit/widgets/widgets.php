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

if(!class_exists('Twoot_Widgets')) {

	class Twoot_Widgets {

		/**
		 * Registers Widgets
		 *
		 */
		function init($widgets)
		{
			$located = '';
			foreach ($widgets as $file) {

				$current_file = TWOOT_CURRENT_THEME_PATH . '/theme/widgets/' . str_replace( '_', '-', $file ) . '.php';
				$toolkit_file = TWOOT_TOOLKIT_PATH . '/widgets/' . str_replace( '_', '-', $file ) . '.php';

				if ( file_exists($current_file) ) {

					$located = $current_file;

				} elseif ( file_exists($toolkit_file) ) { 

					$located = $toolkit_file;

				}
				include_once( $located );
			}
		}
	}

}
?>