<?php
require_once APPPATH.'models/VOs/ItemVO'.EXT;

class SaleVO
{	
	public $saleId;
	public $sellerId;
	public $buyerId;
	public $description;
	public $price;
	public $list_date;
	public $comp_date;
	public $owned_item_id;
	public $paypal;
	public $moneyorder;
	public $custImg;
	public $resolved = '0';
	public $shipped = '0';
	public $seller_rating = "0";
	public $buyer_rating = "";
	
	function __construct($inputSaleId = false) 
	{
		$this->saleId = $inputSaleId;
		
		if ($this->saleId != false)
		{
			$this->load();
		}
	}
	/**
	 * @return the $saleId
	 */
	public function getSaleId() {
		return $this->saleId;
	}

	/**
	 * @return the $sellerId
	 */
	public function getSellerId() {
		return $this->sellerId;
	}

	/**
	 * @return the $buyerId
	 */
	public function getBuyerId() {
		return $this->buyerId;
	}

	/**
	 * @return the $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @return the $price
	 */
	public function getPrice() {
		return $this->price;
	}

	/**
	 * @return the $list_date
	 */
	public function getList_date() {
		return $this->list_date;
	}

	/**
	 * @return the $comp_date
	 */
	public function getComp_date() {
		return $this->comp_date;
	}

	/**
	 * @return the $owned_item_id
	 */
	public function getOwned_item_id() {
		return $this->owned_item_id;
	}
	
	/**
	 * @return the $paypal
	 */
	public function getPaypal() {
		return $this->paypal;
	}

	/**
	 * @param $paypal the $paypal to set
	 */
	public function setPaypal($paypal) {
		$this->paypal = $paypal;
	}

	/**
	 * @return the $moneyorder
	 */
	public function getMoneyorder() {
		return $this->moneyorder;
	}

	/**
	 * @return the $customImg
	 */
	public function getCustomImg() {
		return $this->custImg;
	}
	
	/**
	 * @return the $resolved
	 */
	public function getResolved() {
		return $this->resolved;
	}

	/**
	 * @return the $shipped
	 */
	public function getShipped() {
		return $this->shipped;
	}
	
	/**
	 * @return the $buy_rating
	 */
	public function getBuyer_rating() {
		return $this->buyer_rating;
	}
	
	/**
	 * @return the $buy_rating
	 */
	public function getSeller_rating() {
		return $this->seller_rating;
	}

	/**
	 * @param $resolved the $resolved to set
	 */
	public function setResolved($resolved) {
		$this->resolved = $resolved;
	}

	/**
	 * @param $shipped the $shipped to set
	 */
	public function setShipped($shipped) {
		$this->shipped = $shipped;
	}

	/**
	 * @param $customImg the $customImg to set
	 */
	public function setCustomImg($customImg) {
		$CI =& get_instance();
		$this->custImg = $CI->security->sanitize_filename($customImg);
	}

	/**
	 * @param $moneyorder the $moneyorder to set
	 */
	public function setMoneyorder($moneyorder) {
		$this->moneyorder = $moneyorder;
	}

	/**
	 * @param $owned_item_id the $owned_item_id to set
	 */
	public function setOwned_item_id($owned_item_id) {
		$this->owned_item_id = $owned_item_id;
	}

	/**
	 * @param $comp_date the $comp_date to set
	 */
	public function setComp_date($comp_date) {
		$this->comp_date = $comp_date;
	}

	/**
	 * @param $saleId the $saleId to set
	 */
	public function setSaleId($saleId) {
		$this->saleId = $saleId;
	}

	/**
	 * @param $sellerId the $sellerId to set
	 */
	public function setSellerId($sellerId) {
		$this->sellerId = $sellerId;
	}

	/**
	 * @param $buyerId the $buyerId to set
	 */
	public function setBuyerId($buyerId) {
		$this->buyerId = $buyerId;
	}

	/**
	 * @param $description the $description to set
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @param $price the $price to set
	 */
	public function setPrice($price) {
		$this->price = $price;
	}

	/**
	 * @param $list_date the $list_date to set
	 */
	public function setList_date($list_date) {
		$this->list_date = $list_date;
	}
	
	/**
	 * @param $buyer_rating the $list_date to set
	 */
	public function setBuyer_rating($buyer_rating) {
		$this->buyer_rating = $buyer_rating;
	}
	
	/**
	 * @param $seller_rating the $list_date to set
	 */
	public function setSeller_rating($seller_rating) {
		$this->seller_rating = $seller_rating;
	}

	public function Load()
	{
		$CI =& get_instance();
		
		if ($this->saleId == false)
		{
			return false;
		}

		$CI->db->select('sellerId, buyerId, description, price, list_date, comp_date, owned_item_id, paypal, moneyorder, custImg, shipped, resolved, buyer_rating, seller_rating');
		$CI->db->where('saleId', $this->getSaleId());
		$query = $CI->db->get('sales');
		
		if($query->num_rows == 1)
		{
			$row = $query->result_array();
			$this->setSellerId($row[0]['sellerId']);
			$this->setBuyerId($row[0]['buyerId']);
			$this->setDescription($row[0]['description']);
			$this->setPrice($row[0]['price']);
			$this->setList_date($row[0]['list_date']);
			$this->setComp_date($row[0]['comp_date']);
			$this->setOwned_item_id($row[0]['owned_item_id']);
			$this->setPaypal($row[0]['paypal']);
			$this->setMoneyorder($row[0]['moneyorder']);
			$this->setCustomImg($row[0]['custImg']);
			$this->setShipped($row[0]['shipped']);
			$this->setResolved($row[0]['resolved']);
			$this->setBuyer_rating($row[0]['buyer_rating']);
			$this->setSeller_rating($row[0]['seller_rating']);
		}
	}
	
	public function Save() 
	{	
		$CI =& get_instance();
		if ($this->saleId != false)
		{
			//Update
			$CI->db->where('saleId', $this->saleId);
			return $CI->db->update('sales', $this );
		}	
		else
		{
			$CI->db->select('saleId');
			$CI->db->where('owned_item_id', $this->getOwned_item_id() );
			$CI->db->where('comp_date IS NULL');
			$query = $CI->db->get('sales');
			
			if($query->num_rows != 0)
			{
				return 0;
			}
			//Insert
			$retVal = $CI->db->insert('sales', $this);
			$this->saleId = $CI->db->insert_id();
			return $retVal;
		}
	}
}

?>