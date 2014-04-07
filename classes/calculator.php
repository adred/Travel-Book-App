<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (!class_exists('TB_Calculator')) {

abstract class TB_Calculator {

	private $options = array();
	private $time = '';
	private $peakTime = '';
	private $offPeakTime = '';
	private $nightTime = '';

    function __construct() {
    	$settings = new TB_Settings();
    	$this->options = $settings->get();
    	$this->time = startotime(date('m/d/Y'));
    }

    abstract function calculate($distance, $pickupDate, $type, $babySeats);

    protected function isSpecialDay() {
    	if ($this->time >=strtotime($this->options['start_date_1']) && $this->time <=strtotime($this->options['end_date_1'])) {
    		return true;
    	}
    	elseif ($this->time >=strtotime($this->options['start_date_2']) && $this->time <=strtotime($this->options['end_date_2'])) {
    		return true;
    	}
    	elseif ($this->time >=strtotime($this->options['start_date_3']) && $this->time <=strtotime($this->options['end_date_3'])) {
    		return true;
    	}
    	elseif ($this->time >=strtotime($this->options['start_date_4']) && $this->time <=strtotime($this->options['end_date_4'])) {
    		return true;
    	}
    	elseif ($this->time >=strtotime($this->options['start_date_5']) && $this->time <=strtotime($this->options['end_date_5'])) {
    		return true;
    	}
    }

    protected function isPeakTime() {
    	if ($this->time >= strtotime(date('m/d/Y') . ' 04:00:00 AM') && $this->time <= strtotime(date('m/d/Y') . ' 10:00:00 AM')) {
    		return true;
    	}
    	else {
    		return false;
    	}
    }

    protected function isOffPeakTime() {
    	if ($this->time >= strtotime(date('m/d/Y') . ' 11:00:00 AM') && $this->time <= strtotime(date('m/d/Y') . ' 02:59:00 PM')) {
    		return true;
    	}
    	else {
    		return false;
    	}
    }

    protected function isNightTime() {
    	if ($this->time >= strtotime(date('m/d/Y') . ' 11:00:00 PM') && $this->time <= strtotime(date('m/d/Y') . ' 03:59:00 AM')) {
    		return true;
    	}
    	else {
    		return false;
    	}
    }
}

} // class_exists check