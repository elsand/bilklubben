<?php

use Zizaco\Confide\UserValidator;
use Zizaco\Confide\ConfideUserInterface;

class BilklubbenUserValidator extends UserValidator

{

	/**
	 * Validation rules for this Validator.
	 *
	 * @var array
	 */
	public $rules = [
		'create' => [
			'first_name' => 'required|alpha_dash',
			'last_name' => 'required|alpha_dash',
			'email'    => 'required|email',
			'password' => 'required|min:4',
		],
		'update' => [
			'first_name' => 'required|alpha_dash',
			'last_name' => 'required|alpha_dash',
			'email'    => 'required|email',
			'password' => 'required|min:4',
		]
	];


	/**
	 * Validates if the given user is unique. If there is another
	 * user with the same credentials but a different id, this
	 * method will return false.
	 *
	 * @param ConfideUserInterface $user
	 *
	 * @return boolean True if user is unique.
	 */
	public function validateIsUnique(ConfideUserInterface $user)
	{
		$identity = [
			'email'    => $user->email
		];

		foreach ($identity as $attribute => $value) {

			$similar = $this->repo->getUserByIdentity([$attribute => $value]);

			if (!$similar || $similar->getKey() == $user->getKey()) {
				unset($identity[$attribute]);
			} else {
				$this->attachErrorMsg(
					$user,
					'confide::confide.alerts.duplicated_credentials',
					$attribute
				);
			}

		}

		if (!$identity) {
			return true;
		}

		return false;
	}
}
