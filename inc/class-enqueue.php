<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class for enqueueing assets.
 *
 * @since 1.0.0
 */
class Blcc_Enqueue_Assets
{
    /**
     * Instance of this class.
     *
     * @var object
     *
     * @since 1.0.0
     */
    protected static $instance = null;

    /**
     * Constructor.
     *
     * Initializes the class and adds the enqueue_assets() method to the 'enqueue_block_editor_assets' action.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        add_action('enqueue_block_editor_assets', array($this, 'enqueue_assets'));
    }

    /**
     * Enqueue the assets.
     *
     * @since 1.0.0
     */
    public function enqueue_assets()
    {
        $asset_file = include(BLCC_PATH . 'build/index.asset.php');

        wp_enqueue_script(
            'blocks-custom-css',
            BLCC_URL . 'build/index.js',
            $asset_file['dependencies'],
            $asset_file['version'],
            true
        );

        wp_enqueue_style(
            'blocks-custom-css',
            BLCC_URL . 'build/index.css',
            array(),
            $asset_file['version']
        );
    }

    /**
     * Get the singleton instance of this class.
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
 * @return object The instance of Blcc_Enqueue_Assets class.
 */
function blcc_enqueue_assets()
{
    return Blcc_Enqueue_Assets::get_instance();
}

// Kick off the plugin
blcc_enqueue_assets();