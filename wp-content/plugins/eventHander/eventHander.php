<?php
/**
 * Plugin Name: WP Scheduled Tasks
 * Description: A WordPress plugin use to SCHEDULED TASK OF BADAM PROPERTIES .
 * Author: Rahman Rezaee
 * Author URI: http://badam.af
 * Version: 1.0
 * License: GPL2
 * Text Domain: wp-plugin-SCHEDULED
 * Domain Path: languages
 *
 * @package WP_Plugin_SCHEDULED
 */


if (!defined('ABSPATH')) {
    exit;
}

if (defined('WP_PLUGIN_SCHEDULED_VERSION')) {
    return;
}

define('WP_PLUGIN_SCHEDULED_VERSION', '1.0.0');
define('WP_PLUGIN_SCHEDULED_FILE', __FILE__);
define('WP_PLUGIN_SCHEDULED_PATH', plugin_dir_path(WP_PLUGIN_SCHEDULED_FILE));
define('WP_PLUGIN_SCHEDULED_URL', plugin_dir_url(WP_PLUGIN_SCHEDULED_FILE));

register_activation_hook(WP_PLUGIN_SCHEDULED_FILE, array('WP_Plugin_SCHEDULED', 'activate'));
register_deactivation_hook(WP_PLUGIN_SCHEDULED_FILE, array('WP_Plugin_SCHEDULED', 'deactivate'));

/**
 * Class WP_Plugin_SCHEDULED
 */
final class WP_Plugin_SCHEDULED
{

    /**
     * Plugin instance.
     *
     * @var WP_Plugin_SCHEDULED
     * @access private
     */
    private static $instance = null;

    /**
     * Get plugin instance.
     *
     * @return WP_Plugin_SCHEDULED
     * @static
     */
    public static function get_instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Constructor.
     *
     * @access private
     */
    private function __construct()
    {
        $this->doSchedule();

        add_action('plugins_loaded', array($this, 'init'));
    }

    /**
     * Load plugin function files here.
     */
    public function doSchedule()
    {

        wp_schedule_event(time(), 'daily', 'real_schedule_hook');
        add_action('real_schedule_hook', 'do_this_daily_to_real');


    }

    public function do_this_daily_to_real()
    {

        $args = array(
            'posts_per_page' => -1,
            'post_type' => "property"
        );
        $posts_array = get_posts($args);
        foreach ($posts_array as $post_array) {
            $before_value = get_post_meta($post_array->ID, "property_score", true);

            if ($before_value > 0) {

                update_post_meta($post_array->ID, 'property_score', --$before_value);

            } else {

                $my_post = array(
                    'ID'           => $post_array->ID,
                    'post_status'   => 'pending',
                );
                wp_update_post( $my_post );

            }

        }


    }

    /**
     * Code you want to run when all other plugins loaded.
     */
    public function init()
    {
        load_plugin_textdomain('wp-plugin-SCHEDULED', false, WP_PLUGIN_SCHEDULED_PATH . 'languages');
    }

    /**
     * Run when activate plugin.
     */
    public static function activate()
    {
    }

    /**
     * Run when deactivate plugin.
     */
    public static function deactivate()
    {

        wp_clear_scheduled_hook('real_estate_schedule_hook');

    }
}

function wp_plugin_SCHEDULED()
{
    return WP_Plugin_SCHEDULED::get_instance();
}

$GLOBALS['wp_plugin_SCHEDULED'] = wp_plugin_SCHEDULED();