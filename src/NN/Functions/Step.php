<?php

namespace NN\Functions;


class Step extends AbstractTransferFunction
{
	public static function apply($output)
	{
		return (int) $output > 0;
	}

	public static function derivative($output)
	{
		return parent::derivative(0);
	}
}