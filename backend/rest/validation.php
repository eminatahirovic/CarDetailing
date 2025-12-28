<?php

function validation_error($message, $fields = []) {
    Flight::json([
        "error" => "VALIDATION_ERROR",
        "message" => $message,
        "fields" => $fields
    ], 400);
}

function sanitize_string($value) {
    if (!is_string($value)) return $value;
    return trim($value);
}

function is_valid_email($email) {
    return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
}

function is_valid_password($password) {
    if (!is_string($password)) return false;
    return (bool)preg_match('/^(?=.*[A-Za-z])(?=.*\d).{8,}$/', $password);
}

function is_valid_phone($phone) {
    if (!is_string($phone)) return false;
    $phone = preg_replace('/\s+/', '', $phone);
    if (!preg_match('/^\+?\d+$/', $phone)) return false;
    $digits = preg_replace('/\D+/', '', $phone);
    return strlen($digits) >= 8;
}

function is_valid_int($value) {
    return filter_var($value, FILTER_VALIDATE_INT) !== false;
}

function is_valid_datetime($value) {
    if (!is_string($value) || $value === "") return false;
    $formats = [
        'Y-m-d H:i:s',
        'Y-m-d H:i',
        'Y-m-d\TH:i',
        'Y-m-d'
    ];
    foreach ($formats as $format) {
        $dt = DateTime::createFromFormat($format, $value);
        if ($dt && $dt->format($format) === $value) {
            return true;
        }
    }
    return strtotime($value) !== false;
}
