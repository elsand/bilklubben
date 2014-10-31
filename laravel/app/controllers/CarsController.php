<?php

/**
 * CarsController Class
 *
 * Implements actions regarding car management
 */
class CarsController extends Controller
{
	public function all() {
		$cars = Car::all();
		return View::make('cars.list', array('cars' => $cars));
	}
}