<?php

namespace NN\Functions;


class Step implements TransferFunction
{
	public static function apply($output)
	{
		return (int) $output > 0;
	}

	public static function derivative($output)
	{
		return 0;
	}
}