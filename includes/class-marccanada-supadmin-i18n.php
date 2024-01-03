<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       enumbin.com
 * @since      1.0.0
 *
 * @package    Marccanada_Supadmin
 * @subpackage Marccanada_Supadmin/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Marccanada_Supadmin
 * @subpackage Marccanada_Supadmin/includes
 * @author     Enamul Hassan <enamhassan96@gmail.com>
 */
class Marccanada_Supadmin_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'marccanada-supadmin',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
