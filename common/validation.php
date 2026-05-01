<?php

// check if name only contains letters and whitespace
function only_alphabet($data)
{
	if (!preg_match('/^[a-zA-Z ]*$/', $data)) {
		return FALSE;
	} else {
		return $data;
	}
}

function validate_data($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function filterEmail($field)
{
	// Sanitize e-mail address
	$field = filter_var(trim($field), FILTER_SANITIZE_EMAIL);

	// Validate e-mail address
	if (filter_var($field, FILTER_VALIDATE_EMAIL)) {
		return $field;
	} else {
		return FALSE;
	}
}
function filterString($field)
{
	// Sanitize string
	$field = filter_var($field, FILTER_SANITIZE_STRING);
	$field = trim($field);
	$field = stripslashes($field);
	$field = htmlspecialchars($field);

	if (!empty($field)) {
		return $field;
	} else {
		return FALSE;
	}
}
function filterMobileNumber($field)
{

	// Validate mobile number length
	if (strlen($field) != 10) {
		return false;
	}

	// Validate mobile number using filter_var()
	if (preg_match('/^[6-9]\d{9}$/', $field)) {
		return $field;
	} else {
		return false;
	}

	
}

function only_digits($data)
{
	if (!preg_match('/^[0-9]*$/', $data)) {
		return false;
	} else {
		return $data;
	}
}