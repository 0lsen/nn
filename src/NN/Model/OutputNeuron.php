<?php

namespace NN\Model;


class OutputNeuron extends Neuron
{
	public function backpropagate($teachingValue, $rate)
	{
		Logger::log(abs($teachingValue - $this->transfer));
		$this->weightsOld = $this->weights;
		$this->delta = $this->layer->transferFunction::derivative($this->output) * ($teachingValue - $this->transfer);
		foreach ($this->layer->input as $index => $input) {
			$this->weights[$index] += $rate * $input * $this->delta;
		}
	}
}