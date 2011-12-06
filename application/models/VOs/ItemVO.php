<?php

/** 
 * @author ryanhollister
 * 
 * 
 */
class ItemVO {

	public $itemid;
	public $msrp;
	public $name;
	public $domain;
	public $manufacturer;
	public $modified;
	public $pictures;
	
	private $attr_map;
	
	
	function __construct($inputId = "", $inputMSRP = "", $inputName = "", $inputDomain = "", $inputManufacturer = "") {
		$this->name = $inputName;
		$this->itemid = $inputId;
		$this->msrp = $inputMSRP;
		$this->name = $inputName;
		$this->domain = $inputDomain;
		$this->manufacturer = $inputManufacturer;
		$this->modified = false;
		$this->pictures = array();
		$this->initialize_attributes();
	}
	
	/**
	 * @return the $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @return the $itemid
	 */
	public function getItemid() {
		return $this->itemid;
	}

	/**
	 * @return the $msrp
	 */
	public function getMsrp() {
		return $this->msrp;
	}

	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return the $domain
	 */
	public function getDomain() {
		return $this->domain;
	}

	/**
	 * @return the $manufacturer
	 */
	public function getManufacturer() {
		return $this->manufacturer;
	}
	
	public function getModified() {
		return $this->modified;
	}
	
	public function getPictures() {
		return $this->pictures;
	}
	
	public function getPictureURL($thumb = false, $size = "150") {
		
		if ($thumb)
		{
			$type = "thumbs";
		}
		else
		{
			$type = "full";
		}
		
		if (!isset($this->pictures[0]))
		{
			return "/img/".$this->domain."/".$type."/".$size."/nopic.jpg";
		}
		return "/img/".$this->domain."/".$type."/".$size."/".$this->pictures[0];
	}

	/**
	 * @return the $attr_map
	 */
	public function getAttr_map() {
		return $this->attr_map;
	}

	/**
	 * @param $attr_map the $attr_map to set
	 */
	public function setAttr_map($attr_map) {
		$this->attr_map = $attr_map;
	}

	
	/**
	 * @param $description the $description to set
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @param $itemid the $itemid to set
	 */
	public function setItemid($itemid) {
		$this->itemid = $itemid;
	}

	/**
	 * @param $msrp the $msrp to set
	 */
	public function setMsrp($msrp) {
		$this->msrp = $msrp;
	}

	/**
	 * @param $name the $name to set
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @param $domain the $domain to set
	 */
	public function setDomain($domain) {
		$this->domain = $domain;
	}

	/**
	 * @param $manufacturer the $manufacturer to set
	 */
	public function setManufacturer($manufacturer) {
		$this->manufacturer = $manufacturer;
	}
	
	public function setModified($modified)
	{
		$this->modified = $modified;
	}
	
	public function setPictures($pictures)
	{
		$this->pictures = $pictures;
	}
	
	public function addPicture($picture)
	{
		if($picture != "")
		{
			$this->pictures[] = $picture;
		}
	}
	
	public function initialize_attributes()
	{
		$CI =& get_instance();

		$CI->db->select('da.text, ia.value, da.domain_attribute_id');
		$CI->db->join('domain_attribute da', 'da.domain_attribute_id=ia.domain_attribute_id');
		$CI->db->where('ia.item_id', $this->itemid);
		$query = $CI->db->get('item_attribute ia');
		$attrStr = '';
		foreach ( $query->result() as $row )
		{
			$property_name = $this->attr_map[$row->domain_attribute_id];
			$this->$property_name = $row->value;
		}
	}
		
}

?>