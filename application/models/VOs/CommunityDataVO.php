<?php

class CommunityDataVO
{
	private $id;
	private $item_attribute_id;
	private $value;
	private $domain_attr_ind;
	private $core_attr_name;
	private $create_date;
	private $submitted_by;
	
	function __construct($inputId = false)
	{
		$this->setId($inputId);
	}
	
	public function getId() { return $this->id; }
	public function getItemAttributeId() { return $this->item_attribute_id; }
	public function getValue() { return $this->value; }
	public function getDomainAttrInd() { return $this->domain_attr_ind; }
	public function getCoreAttrName() { return $this->core_attr_name; }
	public function getCreateDate() { return $this->create_date; }
	public function getSubmittedBy() { return $this->submitted_by; }
	public function setId($x) { $this->id = $x; }
	public function setItemAttributeId($x) { $this->item_attribute_id = $x; }
	public function setValue($x) { $this->value = $x; }
	public function setDomainAttrInd($x) { $this->domain_attr_ind = $x; }
	public function setCoreAttrName($x) { $this->core_attr_name = $x; }
	public function setCreateDate($x) { $this->create_date = $x; }
	public function setSubmittedBy($x) { $this->submitted_buy = $x; }
	
	public function Load()
	{
		$CI =& get_instance();
	
		if ($this->id == false)
		{
			return false;
		}
	
		$CI->db->select('id, item_attribute_id, value, domain_attr_ind, core_attr_name, create_date, submitted_by');
		$CI->db->where('id', $this->getId());
		$query = $CI->db->get('community_data');
	
		if($query->num_rows == 1)
		{
			$row = $query->result_array();
			$this->setCoreAttrName($row[0]['core_attr_name']);
			$this->setCreateDate($row[0]['create_date']);
			$this->setDomainAttrInd($row[0]['domain_attr_ind']);
			$this->setId($row[0]['id']);
			$this->setItemAttributeId($row[0]['item_attribute_id']);
			$this->setValue($row[0]['value']);
			$this->setSubmittedBy($row[0]['submitted_by']);
		}
	}
	
	public function Save() {
	
		$CI =& get_instance();
		
		//Update
		$data = array(
				'item_attribute_id' => $this->getItemAttributeId(),
				'value' => $this->getValue(),
				'domain_attr_id' => $this->getDomainAttrInd(),
				'core_attr_name' => $this->getCoreAttrName(),
				'create_date' => $this->getCreateDate(),
				'submitted_by' => $this->getSubmittedBy()
		);
	
		if ($this->id != false)
		{
			$data['id'] = $this->id;
			$CI->db->where('community_data', $this->id);
			$result = $CI->db->update('community_data', $data );
			return $result;
		}
		else
		{
			$retVal = $CI->db->insert('community_data', $data);
			$this->id = $CI->db->insert_id();
			return $retVal;
		}
	}
	
	
}
