<?php

namespace NN\Model;


class OutputNeuron extends Neuron
{
	public function backpropagate($teachingValue, $rate) {
		Logger::log(abs($teachingValue - $this->transfer));
		$this->weightsOld = $this->weights;
		$this->delta = $this->transferFunction::derivative($this->output) * ($teachingValue - $this->transfer);
		foreach ($this->input as $index => $input) {
			$this->weights[$index] += $rate * $input * $this->delta;
		}
	}
}