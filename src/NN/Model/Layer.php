<?php

namespace NN\Model;


use NN\Builder\LayerConfiguration;

abstract class Layer {

	/** @var Neuron[] */
	protected $neurons;

	protected $numberOfWeights;

	public function __construct(LayerConfiguration $configuration)
	{
		$this->numberOfWeights = sizeof(is_array($configuration->weights[0]) ? $configuration->weights[0] : $configuration->weights);
		for ($i = 0; $i < $configuration->numberOfNeurons; $i++) {
			$weights = isset($configuration->weights[$i]) && is_array($configuration->weights[$i]) ? $configuration->weights[$i] : $configuration->weights;
			$this->neurons[] = new Neuron($configuration->transferFunction, $weights);
		}
	}

	public function calculate($input)
	{
		$output = [];

		foreach ($this->neurons as $neuron) {
			$output[] = $neuron->output($input);
		}

		return $output;
	}

	public function backpropagate($data, $rate){}

	public function getWeightChanges() {
		$weightChanges = [];
		for ($i = 0; $i < $this->numberOfWeights; $i++) {
			$sum = 0;
			foreach ($this->neurons as $neuron) {
				if (!($neuron instanceof BiasNeuron)) {
					$sum += $neuron->getWeightChange($i);
				}
			}
			$weightChanges[] = $sum;
		}
		return $weightChanges;
	}

	public function extractWeights($indices = null) {
		$weights = [];
		foreach ($this->neurons as $neuron) {
			if (!($neuron instanceof BiasNeuron)) {
				$weights[] = $neuron->extractWeights($indices);
			}
		}
		return $weights;
	}
}