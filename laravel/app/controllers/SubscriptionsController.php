<?php

/**
 * SubscriptionsController Class
 *
 * Implements actions regarding subscription management
 */
class SubscriptionsController extends BaseController
{
	public function index() {
		if (!Confide::user()) {
			Session::flash('error', 'Du er ikke innlogget. Vennligst <a href="' . url('/users/create') . '">registrer en konto</a>, eller logg inn før du tegner abonnement.');
			return Redirect::to('/users/create/');
		}
		return View::make("subscriptions.index", array('plans' => Plan::all()));
	}
}