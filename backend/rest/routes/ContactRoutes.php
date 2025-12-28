<?php

Flight::route('POST /contact', function() {
    $data = Flight::request()->data->getData();
    if (!is_array($data) || empty($data)) {
        $data = json_decode(Flight::request()->getBody(), true);
    }
    if (!is_array($data)) {
        validation_error('Invalid request payload');
        return;
    }

    $name = sanitize_string($data['name'] ?? '');
    $phone = sanitize_string($data['phone'] ?? '');
    $email = sanitize_string($data['email'] ?? '');
    $service = sanitize_string($data['service'] ?? '');
    $message = sanitize_string($data['message'] ?? '');

    $fields = [];
    if ($name === '') $fields['name'] = 'Full name is required.';
    if ($phone === '') {
        $fields['phone'] = 'Phone is required.';
    } elseif (!is_valid_phone($phone)) {
        $fields['phone'] = 'Invalid phone number.';
    }
    if ($email === '') {
        $fields['email'] = 'Email is required.';
    } elseif (!is_valid_email($email)) {
        $fields['email'] = 'Invalid email address.';
    }
    if ($service === '') $fields['service'] = 'Service is required.';
    if ($message === '') $fields['message'] = 'Message is required.';

    if (!empty($fields)) {
        validation_error('Please correct the highlighted fields.', $fields);
        return;
    }

    Flight::json([
        'success' => true,
        'message' => 'Contact request received'
    ], 200);
});