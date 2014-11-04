<?php
/**
 * Rental
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $car_id
 * @property string $from_date
 * @property string $to_date
 * @property integer $discount
 * @property integer $paid
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Car $car
 * @property-read \User $user
 * @method static \Illuminate\Database\Query\Builder|\Rental whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Rental whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Rental whereCarId($value)
 * @method static \Illuminate\Database\Query\Builder|\Rental whereFromDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Rental whereToDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Rental whereDiscount($value)
 * @method static \Illuminate\Database\Query\Builder|\Rental whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Rental whereUpdatedAt($value)
 * @method static \Rental active()
 */

class Rental extends \Eloquent {

	public function car() {
		return $this->belongsTo('Car');
	}

	public function user() {
		return $this->belongsTo('User');
	}

	public function scopeActive($query) {
		$today = \Carbon\Carbon::today();
		return $query->where('from_date', '<=', $today)
		             ->where('to_date', '>=', $today);
	}


	public function getDateRange() {
		return Util::getDateRange($this->from_date, $this->to_date);
	}
}