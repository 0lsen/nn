<?php

namespace NN\Builder;


class TrainingData
{
	public $input;
	public $result;

	public function __construct($input, $result)
	{
		$this->input = $input;
		$this->result = $result;
	}
}