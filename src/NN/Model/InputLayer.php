<?php

namespace NN\Model;


use NN\Builder\LayerConfiguration;

class InputLayer extends Layer
{
	public function __construct(LayerConfiguration $configuration){
		$this->hasBias = $configuration->hasBias;
	}

	public function calculate($input)
	{
		return $this->hasBias ? array_merge([1], $input) : $input;
	}
}