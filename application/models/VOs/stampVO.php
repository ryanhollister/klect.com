<?php
require_once APPPATH.'models/VOs/OwnedItemVO'.EXT;
class stampVO extends OwnedItemVO
{
	public $scott_number;
	public $color;
	public $main_figure;
	public $issue;
	public $denomination;
	public $class;
	public $date;
	public $perf;
		
	function __construct($inputId = "", $inputMSRP = "", $inputName = "", $inputDomain = "", $inputManufacturer = "", $inputPurchasePrice = "", $inputOwnedItemId = "", $inputDesc = "", $inputGeneration = "", $inputPosition = "")
	{
		$this->setAttr_map (array (
								7 => 'scott_number',
								8 => 'color',
								9 => 'main_figure',
								10 => 'issue',
								11 => 'denomination',
								12 => 'class',
								13 => 'date',
								14 => 'perf'
							));
		parent::__construct($inputId, $inputMSRP, $inputName, $inputDomain, $inputManufacturer, $inputPurchasePrice, $inputOwnedItemId, $inputDesc);
	}
	
	/**
	 * @return the $scott_number
	 */
	public function getScott_number() {
		return $this->scott_number;
	}

	/**
	 * @return the $color
	 */
	public function getColor() {
		return $this->color;
	}

	/**
	 * @return the $main_figure
	 */
	public function getMain_figure() {
		return $this->main_figure;
	}

	/**
	 * @return the $issue
	 */
	public function getIssue() {
		return $this->issue;
	}

	/**
	 * @return the $denomination
	 */
	public function getDenomination() {
		return $this->denomination;
	}

	/**
	 * @return the $class
	 */
	public function getClass() {
		return $this->class;
	}

	/**
	 * @return the $date
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * @param $scott_number the $scott_number to set
	 */
	/**
	 * @return the $perf
	 */
	public function getPerf() {
		return $this->perf;
	}

	/**
	 * @param $perf the $perf to set
	 */
	public function setPerf($perf) {
		$this->perf = $perf;
	}

	public function setScott_number($scott_number) {
		$this->scott_number = $scott_number;
	}

	/**
	 * @param $color the $color to set
	 */
	public function setColor($color) {
		$this->color = $color;
	}

	/**
	 * @param $main_figure the $main_figure to set
	 */
	public function setMain_figure($main_figure) {
		$this->main_figure = $main_figure;
	}

	/**
	 * @param $issue the $issue to set
	 */
	public function setIssue($issue) {
		$this->issue = $issue;
	}

	/**
	 * @param $denomination the $denomination to set
	 */
	public function setDenomination($denomination) {
		$this->denomination = $denomination;
	}

	/**
	 * @param $class the $class to set
	 */
	public function setClass($class) {
		$this->class = $class;
	}

	/**
	 * @param $date the $date to set
	 */
	public function setDate($date) {
		$this->date = $date;
	}
	
	/**
	 * @return the $item_label
	 */
	public function getItem_label() {
		return $this->scott_number;
	}

}