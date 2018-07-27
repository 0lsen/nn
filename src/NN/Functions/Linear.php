<?php

namespace NN\Functions;


class Linear extends AbstractTransferFunction
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