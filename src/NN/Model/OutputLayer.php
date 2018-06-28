<?php

namespace NN\Model;


use NN\Builder\LayerConfiguration;

class OutputLayer extends Layer
{
	public function __construct(LayerConfiguration $configuration)
	{
		$this->transferFunction = 'NN\Functions\\' . $configuration->transferFunction;
		$this->numberOfWeights = sizeof(is_array($configuration->weights[0]) ? $configuration->weights[0] : $configuration->weights);
		for ($i = 0; $i < $configuration->numberOfNeurons; $i++) {
			$weights = isset($configuration->weights[$i]) && is_array($configuration->weights[$i]) ? $configuration->weights[$i] : $configuration->weights;
			$this->neurons[] = new OutputNeuron($this, $weights);
		}
	}

	public function backpropagate($teachingValues, $rate)
	{
		foreach ($this->neurons as $index => $neuron) {
			$neuron->backpropagate($teachingValues[$index], $rate);
		}
		Logger::$run++;
	}
}