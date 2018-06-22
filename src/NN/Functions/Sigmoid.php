<?php

namespace NN\Functions;


class Sigmoid implements TransferFunction
{
	public static $factor = 10;

	public static function apply($output)
	{
		return 1 / (1 + pow(M_E, -self::$factor * $output));
	}

	public static function derivative($output)
	{
		$asd = self::apply($output);
		return $asd * $asd * self::$factor * pow(M_E, -self::$factor * $output);
	}

}