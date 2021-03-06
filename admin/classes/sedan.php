<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (!class_exists('TB_Sedan')) {

class TB_Sedan extends TB_Calculator {

    public function calculate() {
        if (!$this->isPickupDateCorrect()) {
            return false;
        }

    	$firstKm = $this->options['sedan_first_km'];
    	$next49 = $this->distance > 1 ? ($this->distance - 1 > 49 ? 49 * $this->options['sedan_next_49'] : ($this->distance - 1) * $this->options['sedan_next_49']) : 0;
    	$after50 = max((($this->distance - 50) * $this->options['sedan_after_50']), 0);
        $pickupCharge = $this->addPickupCharge() ? $this->options['airport_pickup'] : 0;

    	$additionalCost = ($this->options['baby_seat'] * $this->babySeats) + $pickupCharge;
    	$finalFare = $firstKm + $next49 + $after50 + $additionalCost;

        $finalFare = $this->roundOff($finalFare);

    	if ($this->isSpecialDay()) {
    		$finalFare = $finalFare * (1 + $this->specialDaySurcharge / 100);
    	} 
        else {
            if ($this->isPeakTime()) {
                $finalFare = $finalFare * (1 + $this->peakTimeSurcharge / 100);
            }
            elseif ($this->isOffPeakTime()) {
                $finalFare = $finalFare - ($finalFare * ($this->offPeakTimeDiscount / 100));
            }
            elseif ($this->isNightTime()) {
                $finalFare = $finalFare * (1 + $this->nightTimeSurcharge / 100);
            }
        }

        $finalFare = $this->roundOff($finalFare);

        return max($finalFare,  $this->options['sedan_min_fare']);
    }
}

} // class_exists check