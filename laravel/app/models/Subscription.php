<?php
/**
 * Subscription
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $plan_id
 * @property boolean $active
 * @property string $start_date
 * @property string $stop_date
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \User $user
 * @property-read \Plan $plan
 * @method static \Illuminate\Database\Query\Builder|\Subscription whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Subscription whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Subscription wherePlanId($value)
 * @method static \Illuminate\Database\Query\Builder|\Subscription whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\Subscription whereStartDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Subscription whereStopDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Subscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Subscription whereUpdatedAt($value)
 */

class Subscription extends \Eloquent {

	public function user() {
		return $this->belongsTo('User');
	}

	public function plan() {
		return $this->belongsTo('Plan');
	}
}