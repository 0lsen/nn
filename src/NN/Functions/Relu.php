<?php

namespace NN\Functions;


class Relu extends AbstractTransferFunction
{
	public static function apply($output)
	{
		return $output > 0 ? $output : 0;
	}

	public static function derivative($output)
	{
		return parent::derivative((int) $output > 0);
	}
}