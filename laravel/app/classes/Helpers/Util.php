<?php namespace Helpers;

class Util {
	static public function getCurrentRouteAsClassName() {
		$r = \Route::currentRouteAction();
		$r = str_replace('Controller', '', $r);
		$r = \snake_case($r);
		$r = strtr($r, '@_', '-');
		return $r;
	}

	static public function safe($str) {
		$replace = array(
			'ø' => 'oe',
			'æ' => 'ae',
			'å' => 'aa'
		);
		$str = strtolower($str);
		$str = str_replace(array_keys($replace), array_values($replace), $str);

		return $str;
	}

	/**
	 * Returns an array of Y-m-d formatted strings containing all the dates
	 * between from_date and to_date, inclusive
	 *
	 * @param $from_date
	 * @param $to_date
	 *
	 * @return array
	 */
	static public function getDateRange($from_date, $to_date) {
		$range = array();
		$from_date = \Carbon::createFromFormat('Y-m-d', $from_date);
		$to_date = \Carbon::createFromFormat('Y-m-d', $to_date);
		$range[] = $from_date->format('Y-m-d');
		$next_date = $from_date;
		while (($next_date = $next_date->addDay()) && $next_date->lte($to_date)) {
			$range[] = $next_date->format('Y-m-d');
		}
		return $range;
	}
}

 
 