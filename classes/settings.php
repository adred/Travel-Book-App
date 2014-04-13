<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (!class_exists('TB_Settings')) {

class TB_Settings {

	private $optionsName = 'tb_app_options';
	private $data = array();
	private $fields = array(
		'sedan_min_fare' => '',
		'sedan_first_km' => '',
		'sedan_next_49' => '',
		'sedan_after_50' => '',
		'van_min_fare' => '',
		'van_first_km' => '',
		'van_next_49' => '',
		'van_after_50' => '',
		'peak_time' => '',
		'off_peak_time' => '',
		'night_time' => '',
		'start_date_1' => '',
		'end_date_1' => '',
		'surcharge_1' => '',
		'start_date_2' => '',
		'end_date_2' => '',
		'surcharge_2' => '',
		'start_date_3' => '',
		'end_date_3' => '',
		'surcharge_3' => '',
		'start_date_4' => '',
		'end_date_4' => '',
		'surcharge_4' => '',
		'start_date_5' => '',
		'end_date_5' => '',
		'surcharge_5' => '',
		'baby_seat' => '',
		'airport_pickup' => '',
		'admin_email' => '',
	);
	public $errors = array();

    public function __construct($data = array()) {
    	if ($data) {
    		$this->data = $data;
    	}
    }

    public static function field($field) {
    	$settings = new TB_Settings();
    	
    	if (!in_array($field, array_keys($settings->fields))) {
    		return 'Not a valid field';
    	}
    	else {
    		$options = $settings->get();
    		return $options[$field];
    	}
    }

    public function get() {
    	return unserialize(get_option($this->optionsName));
    }

    public function save() {
    	if (!$this->data) {
    		return;
    	}
    	if ($this->get()) {
    		$this->update();
    		return;
    	}
		foreach ($this->data as $field => $value) {
			if (!in_array($field, array_keys($this->fields))) {
				continue;
			}
			if (strpos($field, 'end_date') !== false) {
				if (!$this->isEndDateCorrect($field, $value)) {
					continue;
				}
			}
			if (strpos($field, 'start_date') !== false) {
				if (!$this->isStartDateCorrect($value)) {
					continue;
				}
			}
			$this->fields[$field] = $value;
		}
		update_option($this->optionsName, serialize($this->fields));
    }

    public function update() {
    	$options = $this->get();
    	foreach ($this->data as $field => $value) {
			if (!in_array($field, array_keys($this->fields)) || $value == $options[$field]) {
				continue;
			}
			if (strpos($field, 'end_date') !== false) {
				if (!$this->isEndDateCorrect($field, $value)) {
					continue;
				}
			}
			if (strpos($field, 'start_date') !== false) {
				if (!$this->isStartDateCorrect($value)) {
					continue;
				}
			}
			$options[$field] = $value;
		}
		update_option($this->optionsName, serialize($options));
    }

    public function isStartDateCorrect($value) {
    	if (strtotime($value) < strtotime('+2 hours')) {
    		$this->errors[] = 'Start date cannot be less than 2 hours from now.';
    		return false;
    	}

    	return true;
    }

    public function isEndDateCorrect($field, $value) {
    	$parts = explode('_', $field);

    	if (strtotime($value) < strtotime($this->data['start_date_' . $parts[2]])) {
    		$this->errors[] = 'End date cannot be before the start date.';
    		return false;
    	}

    	return true;
    }

    public function errors() {
    	if (!$this->errors) {
    		return false;
    	}

    	$errors = '<ul>';
        if ($this->errors) {
            foreach ($this->errors as $error) {
                $errors .= '<li>'. $error .'</li>';
            }
        }
        $errors .= '</ul>';

        return $errors;
    }

}

} // class_exists check