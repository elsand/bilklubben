<?php namespace Helpers;

class Format {
	public static function shortDate($value) {
		$ts = strtotime($value);
		if (date('Y', $ts) == date('Y')) {
			return strftime('%e. %B', $ts);
		}
		else {
			return strftime('%e. %h %Y', $ts);
		}
	}
}