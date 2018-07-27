<?php

namespace NN\Functions;


class TanHyp extends AbstractTransferFunction
{
	public static function apply($output)
	{
		return 1 - 2/(self::e2x($output) + 1);
	}

	public static function derivative($output)
	{
		$e2x = self::e2x($output);
		return parent::derivative(4*$e2x/(($e2x+1)*($e2x+1)));
	}

	private static function e2x($x) {
		return pow(M_E, 2*$x);
	}

}