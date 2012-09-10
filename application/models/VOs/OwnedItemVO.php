<?php

require_once ('application/models/VOs/ItemVO.php');

class OwnedItemVO extends ItemVO {
	
	private $owned_item_id;
	private $item_item_id;
	private $date_acquired;
	private $condition;
	private $qty;
	private $purchase_price;
	private $description;
	private $person_id;
	private $mp_visible;
	private $custImg;
	
	public function __construct($inputId = "", $inputMSRP = "", $inputName = "", $inputDomain = "", $inputManufacturer = "", $inputPurchasePrice = "", $inputOwnedItemId = "", $inputDesc = "") {
		parent::__construct ( $inputId, $inputMSRP, $inputName, $inputDomain, $inputManufacturer );
		$this->purchase_price = $inputPurchasePrice;
		$this->owned_item_id = $inputOwnedItemId;
		$this->description = $inputDesc;
	}
	
	/**
	 * @return the $owned_item_id
	 */
	public function getOwned_item_id() {
		return $this->owned_item_id;
	}
	
	/**
	 * @return the $item_item_id
	 */
	public function getItem_item_id() {
		return $this->item_item_id;
	}
	
	/**
	 * @return the $date_aquired
	 */
	public function getDate_acquired() {
		return $this->date_acquired;
	}
	
	/**
	 * @return the $condition
	 */
	public function getCondition() {
		return $this->condition;
	}
	
	/**
	 * @return the $qty
	 */
	public function getQty() {
		return $this->qty;
	}
	
	/**
	 * @return the $purchase_price
	 */
	public function getPurchase_price() {
		return $this->purchase_price;
	}
	
	/**
	 * @return the $description
	 */
	public function getDescription() {
		return $this->description;
	}
	
	/**
	 * @return the $person_id
	 */
	public function getPerson_id() {
		return $this->person_id;
	}
	
	/**
	 * @return the $mp_visible
	 */
	public function getMp_visible() {
		return $this->mp_visible;
	}
	
	/**
	 * @return the $custImg
	 */
	public function getCustImg() {
		return $this->custImg;
	}
	
	/**
	 * @param $owned_item_id the $owned_item_id to set
	 */
	public function setOwned_item_id($owned_item_id) {
		$this->owned_item_id = $owned_item_id;
	}
	
	/**
	 * @param $item_item_id the $item_item_id to set
	 */
	public function setItem_item_id($item_item_id) {
		$this->item_item_id = $item_item_id;
	}
	
	/**
	 * @param $date_aquired the $date_aquired to set
	 */
	public function setDate_acquired($date_acquired) {
		$this->date_acquired = $date_acquired;
	}
	
	/**
	 * @param $condition the $condition to set
	 */
	public function setCondition($condition) {
		$this->condition = $condition;
	}
	
	/**
	 * @param $qty the $qty to set
	 */
	public function setQty($qty) {
		$this->qty = $qty;
	}
	
	/**
	 * @param $purchase_price the $purchase_price to set
	 */
	public function setPurchase_price($purchase_price) {
		$purchase_price = money_format('%i', $purchase_price);
		$this->purchase_price = $purchase_price;
	}
	
	/**
	 * @param $description the $description to set
	 */
	public function setDescription($description) {
		$this->description = $description;
	}
	
	/**
	 * @param $person_id the $person_id to set
	 */
	public function setPerson_id($person_id) {
		$this->person_id = $person_id;
	}
	
	/**
	 * @param $mp_visible the $mp_visible to set
	 */
	public function setMp_visible($mp_visible) {
		$this->mp_visible = $mp_visible;
	}
	
	/**
	 * @param $custImg the $custImg to set
	 */
	public function setCustImg($custImg) {
		$CI =& get_instance();
		$this->custImg = $CI->security->sanitize_filename($custImg);
	}
	
	public function Save() {
		
		$CI =& get_instance();
		
		if ($this->owned_item_id != false)
		{
			//Update
			$data = array(
               'item_item_id' => $this->getItem_item_id(),
               'date_acquired' => $this->getDate_acquired(),
               'condition' => $this->getCondition(),
			   'qty' => $this->getQty(),
			   'purchase_price' => $this->getPurchase_price(),
			   'description' => $this->getPurchase_price(),
			   'person_id' => $this->getPerson_id(),
			   'mp_visible' => $this->getMp_visible(),
			   'custImg' => $this->getCustImg()
            );

			$CI->db->where('owned_item_id', $this->owned_item_id);
			$result = $CI->db->update('owned_item', $data );
			return $result;
		}	
		else
		{
			//Insert
			$data = array(
               'item_item_id' => $this->getItem_item_id(),
               'date_acquired' => $this->getDate_acquired(),
               'condition' => $this->getCondition(),
			   'qty' => $this->getQty(),
			   'purchase_price' => $this->getPurchase_price(),
			   'description' => $this->getPurchase_price(),
			   'person_id' => $this->getPerson_id(),
			   'mp_visible' => $this->getMp_visible(),
			   'custImg' => $this->getCustImg()
            );
            
			$retVal = $CI->db->insert('owned_item', $data);
			$this->owned_item_id = $CI->db->insert_id();
			return $retVal;
		}
	}
	
		public function getPictureURL($thumb = false, $size = "150", $force_stock = false) {
		
		$CI =& get_instance();
		$CI->load->model('domain_model');
		$domain = $CI->domain_model->getDomainFromId($this->domain);
		
		if ($thumb)
		{
			$type = "thumbs";
		}
		else
		{
			$type = "full";
		}
		
		if (!isset($this->pictures[0]) && ($this->getCustImg() == 'stock' || $force_stock))
		{
			return "/img/".$domain->getTag()."/".$type."/".$size."/nopic.jpg";
		}
		elseif($this->getCustImg() != 'stock' && !$force_stock)
		{
			return "/img/".$domain->getTag()."/".$type."/".$size."/customs/".$this->getCustImg();
		}
		return "/img/".$domain->getTag()."/".$type."/".$size."/".$this->pictures[0];
	}	

}

?>