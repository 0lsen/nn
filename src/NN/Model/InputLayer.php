<?php

namespace NN\Model;


use NN\Builder\LayerConfiguration;

class InputLayer extends Layer
{
	public function __construct(LayerConfiguration $configuration)
	{
		$this->neurons[] = new BiasNeuron();
		for ($i = 0; $i < $configuration->numberOfNeurons; $i++) {
			$this->neurons[] = new InputNeuron();
		}
	}

	public function calculate($input)
	{
		$output = [];

		foreach ($this->neurons as $index => $neuron) {
			$output[] = $neuron->output($index ? [$input[$index-1]] : null);
		}

		return $output;
	}
}