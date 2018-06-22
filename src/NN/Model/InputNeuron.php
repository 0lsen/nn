<?php

namespace NN\Model;


class InputNeuron extends Neuron
{
	public function __construct()
	{
		$this->weights = [1];
		$this->transferFunction = 'NN\Functions\Linear';
	}
}