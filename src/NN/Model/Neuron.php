<?php

namespace NN\Model;


class Neuron {

	protected $layer;

	protected $weights;

	protected $output;

	protected $transfer;

	protected $delta;

	protected $weightsOld;

	public function __construct(Layer &$layer = null, $weigths = [])
	{
		$this->layer = $layer;
		$this->weights = $weigths;
	}

	public function output()
	{
		$this->output = 0;
		foreach ($this->layer->input as $index => $value) {
			$this->output += $value * $this->weights[$index];
		}
		$this->transfer = $this->layer->transferFunction::apply($this->output);
		return $this->transfer;
	}

	public function backpropagate($weightChanges, $rate)
	{
		$this->weightsOld = $this->weights;
		$this->delta = $this->layer->transferFunction::derivative($this->output) * $weightChanges;
		foreach ($this->layer->input as $index => $input) {
			$this->weights[$index] += $rate * $input * $this->delta;
		}
	}

	public function getWeightChange($index)
	{
		return $this->delta * $this->weightsOld[$index];
	}

	public function extractWeights($indices = null)
	{
		if (is_null($indices)) {
			return $this->weights;
		} else {
			$weights = [$this->weights[0]];
			foreach ($indices as $index) {
				$weights[] = $this->weights[$index+1];
			}
			return $weights;
		}
	}
}