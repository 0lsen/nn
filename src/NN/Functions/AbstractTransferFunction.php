<?php

namespace NN\Functions;


abstract class AbstractTransferFunction implements TransferFunction
{
	public static $flatSpotElimination = 0;

	public static function derivative($output)
	{
		return $output + self::$flatSpotElimination;
	}
}