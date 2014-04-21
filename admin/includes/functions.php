<?php

function tb_field($field) {
	echo TB_Settings::field($field);
}

function tb_get_field($field) {
	return TB_Settings::field($field);
}