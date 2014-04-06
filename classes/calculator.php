<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (!class_exists('TB_Calculator')) {

abstract class TB_Calculator {

	private $options = array();
	private $origin = '';
	private $destination = '';

    function __construct() {
    	$settings = new TB_Settings();
    	$this->options = $settings->get();
    }

    abstract function calculate($origin, $destination, $pickupDate, $type, $babySeats);
}

} // class_exists check