<?php
/*
Shortcodes
*/

class Twoot_Shortcodes {

	/**
	 * Registers Shotcodes
	 *
	 * @return	void
	 */
	function init($shortcodes)
	{
		$located = '';
		foreach ($shortcodes as $file) {

			$current_file = TWOOT_CURRENT_THEME_PATH . '/theme/shortcodes/' . str_replace( '_', '-', $file ) . '.php';
			$toolkit_file = TWOOT_TOOLKIT_PATH . '/zilla-shortcodes/shortcodes/' . str_replace( '_', '-', $file ) . '.php';

			if ( file_exists($current_file) ) {

				$located = $current_file;

			} elseif ( file_exists($toolkit_file) ) { 

				$located = $toolkit_file;

			}
			include_once( $located );
		}
	}

}
?>