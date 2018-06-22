<?php

namespace NN\Builder;


class Helper
{
	/**
	 * normal distribution approximate
	 * @return float
	 */
	public static function nd() {
		$sum = 0;
		for ($i = 0; $i < 6; $i++) {$sum += rand(0,100)/100;}
		return $sum/6;
	}

	/**
	 * noise based on a simple normal distribution approximate
	 * @return float
	 */
	public static function noise() {
		return self::nd()-0.5;
	}

	public static function buildSimpleNetwork($inDim, $outDim, $outTransfer, $hiddenLayers = [], $outWeights = null) {
		$inputConfig = new LayerConfiguration($inDim, null, null);
		$hiddenConfig = [];
		foreach ($hiddenLayers as $index => $layer) {
			$numberOfInputs = $index == 0 ? $inDim : $hiddenLayers[$index-1]['neurons'];
			$weights = $layer['weights'] ?? self::createWeights($numberOfInputs+1);
			$hiddenConfig[] = new LayerConfiguration($layer['neurons'], $layer['transfer'], $weights);
		}
		$outputConfig = new LayerConfiguration($outDim, $outTransfer, is_null($outWeights) ? self::createWeights(sizeof($hiddenLayers) ? end($hiddenLayers)['neurons']+1 : $inDim+1) : $outWeights);

		return new SimpleNetwork($inputConfig, $outputConfig, $hiddenConfig);
	}

	private static function createWeights($numberOfInputs) {
		$weights = [];
		for ($i = 0; $i < $numberOfInputs; $i++) {
			$weights[] = self::noise();
		}
		return $weights;
	}
}