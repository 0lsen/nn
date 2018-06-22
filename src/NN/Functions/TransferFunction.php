<?php

namespace NN\Functions;


interface TransferFunction
{
	public static function apply($output);

	public static function derivative($output);
}