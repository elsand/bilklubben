<?php
/**
 * User
 *
 * @property integer $id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $confirmation_code
 * @property string $remember_token
 * @property boolean $confirmed
 * @property integer $points
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Rental[] $rentals
 * @property-read \Illuminate\Database\Eloquent\Collection|\Subscription[] $subscriptions
 * @method static \Illuminate\Database\Query\Builder|\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereConfirmationCode($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereConfirmed($value)
 * @method static \Illuminate\Database\Query\Builder|\User wherePoints($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereUpdatedAt($value)
 */

use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\ConfideUserInterface;
 
class User extends Eloquent implements ConfideUserInterface { 
    use ConfideUser;

	public function rentals() {
		return $this->hasMany('Rental');
	}

	public function subscriptions() {
		return $this->hasMany('Subscription');
	}
}