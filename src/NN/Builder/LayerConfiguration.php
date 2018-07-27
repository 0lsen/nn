<?php

namespace NN\Builder;


class LayerConfiguration {

	public function __construct($numberOfNeurons, $transferFunction, $hasBias = false, $weights = null)
	{
		$this->numberOfNeurons = $numberOfNeurons;
		$this->transferFunction = $transferFunction;
		$this->hasBias = $hasBias;
		$this->weights = $weights;
	}

	public $numberOfNeurons;
	public $transferFunction;
	public $hasBias;
	public $weights;
}