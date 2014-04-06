<?php
/*
Plugin Name: Travel Booking App
Description: Calculates distance between two places and its associated fee.
Author: Redeye Adaya
Version: 0.1
Copyright: 2013 Smart Money Solutions
License: GPL v3
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (!class_exists('TB_App')) {

class TB_App {

    function __construct() {
        // Auto-load classes on demand
        spl_autoload_register(array($this, 'autoload'));

        // Admin notices
        add_action('admin_notices', array($this, 'admin_notices'));

        add_action('admin_init', array($this, 'admin_init'));
        add_action('init', array($this, 'init'));
        add_action('admin_menu', array($this, 'admin_menu'));
        add_action('wp_footer', array($this, 'frontend_scripts'));
    }


    /**                 
     * Auto-load classe(s)
     *
     * @access public
     * @param mixed $class
     * @return void
     */
    public function autoload($class) {
        $name = explode( '_', $class );

        if (isset($name[1])) {
            $class_name = strtolower($name[1]);
            $filename = dirname(__FILE__) . '/classes/' . $class_name . '.php';

            if (file_exists($filename)) {
                require_once $filename;
            }
        }
    }
    
    /**
     * Initialize
     *
     * @access public
     * @return void
     */
    public function admin_init() {
        if (isset($_POST['tb_nonce']) && wp_verify_nonce($_POST['tb_nonce'], 'tb_settings_save')) {
            $settings = new TB_Settings($_POST);
            $settings->save();
        } 
    }

    /**
     * Initialize
     *
     * @access public
     * @return void
     */
    public function init() {
        new TB_Sedan();
        new TB_Van();
        new TB_Ajax();
    }

    /**
     * Load all the plugin scripts and styles for admin page
     */
    public function admin_scripts() {
        wp_enqueue_script('jquery_ui', '//code.jquery.com/ui/1.10.4/jquery-ui.js');
        wp_enqueue_script('tb_app_admin', plugins_url('admin/js/admin.js', __FILE__ ));

        wp_localize_script('tb_app_admin', 'TB_APP_Vars_Admin', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('tb_app_admin_nonce'),
        ));
        wp_enqueue_style('jquery_ui', '//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css');
        wp_enqueue_style('tp_app_admin', plugins_url('admin/css/admin.css', __FILE__ ));
    }

    /**
     * Load all the plugin scripts and styles only for the front-end
     */
    public function frontend_scripts() {
        wp_enqueue_script('google_maps_api', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false');
        wp_enqueue_script('tb_app_frontend', plugins_url('front-end/js/frontend.js', __FILE__ ));

        wp_localize_script('tb_app_frontend', 'TB_APP_Vars_Frontend', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('tb_app_frontend_nonce'),
        ));
        wp_enqueue_style('tp_app_frontend', plugins_url('front-end/css/frontend.css', __FILE__ ));
    }

    /**
     * Register the plugin menu
     */
    public function admin_menu() {
        $capability = 'manage_options'; //minimum level: manage_options
        $index_hook = add_menu_page(__('TB_App', 'tb_app'), __('TB App', 'tb_app'), $capability, 'tb_app', array($this, 'admin_page_handler'), '', 58);
        add_action($index_hook, array($this, 'admin_scripts'));
    }

    /**
     * Main function that renders the admin area
     * related markup.
     */
    public function admin_page_handler() {
        include_once plugin_dir_path(__FILE__) . 'includes/functions.php';
        include_once plugin_dir_path(__FILE__) . 'admin/settings.php';
    }

    /**
     * Admin notices
     *
     * @return void
     */
    public function admin_notices() {
        if ($_POST['tb_app_settings_saved'] == true) {
            ?>
            <div class="updated">
                <p>Settings saved...</p>
            </div>
            <?php 
        }
    }

}

$GLOBALS['tb_app'] = new TB_App();

} // class_exists check