<?php

/**
 * Very simple implementation without error checking or even sender info ....
 *
 * Class TipafriendController
 */
class TipafriendController extends BaseController {

	public function send($car_id) {
		$car = Car::find($car_id);
		Mail::send('emails.tipafriend', array('car' => $car), function($message)
		{
		    $message->to(Input::get('email'))->subject('Du er blitt tipset!');
		});
		Session::flash('success', 'Tips er sendt til ' . Input::get('email') . '!');
		return Redirect::to('rentals/create/' . $car->id);
	}
}
 