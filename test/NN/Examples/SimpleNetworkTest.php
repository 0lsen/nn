<?php

use NN\Builder\Helper;
use NN\Builder\SimpleNetwork;
use NN\Builder\TrainingData;

class SimpleNetworkTest extends \PHPUnit\Framework\TestCase
{
	private $binaryValueThreshold = 0.5;

	private function classificationTestRun(SimpleNetwork $classification, $testData, $expectations, $transferFunction) {
		foreach ($testData as $index1 => $test) {
			$result = $classification->run($test);
			foreach ($result as $index2 => $value) {
				switch ($transferFunction) {
					case 'Linear':
						$this->assertTrue($expectations[$index1][$index2] ? $value > 0 : $value < 0);
						break;
					case 'Relu':
					case 'Sigmoid':
						$this->assertTrue($expectations[$index1][$index2] ? $value > $this->binaryValueThreshold : $value < $this->binaryValueThreshold);
				}
			}
		}
	}

	public function test2Classes_4_1_Linear()
	{
		/**
		 * Training data:
		 *
		 *           | AAAAAAAA
		 *           | AAAAAAAA
		 *           | AAAAAAAA
		 *           | AAAAAAAA
		 * ---------------------
		 *  BBBBBBBB |
		 *  BBBBBBBB |
		 *  BBBBBBBB |
		 *  BBBBBBBB |
		 */

		$network = Helper::buildSimpleNetwork(2, 1, 'Linear', [['neurons' => 4, 'transfer' => 'Linear']]);

		$trainingData = [];
		for ($i = 0; $i < 100; $i++) {
			$trainingData[] = new TrainingData([Helper::nd(), Helper::nd()], [1]);
			$trainingData[] = new TrainingData([-Helper::nd(), -Helper::nd()], [-1]);
		}

		$network->train($trainingData, 0.1);

		$distance = 0.5;
		$testData = [[$distance, $distance], [-$distance, -$distance]];
		$expectations = [[true],[false]];

		$this->classificationTestRun($network, $testData, $expectations, 'Linear');
	}

	public function test2Classes_4_2_Sigmoid()
	{
		/**
		 * Training data:
		 *
		 *  AAAAAAAA | BBBBBBBB
		 *  AAAAAAAA | BBBBBBBB
		 *  AAAAAAAA | BBBBBBBB
		 *  AAAAAAAA | BBBBBBBB
		 * ---------------------
		 *  BBBBBBBB | AAAAAAAA
		 *  BBBBBBBB | AAAAAAAA
		 *  BBBBBBBB | AAAAAAAA
		 *  BBBBBBBB | AAAAAAAA
		 */

		$network = Helper::buildSimpleNetwork(2, 2, 'Sigmoid', [['neurons' => 4, 'transfer' => 'Sigmoid']]);

		$trainingData = [];
		for ($i = 0; $i < 200; $i++) {
			$trainingData[] = new TrainingData([Helper::nd(), Helper::nd()], [1, 0]);
			$trainingData[] = new TrainingData([-Helper::nd(), -Helper::nd()], [1, 0]);
			$trainingData[] = new TrainingData([Helper::nd(), -Helper::nd()], [0, 1]);
			$trainingData[] = new TrainingData([-Helper::nd(), Helper::nd()], [0, 1]);
		}

		$network->train($trainingData, 0.1);

		$distance = 0.5;
		$testData = [[$distance, $distance], [-$distance, -$distance], [$distance, -$distance], [-$distance, $distance]];
		$expectations = [[true, false],[true, false], [false, true], [false, true]];

		$this->classificationTestRun($network, $testData, $expectations, 'Sigmoid');
	}

	public function test4Classes_4_2_Linear()
	{
		/**
		 * Training data:
		 *
		 *  AAAAAAAA | BBBBBBBB
		 *  AAAAAAAA | BBBBBBBB
		 *  AAAAAAAA | BBBBBBBB
		 *  AAAAAAAA | BBBBBBBB
		 * ---------------------
		 *  CCCCCCCC | DDDDDDDD
		 *  CCCCCCCC | DDDDDDDD
		 *  CCCCCCCC | DDDDDDDD
		 *  CCCCCCCC | DDDDDDDD
		 */

		$network = Helper::buildSimpleNetwork(2, 2, 'Linear', [['neurons' => 4, 'transfer' => 'Linear']]);

		$trainingData = [];
		for ($i = 0; $i < 100; $i++) {
			$trainingData[] = new TrainingData([Helper::nd(), Helper::nd()], [1, 1]);
			$trainingData[] = new TrainingData([Helper::nd(), -Helper::nd()], [1, -1]);
			$trainingData[] = new TrainingData([-Helper::nd(), Helper::nd()], [-1, 1]);
			$trainingData[] = new TrainingData([-Helper::nd(), -Helper::nd()], [-1, -1]);
		}

		$network->train($trainingData, 0.1);

		$distance = 0.5;
		$testData = [[$distance, $distance], [$distance, -$distance], [-$distance, $distance], [-$distance, -$distance]];
		$expectations = [[true, true],[true, false], [false, true], [false, false]];

		$this->classificationTestRun($network, $testData, $expectations, 'Linear');
	}

	public function test4Classes_8_4_ReLU()
	{
		/**
		 * Training data:
		 *
		 *  AAAAAAAA | BBBBBBBB
		 *  AAAAAAAA | BBBBBBBB
		 *  AAAAAAAA | BBBBBBBB
		 *  AAAAAAAA | BBBBBBBB
		 * ---------------------
		 *  CCCCCCCC | DDDDDDDD
		 *  CCCCCCCC | DDDDDDDD
		 *  CCCCCCCC | DDDDDDDD
		 *  CCCCCCCC | DDDDDDDD
		 */

		$network = Helper::buildSimpleNetwork(2, 4, 'Relu', [['neurons' => 8, 'transfer' => 'Relu']]);

		$trainingData = [];
		for ($i = 0; $i < 500; $i++) {
			$trainingData[] = new TrainingData([Helper::nd(), Helper::nd()], [1, 0, 0, 0]);
			$trainingData[] = new TrainingData([Helper::nd(), -Helper::nd()], [0, 1, 0, 0]);
			$trainingData[] = new TrainingData([-Helper::nd(), Helper::nd()], [0, 0, 1, 0]);
			$trainingData[] = new TrainingData([-Helper::nd(), -Helper::nd()], [0, 0, 0, 1]);
		}

		$network->train($trainingData, 0.1);

		$distance = 0.5;
		$testData = [[$distance, $distance], [$distance, -$distance], [-$distance, $distance], [-$distance, -$distance]];
		$expectations = [[true, false, false, false],[false, true, false, false], [false, false, true, false], [false, false, false, true]];

		$this->classificationTestRun($network, $testData, $expectations, 'Relu');
	}

	public function testWorldCup() {
		$outputFunction = "Linear";

		$trainingQualiIterations = 1;
		$trainingQualiLearnRate = 0.1;
		$trainingWcIterations = 2;
		$trainingWcLearnRate = 0.15;

		$hiddenConfig = [
			[
				"neurons" => 64,
				"transfer" => "Linear"
			],
//			[
//				"neurons" => 16,
//				"transfer" => "Linear"
//			],
		];

		$participantsWc = [
			"Ägypten",
			"Argentinien",
			"Australien",
			"Belgien",
			"Brasilien",
			"Costa Rica",
			"Dänemark",
			"Deutschland",
			"England",
			"Frankreich",
			"IR Iran",
			"Island",
			"Japan",
			"Kolumbien",
			"Kroatien",
			"Marokko",
			"Mexiko",
			"Nigeria",
			"Panama",
			"Peru",
			"Polen",
			"Portugal",
			"Russland",
			"Saudiarabien",
			"Schweden",
			"Schweiz",
			"Senegal",
			"Serbien",
			"Spanien",
			"Korea Republik",
			"Tunesien",
			"Uruguay"
		];

		$trainingQualiData = file_get_contents('qualification.txt');
		preg_match_all('/([A-Za-zäÄüÜöÖß\- ]+)\n\1{1}\n([A-Za-zäÄüÜöÖß\- ]+)\n\2{1}\n.*\n(\d)-(\d)/',$trainingQualiData, $matches);
		$resultsQuali = [];
		foreach ($matches[0] as $index => $match) {
			if (array_search($matches[1][$index], $participantsWc) || array_search($matches[2][$index], $participantsWc)) {
				$resultsQuali[] = [
					$matches[1][$index] => (int) $matches[3][$index],
					$matches[2][$index] => (int) $matches[4][$index]
				];
			}
		}

		$participants = array_values(array_unique($matches[1]));
		$participants[] = "Russland";

		$analyzer = Helper::buildSimpleNetwork(2*sizeof($participants), 2, $outputFunction, $hiddenConfig);

		$trainingData = $this->makeTrainingData($resultsQuali, $participants);

		for ($i = 0; $i < $trainingQualiIterations; $i++) {
			$analyzer->train($trainingData, $trainingQualiLearnRate);
			\NN\Model\Logger::$iteration++;
			\NN\Model\Logger::$run = 0;
		}

		$indices = [];
		for($i = sizeof($participants)-1; $i >= 0; $i--) {
			if (array_search($participants[$i], $participantsWc) === false) {
				array_splice($participants, $i, 1);
			} else {
				$indices[] = $i;
			}
		}

		if (sizeof($participants) != 32) {
			throw new Exception();
		}

		$weights = $analyzer->extractWeights(array_merge($indices, $indices));
		for ($i = 0; $i < sizeof($hiddenConfig); $i++) {
			$hiddenConfig[$i]['weights'] = $weights[$i];
		}
		$outputWeights = end($weights);

		$oracle = Helper::buildSimpleNetwork(2*sizeof($participants), 2, $outputFunction, $hiddenConfig, $outputWeights);

		$trainingWmData = json_decode(file_get_contents('wc.json'), true);

		$trainingData = $this->makeTrainingData($trainingWmData, $participants);

		for ($i = 0; $i < $trainingWcIterations; $i++) {
			$oracle->train($trainingData, $trainingWcLearnRate);
			\NN\Model\Logger::$iteration++;
			\NN\Model\Logger::$run = 0;
		}

		$result1 = $oracle->run($this->makeTestMatch("Frankreich", "Kroatien", $participants));
		$result2 = $oracle->run($this->makeTestMatch("Belgien", "England", $participants));
		$this->assertTrue(true);
	}

	private function makeTrainingData($results, $participants) {
		$trainingData = [];
		foreach ($results as $result) {
			$input = array_fill(0, 2*sizeof($participants), 0);
			$output = [0, 0];
			$keys = array_keys($result);
			$input[array_search($keys[0], $participants) + ($keys[0] > $keys[1] ? sizeof($participants) : 0)] = 1;
			$output[$keys[0] > $keys[1] ? 1 : 0] = $result[$keys[0]];
			$input[array_search($keys[1], $participants) + ($keys[0] > $keys[1] ? 0 : sizeof($participants))] = 1;
			$output[$keys[0] > $keys[1] ? 0 : 1] = $result[$keys[1]];
			$trainingData[] = new TrainingData($input, $output);
		}
		return $trainingData;
	}

	private function makeTestMatch($team1, $team2, $participants) {
		$teams = [$team1, $team2];
		$input = array_fill(0, 2*sizeof($participants), 0);
		$input[array_search($teams[0], $participants) + ($teams[0] > $teams[1] ? sizeof($participants) : 0)] = 1;
		$input[array_search($teams[1], $participants) + ($teams[0] > $teams[1] ? 0 : sizeof($participants))] = 1;
		return $input;
	}

	public function test_8_3_8_binaryMapping() {
		$hiddenConfig = [
			[
				"neurons" => 3,
				"transfer" => "Sigmoid"
			],
		];
		$nn = Helper::buildSimpleNetwork(8, 8, 'Linear', $hiddenConfig);

		$trainingData = [];
		for ($i = 0; $i < 100000; $i++) {
			$array = array_fill(0,8, 0);
			$array[rand(0,7)] = 1;
			$trainingData[] = new TrainingData($array, $array);
		}

		$nn->train($trainingData, 0.1);

		$result1 = $nn->run([1,0,0,0,0,0,0,0]);
		$result2 = $nn->run([0,1,0,0,0,0,0,0]);
		$result3 = $nn->run([0,0,1,0,0,0,0,0]);
		$result4 = $nn->run([0,0,0,1,0,0,0,0]);
		$result5 = $nn->run([0,0,0,0,1,0,0,0]);
		$result6 = $nn->run([0,0,0,0,0,1,0,0]);
		$result7 = $nn->run([0,0,0,0,0,0,1,0]);
		$result8 = $nn->run([0,0,0,0,0,0,0,1]);

		$this->assertEquals(0, array_keys($result1, max($result1))[0]);
		$this->assertEquals(1, array_keys($result2, max($result2))[0]);
		$this->assertEquals(2, array_keys($result3, max($result3))[0]);
		$this->assertEquals(3, array_keys($result4, max($result4))[0]);
		$this->assertEquals(4, array_keys($result5, max($result5))[0]);
		$this->assertEquals(5, array_keys($result6, max($result6))[0]);
		$this->assertEquals(6, array_keys($result7, max($result7))[0]);
		$this->assertEquals(7, array_keys($result8, max($result8))[0]);

		$this->assertTrue(true);
	}
}