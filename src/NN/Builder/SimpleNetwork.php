<?php

namespace NN\Builder;


use NN\Model\HiddenLayer;
use NN\Model\InputLayer;
use NN\Model\Layer;
use NN\Model\OutputLayer;

class SimpleNetwork {
	/** @var Layer[] */
	private $layers;

	public function __construct(LayerConfiguration $inputLayer, LayerConfiguration $outputLayer, $hiddenLayers)
	{
		$this->layers[] = new InputLayer($inputLayer);
		/** @var LayerConfiguration $layer */
		foreach ($hiddenLayers as $layer) {
			$this->layers[] = new HiddenLayer($layer);
		}
		$this->layers[] = new OutputLayer($outputLayer);
	}

	public function train($data, $rate)
	{
		/** @var TrainingData $input */
		foreach ($data as $index => $input) {
			$stuff = $input->input;
			foreach ($this->layers as $layer) {
				$stuff = $layer->calculate($stuff);
			}
			end($this->layers)->backpropagate($input->result, $rate);
			$weightChanges = end($this->layers)->getWeightChanges();
			for ($i = sizeof($this->layers)-2; $i > 0; $i--) {
				$this->layers[$i]->backpropagate($weightChanges, $rate);
				$weightChanges = $this->layers[$i]->getWeightChanges();
			}
		}
	}

	public function run($data)
	{
		foreach ($this->layers as $layer) {
			$data = $layer->calculate($data);
		}

		return $data;
	}

	public function extractWeights($indices) {
		$weights = [];
		$weights[] = $this->layers[1]->extractWeights($indices);
		for ($i = 2; $i < sizeof($this->layers); $i++) {
			$weights[] = $this->layers[$i]->extractWeights();
		}
		return $weights;
	}
}