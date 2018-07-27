<?php

namespace NN\Functions;


class Sigmoid extends AbstractTransferFunction
{
	public static $factor = 0.5;

	public static function apply($output)
	{
		return 1 / (1 + pow(M_E, -self::$factor * $output));
	}

	public static function derivative($output)
	{
		$asd = self::apply($output);
		return parent::derivative($asd * $asd * self::$factor * pow(M_E, -self::$factor * $output));
	}

}