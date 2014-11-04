<?php
/**
 * Plan
 *
 * @property integer $id
 * @property string $name
 * @property integer $monthlycost
 * @property integer $points
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Subscription $subscriptions
 * @method static \Illuminate\Database\Query\Builder|\Plan whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Plan whereMonthlycost($value)
 * @method static \Illuminate\Database\Query\Builder|\Plan wherePoints($value)
 * @method static \Illuminate\Database\Query\Builder|\Plan whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Plan whereUpdatedAt($value)
 */
class Plan extends \Eloquent {

	public function subscriptions() {
		return $this->hasMany('Subscription');
	}
}