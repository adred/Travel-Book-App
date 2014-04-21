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

    public $settings = null;

    function __construct() {
        // Auto-load classes on demand
        spl_autoload_register(array($this, 'autoload'));

        // Admin notices
        add_action('admin_notices', array($this, 'admin_notices'));

        add_action('init', array($this, 'init'));
        add_action('admin_init', array($this, 'admin_init'));
        add_action('admin_menu', array($this, 'admin_menu'));
        add_action('wp_footer', array($this, 'frontend_scripts'));

        add_shortcode('booking_form', array($this, 'booking_form'));
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
            $filename = dirname(__FILE__) . '/admin/classes/' . $class_name . '.php';

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
    public function init() {
        new TB_Ajax();
        include_once plugin_dir_path(__FILE__) . 'frontend/includes/functions.php';
    }
    
    /**
     * Initialize
     *
     * @access public
     * @return void
     */
    public function admin_init() {
        if (isset($_POST['tb_nonce']) && wp_verify_nonce($_POST['tb_nonce'], 'tb_settings_save')) {
            $this->settings = new TB_Settings($_POST);
            $this->settings->save();
        } 
    }

    /**
     * Load all the plugin scripts and styles for admin page
     */
    public function admin_scripts() {
        // Load global scripts
        wp_enqueue_script('jquery_ui', '//code.jquery.com/ui/1.10.4/jquery-ui.js');
        wp_enqueue_script('time_picker', plugins_url('admin/js/vendor/timepicker.js', __FILE__ ));
        wp_enqueue_script('tb_app_admin', plugins_url('admin/js/admin.js', __FILE__ ));

        wp_localize_script('tb_app_admin', 'TB_APP_Vars_Admin', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('tb_app_admin_nonce'),
        ));

        wp_enqueue_style('jquery_ui', '//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css');
        wp_enqueue_style('time_picker', plugins_url('admin/css/vendor/timepicker.css', __FILE__ ));
        wp_enqueue_style('tp_app_admin', plugins_url('admin/css/admin.css', __FILE__ ));
    }

    /**
     * Load all the plugin scripts and styles only for the frontend
     */
    public function frontend_scripts() {
        wp_enqueue_script('gm_api', 'http://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false');
        wp_enqueue_script('prettify', 'https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js');
        wp_enqueue_script('easydropdown', plugins_url('frontend/js/vendor/jquery.easydropdown.min.js', __FILE__ ));
        wp_enqueue_script('tb_app_frontend', plugins_url('frontend/js/frontend.js', __FILE__ ));

        wp_localize_script('tb_app_frontend', 'TB_APP_Vars_Frontend', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('tb_app_frontend_nonce'),
        ));

        wp_enqueue_style('open_sans', 'http://fonts.googleapis.com/css?family=Open+Sans');
        wp_enqueue_style('easydropdown_metro', plugins_url('frontend/css/vendor/easydropdown.metro.css', __FILE__ ));
        wp_enqueue_style('tp_app_frontend', plugins_url('frontend/css/frontend.css', __FILE__ ));

        ?>
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
            <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
        <![endif]-->
        <?php
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
        include_once plugin_dir_path(__FILE__) . 'admin/includes/functions.php';
        include_once plugin_dir_path(__FILE__) . 'admin/settings.php';
    }

    /**
     * Admin notices
     *
     * @return void
     */
    public function admin_notices() {
        if ($_POST['tb_app_settings_saved'] == true) {
            $errors = $this->settings->errors();
            if ($errors) { ?>
                <div class="error">
                    <p>Settings saved but with errors. Please correct the following:</p>
                    <?php echo $errors; ?>
                </div>
                <?php 
            }
            else { ?>
                <div class="updated">
                    <p>Settings saved...</p>
                </div>
                <?php 
            }
        }
    }

    /**
     * Booking form
     *
     * @return mixed
     */
    public function booking_form($atts) {
        ob_start(); 
        include_once plugin_dir_path(__FILE__) . 'frontend/booking_form.php';
        return ob_get_clean();
    }

}

$GLOBALS['tb_app'] = new TB_App();

} // class_exists check