<?php

namespace NN\Model;


use NN\Builder\LayerConfiguration;

class InputLayer extends Layer
{
	public function __construct(LayerConfiguration $configuration){}

	public function calculate($input)
	{
		return array_merge([1], $input);
	}
}