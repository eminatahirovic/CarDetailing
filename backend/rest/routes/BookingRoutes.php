<?php

// GET all bookings
Flight::route('GET /bookings', function() {
  Flight::json(Flight::bookingService()->getAll());
});

// GET booking by ID
Flight::route('GET /bookings/@id', function($id) {
  Flight::json(Flight::bookingService()->getById($id));
});

// CREATE booking
  Flight::route('POST /bookings', function(){
   $data = Flight::request()->data->getData();
   Flight::json(Flight::bookingService()->add_booking($data));
});


// UPDATE booking (PUT)
Flight::route('PUT /bookings/@id', function($id) {
  $data = Flight::request() ->data->getData; 
  Flight::json(Flight::bookingService()->update($id, $data));
});

// PARTIAL UPDATE (PATCH)
Flight::route('PATCH /bookings/@id', function($id) {
  $data = Flight::request() -> data->getData(); 
  Flight::json(Flight::bookingService()->partial_update($id, $data));
});

// DELETE booking
Flight::route('DELETE /bookings/@id', function($id) {
  Flight::json(Flight::bookingService()->delete_booking($id));
});
