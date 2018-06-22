<?php

namespace NN\Functions;


class Relu implements TransferFunction
{
	public static function apply($output)
	{
		return $output > 0 ? $output : 0;
	}

	public static function derivative($output)
	{
		return (int) $output > 0;
	}
}