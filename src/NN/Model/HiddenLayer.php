<?php

namespace NN\Model;


use NN\Builder\LayerConfiguration;

class HiddenLayer extends Layer
{
	public function __construct(LayerConfiguration $configuration)
	{
		if ($configuration->hasBias) {
			$this->neurons[] = new BiasNeuron();
		}
		parent::__construct($configuration);
	}

	public function backpropagate($weightChanges, $rate)
	{
		foreach ($this->neurons as $index => $neuron) {
			if ($index) {
				$neuron->backpropagate($weightChanges[$index], $rate);
			}
		}
	}
}