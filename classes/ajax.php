<?php

class TB_Ajax {

    public function __construct() {
        add_action('wp_ajax_nopriv_tb_calculate', array($this, 'calculate'));
        add_action('wp_ajax_tb_calculate', array($this, 'calculate'));
    }

    public function calculate() {
        check_ajax_referer('tb_nonce');

        if ($_POST['type'] == 'sedan') {
            $vehicle = new TB_Sedan();
        }
        elseif ($_POST['type'] == 'van') {
            $vehicle = new TB_Van();
        }

        $res = $vehicle->calculate($distance, $pickupDate, $type, $babySeats);

        if (!$res) {
             echo json_encode(array(
                'error' => true,
                'quote' => 'calculate() failed...'
            ));
            exit;
        }

        echo json_encode(array(
            'error' => false,
            'quote' => '' // call to 
        ));
        exit;
    }

}