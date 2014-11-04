<?php

/**
 * RentalsController Class
 *
 * Implements actions regarding rentals management
 */
class RentalsController extends BaseController
{
	public function index() {
		$cars = Car::all();
		return View::make('rentals.index', array('cars' => $cars));
	}

	public function select() {
		return Input::has('car_id') && ctype_digit(Input::get('car_id'))
			? Redirect::to('rentals/create/' . Input::get('car_id'))
			: Redirect::to('rentals/index');
	}

	public function create($car_id) {

		try {
			$car = Car::findOrFail($car_id);
		}
		catch (Exception $e) {
			App::abort(404);
		}

		return View::make('rentals.create', array('car' => $car));
	}

	public function store($car_id) {

		$from_date = Input::get('from_date');
		$to_date = Input::get('to_date');

		// FIXME! Server-side validation of dates

		/** @var Car $car */
		$car = null;
		try {
			$car = Car::findOrFail($car_id);
		}
		catch (Exception $e) {
			App::abort(404);
		}

		if (!Confide::user()) {
			Session::flash('error', 'Du er ikke innlogget. Vennligst <a href="' . url('/users/create') . '">registrer en konto</a>, eller logg inn før du leier en bil.');
			return Redirect::to('/rentals/create/' . $car->id)->withInput();
		}

		$total_price = $this->getTotalPriceForRental($car_id, $from_date, $to_date);
		/** @var User $user */
		$user = Confide::user();

		if ($total_price > $user->points) {
			Session::flash('error', 'Du har ikke nok poeng på konto for å utføre denne leien. Vennligst velg et kortere tidsrom, eller kjøp flere poeng.');
			return Redirect::to('/rentals/create/' . $car->id)->withInput();
		}

		$rental = new Rental();
		$rental->car_id = $car_id;
		$rental->user_id = $user->id;
		$rental->from_date = $from_date;
		$rental->to_date = $to_date;
		$rental->discount = $this->getDiscountPercentageForRental($from_date, $to_date);
		$rental->paid = $this->getTotalPriceForRental($car_id, $from_date, $to_date);
		$rental->save();

		$user->points -= $total_price;
		$user->save();


		Session::flash('success', sprintf('Leie av %s fra og med %s til og med %s er nå registrert, totalpris <span class="points">%d</span>',
			$car->make . " " . $car->model,
			Format::shortDate($from_date),
			Format::shortDate($to_date),
			$this->getTotalPriceForRental($car_id, $from_date, $to_date)
		));

		return Redirect::to('/rentals/create/' . $car->id)->withInput();
	}

	public function price($car_id) {
		$from_date = Input::get('from_date');
		$to_date = Input::get('to_date');
		return View::make('rentals.price', array(
			'totalprice' => $this->getTotalPriceForRental($car_id, $from_date, $to_date),
			'subtotalprice' => $this->getSubTotalPriceForRental($car_id, $from_date, $to_date),
			'discount' => $this->getDiscountForRental($car_id, $from_date, $to_date)
		));
	}

	private function getSubTotalPriceForRental($car_id, $from_date, $to_date) {
		/** @var Car $car */
		$car = Car::find($car_id);
		$range = Util::getDateRange($from_date, $to_date);

		$price = 0;
		$overridden_price_dates = $car->getOverridenPriceDates();
		foreach ($range as $date) {
			if (in_array($date, $overridden_price_dates)) {
				$price += $overridden_price_dates[$date];
			}
			else {
				$price += Carbon::createFromFormat('Y-m-d', $date)->isWeekend()
					? $car->getWeekendPrice()
					: $car->getWeekdayPrice();
			}
		}

		return $price;
	}

	private function getDiscountPercentageForRental($from_date, $to_date) {
		$discount = Discount::where("days_rental", "<=", count(Util::getDateRange($from_date, $to_date)))
			->select('discount')
			->orderBy('days_rental', 'desc')
			->take(1)
			->get()
			->first();
		return $discount ? $discount->discount : 0;
	}

	private function getTotalPriceForRental($car_id, $from_date, $to_date) {
		$full_price = $this->getSubTotalPriceForRental($car_id, $from_date, $to_date);
		return $full_price
			- (($full_price / 100) * $this->getDiscountPercentageForRental($from_date, $to_date));
	}

	private function getDiscountForRental($car_id, $from_date, $to_date) {
		return $this->getSubTotalPriceForRental($car_id, $from_date, $to_date)
			- $this->getTotalPriceForRental($car_id, $from_date, $to_date);
	}
}