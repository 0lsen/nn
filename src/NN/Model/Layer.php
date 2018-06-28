<?php

namespace NN\Model;


use NN\Builder\LayerConfiguration;
use NN\Functions\TransferFunction;

abstract class Layer {

	/** @var Neuron[] */
	protected $neurons;

	/** @var TransferFunction */
	public $transferFunction;

	public $input;

	protected $numberOfWeights;

	public function __construct(LayerConfiguration $configuration)
	{
		$this->transferFunction = 'NN\Functions\\' . $configuration->transferFunction;
		$this->numberOfWeights = sizeof(is_array($configuration->weights[0]) ? $configuration->weights[0] : $configuration->weights);
		for ($i = 0; $i < $configuration->numberOfNeurons; $i++) {
			$weights = isset($configuration->weights[$i]) && is_array($configuration->weights[$i]) ? $configuration->weights[$i] : $configuration->weights;
			$this->neurons[] = new Neuron($this, $weights);
		}
	}

	public function calculate($input)
	{
		$this->input = $input;
		$output = [];

		foreach ($this->neurons as $neuron) {
			$output[] = $neuron->output();
		}

		return $output;
	}

	public function backpropagate($data, $rate){}

	public function getWeightChanges()
	{
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

	public function extractWeights($indices = null)
	{
		$weights = [];
		foreach ($this->neurons as $neuron) {
			if (!($neuron instanceof BiasNeuron)) {
				$weights[] = $neuron->extractWeights($indices);
			}
		}
		return $weights;
	}
}