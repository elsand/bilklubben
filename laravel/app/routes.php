<?php

Route::get('/', function() {
	return View::make('pages.home');
});
Route::get('about', function() {
	return View::make('pages.about');
});

// Confide routes
Route::get('users/create', 'UsersController@create');
Route::post('users', 'UsersController@store');
Route::get('users/login', 'UsersController@login');
Route::post('users/login', 'UsersController@doLogin');
Route::get('users/confirm/{code}', 'UsersController@confirm');
Route::get('users/forgot_password', 'UsersController@forgotPassword');
Route::post('users/forgot_password', 'UsersController@doForgotPassword');
Route::get('users/reset_password/{token}', 'UsersController@resetPassword');
Route::post('users/reset_password', 'UsersController@doResetPassword');
Route::get('users/logout', 'UsersController@logout');
Route::get('users/mypage', 'UsersController@mypage');

Route::get('cars', 'CarsController@index');

Route::get('rentals', 'RentalsController@index');
Route::get('rentals/create/{car_id}', 'RentalsController@create');
Route::post('rentals/price/{car_id}', 'RentalsController@price');
Route::post('rentals/select', 'RentalsController@select');
Route::post('rentals/store/{car_id}', 'RentalsController@store');

Route::post('tipafriend/{car_id}', 'TipafriendController@send');

Route::get('subscriptions', 'SubscriptionsController@index');