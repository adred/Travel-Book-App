<?php

function tb_get_dates() { 
	$numOfdays = date('t');
	ob_start(); ?>
	<select id="date-dropdown" class="dropdown" name="pickup_date_date">
		<option value="<?php echo date('m/d/Y'); ?>">Today</option> <?php 
		for ($i = 0; $i < $numOfdays; $i++) { 
			$value = date('m') . '/' . sprintf("%02s", $i + 1) . '/' . date('Y'); ?>
			<option value="<?php echo $value ?>"><?php echo $value ?></option> <?php
		} ?>
	</select> <?php
	return ob_get_clean();
}

function tb_get_hours() {
	ob_start(); ?>
	<select id="hour-dropdown" class="dropdown" name="pickup_date_hour">
		<option value="<?php echo date('H'); ?>"><?php echo date('H'); ?></option> <?php 
		for ($i = 0; $i < 12; $i++) { 
			$value = sprintf("%02s", $i + 1); ?>
			<option value="<?php echo $value ?>"><?php echo $value ?></option> <?php
		} ?>
	</select> <?php
	return ob_get_clean();
}

function tb_get_minutes() {
	ob_start(); ?>
	<select id="minute-dropdown" class="dropdown" name="pickup_date_min">
		<option value="00">00</option> <?php 
		for ($i = 0; $i < 60; $i++) { 
			if (($i + 1) % 5 != 0 || ($i + 1) == 60) {
				continue;
			}
			$value = sprintf("%02s", $i + 1); ?>
			<option value="<?php echo $value ?>"><?php echo $value ?></option> <?php
		} ?>
	</select> <?php
	return ob_get_clean();	
}