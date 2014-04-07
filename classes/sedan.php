<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (!class_exists('TB_Sedan')) {

class TB_Sedan extends TB_Calculator {

    public function calculate($distance, $pickupDate, $type, $babySeats) {
    	$this->pickupDate = $pickupDate;

    	$firstKm = $this->options['sedan_first_km'];
    	$next49 = $distance - 1 > 49 ? 49 * $this->options['sedan_next_49'] : ($distance - 1) * $this->options['sedan_next_49'];
    	$after50 = max((($distance - 50) * $this->options['sedan_after_50']), 0);

    	$additionalCost = ($this->options['baby_seat'] * $babySeats) + ($this->options['airport_pickup'] * $babySeats);
    	$fare = $firstKm + $next49 + $after50 + $additionalCost;
    	
    	if ($this->isSpecialDay()) {
    		$finalFare = ($fare * ($this->specialDaySurcharge / 100)) + $fare;
    	}
    	elseif ($this->isPeakTime()) {
    		$finalFare = ($fare * ($this->peakTimeSurcharge / 100)) + $fare;
    	}
    	elseif ($this->isOffPeakTime()) {
    		$finalFare = $fare - ($fare * ($this->offPeakTimeDiscount / 100));
    	}
    	elseif ($this->isNightTime()) {
    		$finalFare = ($fare * ($this->nightTimeSurcharge / 100)) + $fare;
    	}

    	return round($finalFare, 2);
    }
}

} // class_exists check