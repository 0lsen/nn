<?php

namespace NN\Builder;


class LayerConfiguration {

	public function __construct($numberOfNeurons, $transferFunction, $weights = null)
	{
		$this->numberOfNeurons = $numberOfNeurons;
		$this->transferFunction = $transferFunction;
		$this->weights = $weights;
	}

	public $numberOfNeurons;
	public $transferFunction;
	public $weights;
}