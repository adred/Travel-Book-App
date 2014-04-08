<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (!class_exists('TB_Ajax')) {

class TB_Ajax {

    public function __construct() {
        add_action('wp_ajax_nopriv_tb_calculate', array($this, 'calculate'));
        add_action('wp_ajax_tb_calculate', array($this, 'calculate'));
    }

    public function calculate() {
        check_ajax_referer('tb_app_frontend_nonce');

        if ($_POST['vehicleType'] == 'sedan') {
            $vehicle = new TB_Sedan();
        }
        elseif ($_POST['vehicleType'] == 'van') {
            $vehicle = new TB_Van();
        }

        $res = $vehicle->calculate($_POST['distance'], $_POST['pickupDate'], $_POST['vehicleType'], $_POST['babySeats']);

        // if (!$res) {
        //      echo json_encode(array(
        //         'error' => true,
        //         'message' => 'calculate() failed...'
        //     ));
        //     exit;
        // }

        echo json_encode(array(
            'error' => false,
            'quote' => $res
        ));
        exit;
    }

}

} // class_exists check