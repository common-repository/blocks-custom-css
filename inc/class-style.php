<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class for generating custom CSS.
 */
class Blcc_Generate_CSS
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
     * Initializes the class and adds the generate_css() method to the 'wp_head' action.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        add_filter('render_block', array($this, 'generate_css'), 10, 2);
    }

    /**
     * Generate the custom CSS.
     *
     * @since 1.0.0
     */
    public function generate_css($content, $block)
    {
        if (isset($block['blockName'])) {
            $blocksAttrs = $block['attrs'] ?? []; // Get the block attributes.

            if (empty($blocksAttrs['bccCustomCSS']) || empty($blocksAttrs['bccDynamicClass'])) {
                return $content;
            }

            $bccCustomCSS = $blocksAttrs['bccCustomCSS'] ?? ''; // Get the custom CSS.
            $bccDynamicClass = $blocksAttrs['bccDynamicClass'] ?? ''; // Get the dynamic class.

            // Add dynamic class to the block.
            $content = str_replace('class="', 'class="' . $bccDynamicClass . ' ', $content);

            $bccDynamicSelector = '.' . $bccDynamicClass;

            // Replace all selector with dynamic class.
            $bccCustomCSS = str_replace('selector', $bccDynamicSelector, $bccCustomCSS);

            // Minify style to remove extra space.
            $bccCustomCSS = preg_replace('/\s+/', ' ', $bccCustomCSS);

            // Register style.
            wp_register_style($bccDynamicClass, false, [], BLCC_VERSION, 'all');

            // Enqueue the style.
            wp_enqueue_style($bccDynamicClass, false, [], BLCC_VERSION, 'all');

            // Inline the style.
            wp_add_inline_style($bccDynamicClass, $bccCustomCSS);
        }

        return $content;
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
 * Get the instance of the Blcc_Generate_CSS class.
 */
function blcc_generate_css()
{
    return Blcc_Generate_CSS::get_instance();
}

// Initialize the Blcc_Generate_CSS class.
blcc_generate_css();