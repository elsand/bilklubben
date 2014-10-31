<?php
/**
 * Cartype
 *
 * @property integer $id
 * @property string $name
 * @property integer $price_weekday
 * @property integer $price_weekend
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Car[] $cars
 * @method static \Illuminate\Database\Query\Builder|\Cartype whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Cartype whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Cartype wherePriceWeekday($value)
 * @method static \Illuminate\Database\Query\Builder|\Cartype wherePriceWeekend($value)
 * @method static \Illuminate\Database\Query\Builder|\Cartype whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Cartype whereUpdatedAt($value)
 */

class Cartype extends \Eloquent {

	public function cars() {
		return $this->hasMany('Car');
	}
}