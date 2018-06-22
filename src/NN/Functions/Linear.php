<?php

namespace NN\Functions;


class Linear implements TransferFunction
{
	public static function apply($output)
	{
		return $output;
	}

	public static function derivative($output)
	{
		return 1;
	}

}