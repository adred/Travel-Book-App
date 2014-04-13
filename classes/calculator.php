<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (!class_exists('TB_Calculator')) {

abstract class TB_Calculator {

    private $distance = '';
    private $pickupDate = '';
    private $airport = '';
    private $airportType = '';
    private $vehicleType = '';
    private $babySeats = '';
	private $specialDaySurcharge = '';
	private $peakTimeSurcharge = '';
	private $offPeakTimeDiscount = '';
	private $nightTimeSurcharge = '';

    private $options = array();
    private $airportsWithCharge = array();

    function __construct() {
    	$settings = new TB_Settings();
    	$this->options = $settings->get();
        $this->airportsWithCharge = array('Melbourne', 'Tullamarine');
    }

    abstract function calculate();

    public function __set($var, $val) {
       if (property_exists($this, $var)) {
            $this->$var = $val;
       }
    }

    public function __get($var) {
       if (property_exists($this, $var)) {
            return $this->$var;
       }
    }

    protected function isSpecialDay() {
    	if (strtotime($this->pickupDate) >= strtotime($this->options['start_date_1']) && strtotime($this->pickupDate) <= strtotime($this->options['end_date_1'])) {
    		$this->specialDaySurcharge = $this->options['surcharge_1'];
    		return true;
    	}
    	elseif (strtotime($this->pickupDate) >= strtotime($this->options['start_date_2']) && strtotime($this->pickupDate) <= strtotime($this->options['end_date_2'])) {
    		$this->specialDaySurcharge = $this->options['surcharge_2'];
    		return true;
    	}
    	elseif (strtotime($this->pickupDate) >= strtotime($this->options['start_date_3']) && strtotime($this->pickupDate) <= strtotime($this->options['end_date_3'])) {
    		$this->specialDaySurcharge = $this->options['surcharge_3'];
    		return true;
    	}
    	elseif (strtotime($this->pickupDate) >= strtotime($this->options['start_date_4']) && strtotime($this->pickupDate) <= strtotime($this->options['end_date_4'])) {
    		$this->specialDaySurcharge = $this->options['surcharge_4'];
    		return true;
    	}
    	elseif (strtotime($this->pickupDate) >= strtotime($this->options['start_date_5']) && strtotime($this->pickupDate) <= strtotime($this->options['end_date_5'])) {
    		$this->specialDaySurcharge = $this->options['surcharge_5'];
    		return true;
    	}
    }

    protected function isPeakTime() {
    	if (strtotime($this->pickupDate) >= strtotime(date('m/d/Y') . ' 04:00:00 AM') && strtotime($this->pickupDate) <= strtotime(date('m/d/Y') . ' 10:00:00 AM')) {
    		$this->peakTimeSurcharge = $this->options['peak_time'];
    		return true;
    	}
    	else {
    		return false;
    	}
    }

    protected function isOffPeakTime() {
    	if (strtotime($this->pickupDate) >= strtotime(date('m/d/Y') . ' 11:00:00 AM') && strtotime($this->pickupDate) <= strtotime(date('m/d/Y') . ' 02:59:00 PM')) {
    		$this->offPeakTimeDiscount = $this->options['off_peak_time'];
    		return true;
    	}
    	else {
    		return false;
    	}
    }

    protected function isNightTime() {
    	if (strtotime($this->pickupDate) >= strtotime(date('m/d/Y') . ' 11:00:00 PM') && strtotime($this->pickupDate) <= strtotime(date('m/d/Y') . ' 03:59:00 AM')) {
    		$this->nightTimeSurcharge = $this->options['night_time'];
    		return true;
    	}
    	else {
    		return false;
    	}
    }

    protected function addPickupCharge() {
        foreach ($this->airportsWithCharge as $airport) {
            if (strpos($this->airport, $airport) !== false && strtolower($this->airportType) == 'international') {
                return true;
            }
        }

        return false;
    }

    protected function roundOff($val) {
        $val = number_format(round($val, 2), 2);
        $parts = explode('.', $val);

        if (intval($parts[1]) % 5 == 0) {
            return $val;
        } 
        else {
            return $parts[0] . '.' . $this->findDivisibleByFive(intval($parts[1]));
        }
    }

    protected function findDivisibleByFive($val) {
        if (++$val % 5 == 0) {
            return $val;
        }
        else {
            return $this->findDivisibleByFive($val);
        }
    }
}

} // class_exists check