<?php

namespace NN\Model;


class Logger {
	static public $iteration = 0;
	static public $run = 0;
	static public $error = [];

	static public function log($value)
	{
		self::$error[self::$iteration][self::$run][] = $value;
	}

	static public function average($iteration)
	{
		$sum = 0;
		foreach (self::$error[$iteration] as $run) {
			foreach ($run as $error) {
				$sum += $error;
			}
		}
		return $sum;
	}
}