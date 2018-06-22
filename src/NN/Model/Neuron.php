<?php

namespace NN\Model;


use NN\Functions\TransferFunction;

class Neuron {
	/** @var TransferFunction */
	protected $transferFunction;

	protected $weights;

	protected $input;

	protected $output;

	protected $transfer;

	protected $delta;

	protected $weightsOld;

	public function __construct(&$transferFunction = null, $weigths = [])
	{
		$this->transferFunction = 'NN\Functions\\' . $transferFunction;
		$this->weights = $weigths;
	}

	public function output($input)
	{
		$this->input = $input;
		$this->output = 0;
		foreach ($input as $index => $value) {
			$this->output += $value * $this->weights[$index];
		}
		$this->transfer = $this->transferFunction::apply($this->output);
		return $this->transfer;
	}

	public function backpropagate($weightChanges, $rate) {
		$this->weightsOld = $this->weights;
		$this->delta = $this->transferFunction::derivative($this->output) * $weightChanges;
		foreach ($this->input as $index => $input) {
			$this->weights[$index] += $rate * $input * $this->delta;
		}
	}

	public function getWeightChange($index) {
		return $this->delta * $this->weightsOld[$index];
	}

	public function extractWeights($indices = null) {
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