<?php
require_once APPPATH.'models/VOs/OwnedItemVO'.EXT;
class MLPVO extends OwnedItemVO
{
	public $generation;
	public $date;
	public $class;
	public $body_color;
	public $hair_color;
	public $style;
	public $symbol;
	
	function __construct($inputId = false, $inputMSRP = "", $inputName = "", $inputDomain = "", $inputManufacturer = "", $inputPurchasePrice = "", $inputOwnedItemId = "", $inputDesc = "", $inputGeneration = "", $inputPosition = "")
	{
		$this->setAttr_map (array (
								0 => 'generation',
								1 => 'date',
								2 => 'class',
								3 => 'body_color',
								4 => 'hair_color',
								5 => 'style',
								6 => 'symbol'
							));
		parent::__construct($inputId, $inputMSRP, $inputName, $inputDomain, $inputManufacturer, $inputPurchasePrice, $inputOwnedItemId, $inputDesc);
		$this->setGeneration($inputGeneration);
	}
	
	function getGeneration()
	{
		return $this->generation;
	}
	
	/**
	 * @return the $date
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * @param $date the $date to set
	 */
	public function setDate($date) {
		$this->date = $date;
	}

	function setGeneration($value)
	{
		$this->generation = $value;
	} 
	
	/**
	 * @return the $item_label
	 */
	public function getItem_label() {
		return $this->name;
	}
}