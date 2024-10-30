<?php
/**
 * Plugin Name:       Blocks Custom CSS
 * Description:       Add custom CSS for Each Gutenberg Blocks in WordPress.
 * Requires at least: 6.5
 * Requires PHP:      7.0
 * Version:           1.0.0
 * Author:            Zakaria Binsaifullah
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       blocks-custom-css
 * Domain Path:       /languages
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Class For Blocks Custom CSS
 */
final class Blcc_Custom_CSS_Init
{
	/**
	 * Instance of this class.
	 *
	 * @var object
	 *
	 * @since 1.0.0
	 */
	protected static $instance = null;

	public function __construct()
	{
		add_action('init', array($this, 'init'));
	}

	/**
	 * Initialize the plugin.
	 */
	public function init()
	{
		add_action('plugins_loaded', array($this, 'load_text_domain'));
		$this->define_constants();
		$this->includes();
	}

	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_text_domain()
	{
		load_plugin_textdomain('blocks-custom-css', false, dirname(plugin_basename(__FILE__)) . '/languages');
	}

	/**
	 * Define the constants.
	 */
	public function define_constants()
	{
		define('BLCC_VERSION', '1.0.0');
		define('BLCC_PATH', plugin_dir_path(__FILE__));
		define('BLCC_URL', plugin_dir_url(__FILE__));
	}

	/**
	 * Include the required files.
	 */
	public function includes()
	{
		require_once BLCC_PATH . 'inc/class-enqueue.php';
		require_once BLCC_PATH . 'inc/class-style.php';
	}

	/**
	 * Singleton instance of this class.
	 *
	 * @return object
	 *
	 * @since 1.0.0
	 */
	public static function get_instance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

/**
 * Initialize the plugin.
 *
 * @return object
 */
function blcc_custom_css_init()
{
	return Blcc_Custom_CSS_Init::get_instance();
}

/**
 * Kick off the plugin.
 */
blcc_custom_css_init();
