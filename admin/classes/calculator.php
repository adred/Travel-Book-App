<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (!class_exists('TB_Calculator')) {

abstract class TB_Calculator {

    private $origin = '';
    private $distance = '';
    private $pickupDate = '';
    private $airportType = '';
    private $vehicleType = '';
    private $babySeats = '';
    private $specialDaySurcharge = '';
    private $peakTimeSurcharge = '';
    private $offPeakTimeDiscount = '';
    private $nightTimeSurcharge = '';

    private $options = array();
    private $errors = array();
    private $airportsWithCharge = array();

    function __construct() {
        $settings = new TB_Settings();
        $this->options = $settings->get();
        $this->airportsWithCharge = array('Melbourne Airport', 'Tullamarine Airport');
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

        return false;
    }

    protected function isPeakTime() {
        $parts = explode(' ', $this->pickupDate);
        if ((strtotime($this->pickupDate) >= strtotime($parts[0] . ' 04:00:00 AM') && strtotime($this->pickupDate) <= strtotime($parts[0] . ' 10:00:00 AM'))
        || (strtotime($this->pickupDate) >= strtotime($parts[0] . ' 03:00:00 PM') && strtotime($this->pickupDate) <= strtotime($parts[0] . ' 10:00:00 PM'))) {
            $this->peakTimeSurcharge = $this->options['peak_time'];
            return true;
        }
        
        return false;
    }

    protected function isOffPeakTime() {
        $parts = explode(' ', $this->pickupDate);
        if (strtotime($this->pickupDate) >= strtotime($parts[0] . ' 11:00:00 AM') && strtotime($this->pickupDate) <= strtotime($parts[0] . ' 02:59:00 PM')) {
            $this->offPeakTimeDiscount = $this->options['off_peak_time'];
            return true;
        }
        
        return false;
    }

    protected function isNightTime() {
        $parts = explode(' ', $this->pickupDate);
        if ((strtotime($this->pickupDate) >= strtotime('-1 day', strtotime($parts[0] . ' 10:00:00 PM')) && strtotime($this->pickupDate) <= strtotime($parts[0] . ' 03:59:00 AM'))
            || (strtotime($this->pickupDate) >= strtotime($parts[0] . ' 10:00:00 PM') && strtotime($this->pickupDate) <= strtotime('+1 day', strtotime($parts[0] . ' 10:00:00 PM')))) {
            $this->nightTimeSurcharge = $this->options['night_time'];
            return true;
        }
        
        return false;
    }

    protected function addPickupCharge() {
        foreach ($this->airportsWithCharge as $airport) {
            if (strpos(ucfirst($this->origin), $airport) !== false && strtolower($this->airportType) == 'international') {
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

        $dec = $this->findDivisibleByFive(intval($parts[1]));
        if ($dec == 100) {
            return (intval($parts[0]) + 1) . '.00';
        }
        return $parts[0] . '.' . $dec;
    }

    protected function findDivisibleByFive($val) {
        if (++$val % 5 == 0) {
            return $val;
        }

        return $this->findDivisibleByFive($val);
    }

    public function isPickupDateCorrect() {
        // if (strrpos($this->pickupDate, 'PM') !== false) {
        //     $plus = '+14 hours';
        // }
        // else if (strrpos(trim($this->pickupDate), '12:00:00AM') !== false || strrpos(trim($this->pickupDate), '12:00AM')) {
        //     $plus = '+1 day 2 hours';
        // }
        // elseif (strrpos($this->pickupDate, 'AM') !== false) {
        //     $plus = '+2 hours';
        // } 

        // if (strtotime($this->pickupDate) < strtotime(date('h:i:s A', strtotime($plus)))) {
        //     $this->errors[] = 'Pickup date cannot be less than 2 hours from now.';
        //     return false;
        // }

        return true;
    }
}

} // class_exists check