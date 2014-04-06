<?php

function tb_field($field) {
	$settings = new TB_Settings();
	echo $settings->field($field);
}

function tb_get_field($field) {
	$settings = new TB_Settings();
	return $settings->field($field);
}