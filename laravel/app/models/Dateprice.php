<?php
/**
 * Dateprice
 *
 * @property integer $id
 * @property string $date
 * @property integer $percentage
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Dateprice whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Dateprice whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Dateprice wherePercentage($value)
 * @method static \Illuminate\Database\Query\Builder|\Dateprice whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Dateprice whereUpdatedAt($value)
 */

class Dateprice extends \Eloquent {
	static public function getUpcoming() {
		static $upcoming;
		if (!$upcoming)
			$upcoming = parent::where('date', '>=', date('Y-m-d'))->get();
		return $upcoming;
	}
}