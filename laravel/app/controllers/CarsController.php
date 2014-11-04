<?php

/**
 * CarsController Class
 *
 * Implements actions regarding car management
 */
class CarsController extends BaseController
{
	public function index() {
		$cars = Car::all();
		return View::make('cars.index', array('cars' => $cars));
	}
}