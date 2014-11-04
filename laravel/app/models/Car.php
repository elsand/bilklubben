<?php
/**
 * Car
 *
 * @property integer $id
 * @property integer $cartype_id
 * @property boolean $available
 * @property string $make
 * @property string $model
 * @property integer $year
 * @property string $location
 * @property integer $seats
 * @property integer $luggage_volume
 * @property string $image
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $override_weekday_price
 * @property integer $override_weekend_price
 * @property-read \Cartype $cartype
 * @property-read \Illuminate\Database\Eloquent\Collection|\Rental[] $rentals
 * @method static \Illuminate\Database\Query\Builder|\Car whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Car whereCartypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Car whereAvailable($value)
 * @method static \Illuminate\Database\Query\Builder|\Car whereMake($value)
 * @method static \Illuminate\Database\Query\Builder|\Car whereModel($value)
 * @method static \Illuminate\Database\Query\Builder|\Car whereYear($value)
 * @method static \Illuminate\Database\Query\Builder|\Car whereLocation($value)
 * @method static \Illuminate\Database\Query\Builder|\Car whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\Car whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Car whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Car whereOverrideWeekdayPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\Car whereOverrideWeekendPrice($value)
 * @method static \Car available()
 */

class Car extends \Eloquent {

	public function cartype() {
		return $this->belongsTo('Cartype');
	}

	public function rentals() {
		return $this->hasMany('Rental');
	}

	public function scopeAvailable($query) {
		return $query->where('available', '=', 1);
	}

	public function getWeekdayPrice() {
		if ($this->override_weekday_price)
			return $this->override_weekday_price;

		static $price_weekday;
		if (!$price_weekday)
			$price_weekday = $this->cartype()->select('price_weekday')->get()->first()->price_weekday;
		return $price_weekday;
	}

	public function getWeekendPrice() {
		if ($this->override_weekend_price)
			return $this->override_weekend_price;

		static $price_weekend;
		if (!$price_weekend)
			$price_weekend = $this->cartype()->select('price_weekend')->get()->first()->price_weekend;
		return $price_weekend;
	}

	/**
	 * Returns a map of all the dates with overridden prices as keys and
	 * the price as value. Takes into account weekday/weekend differences.
	 *
	 * @return array
	 */
	public function getOverridenPriceDates() {
		$dates = array();
		$weekend_price = $this->getWeekendPrice();
		$weekday_price = $this->getWeekdayPrice();
		foreach (Dateprice::getUpcoming() as $dateprice) {
			$dates[$dateprice->date] = Carbon::createFromFormat('Y-m-d', $dateprice->date)->isWeekend()
					? round($weekend_price + ($weekend_price * $dateprice->percentage / 100))
					: round($weekday_price + ($weekday_price * $dateprice->percentage / 100));
		}
		return $dates;
	}
}