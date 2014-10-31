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

	public function getLowestPrice() {
		if ($this->override_weekday_price)
			return $this->override_weekday_price;

		return $this->cartype()->get()->first()->price_weekday;
	}
}