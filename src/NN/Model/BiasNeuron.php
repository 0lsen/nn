<?php

namespace NN\Model;


class BiasNeuron extends Neuron {
	public function __construct() {
		parent::__construct();
	}

	public function output($input) {
		return 1;
	}
}