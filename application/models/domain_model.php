<?php

class Domain_model extends CI_Model {
	
	/**
	 * Returns a VO of the requested domain
	 * 
	 * @param string $domain_tag - ex: 'mlp' or 'stamps'
	 */
	function getDomain($domain_tag)
	{
		require_once APPPATH.'models/VOs/DomainVO'.EXT;
		$domainVO = new DomainVO(constant($domain_tag."_DOMAIN_ID"), constant($domain_tag."_NAME"));
		$domainVO->setTag($domain_tag);
		$this->loadAttributes($domainVO);		
		return $domainVO;		
	}

	
	function getDomainFromId($domain_id)
	{
		$domains = array();
		$this->db->select('domain_id, description, tag');
		$this->db->where('domain_id', $domain_id);
		$query = $this->db->get('domain d');

		require_once APPPATH.'models/VOs/DomainVO'.EXT;

		$row = $query->row(); 
		
		$domainVO = new DomainVO(constant($row->tag."_DOMAIN_ID"), constant($row->tag."_NAME"));
		$domainVO->setTag($row->tag);
		$this->loadAttributes($domainVO);
		
		return $domainVO;		
	}
	
	/**
	 * Returns an array of value options. Key is the level and the value is the label.
	 * 
	 * @param int $domain_id - domain_id from the domain table
	 */
	function getValueOptions($domain_id)
	{
		$retVal = array();
		
		$this->db->select('level, label');
		$this->db->where('domain_id', $domain_id);
		$this->db->order_by('level');
		$query = $this->db->get('value_label');

		foreach ($query->result() as $row)
		{
			 $retVal[$row->level] = $row->label;
		}
		return $retVal;
	}
	
	/**
	 * Loads the Attribute property with the attributes associated with the current domain.
	 * 
	 * @param $domainVO
	 */
	private function loadAttributes($domainVO)
	{
		if ($domainVO->getId() == false)
		{
			throw new Exception('Cannot load attributes without first setting domain Id.');
		}
		
		$this->db->select('domain_attribute_id, text');
		$this->db->where('domain_id', $domainVO->getId());
		$this->db->order_by('order ASC');
		$query = $this->db->get('domain_attribute');

		foreach ($query->result() as $row)
		{
			$domainVO->addAttribute($row->domain_attribute_id, $row->text); 	
		}
		
		return $domainVO;
	}
	
	public function getNewCollections()
	{
		$domains = array();
		$person_id = $this->phpsession->get('personVO')->getPerson_id();
		$this->db->select('domain_id, description');
		$this->db->where('domain_id NOT IN (SELECT domain_id FROM collection c WHERE person_id='.$person_id.')');
		$this->db->order_by('description');
		$query = $this->db->get('domain d');

		foreach ($query->result() as $row)
		{
			$domains[$row->domain_id] = $row->description; 	
		}
		
		return $domains;
	}
	
	public function getAllCollections()
	{
		$domains = array();
		$this->db->select('domain_id, description');
		$this->db->order_by('description', 'desc');
		$query = $this->db->get('domain d');

		foreach ($query->result() as $row)
		{
			$domains[$row->domain_id] = $row->description; 	
		}
		
		return $domains;
	}
	
	public function add_collection($domain_id, $person_id = false)
	{
		$person_id = $person_id ? $person_id : $this->phpsession->get('personVO')->getPerson_id();	
		$new_collection_insert = array(			
				'domain_id' => $domain_id,
				'person_id' => $person_id				
			);	
		$insert = $this->db->insert('collection', $new_collection_insert);
		echo true;
	}
	
	public function getUsersCollections()
	{
		$domains = array();
		$person_id = $this->phpsession->get('personVO')->getPerson_id();
		$this->db->select('domain_id, description, tag');
		$this->db->where('domain_id IN (SELECT domain_id FROM collection c WHERE person_id='.$person_id.')');
		$this->db->order_by('description');
		$query = $this->db->get('domain d');

		require_once APPPATH.'models/VOs/DomainVO'.EXT;
		
		foreach ($query->result() as $row)
		{
			$domainVO = new DomainVO(constant($row->tag."_DOMAIN_ID"), constant($row->tag."_NAME"));
			$domainVO->setTag($row->tag);
			$this->loadAttributes($domainVO);
			$domains[$row->domain_id] = $domainVO; 	
		}
		
		return $domains;
	}
	
	public function change_collection($collection_id)
	{
		$new_domain = $this->getDomainFromId($collection_id);
		$this->phpsession->save('current_domain', $new_domain);
		return true;
	}
	
	public function getDomainAttrinbutes()
	{
		$attributes = array();
		$this->db->select('text');
		$this->db->where('domain_id', $this->phpsession->get('current_domain')->getId());		
		$this->db->order_by('order');
		$query = $this->db->get('domain_attribute da');
		
		foreach ($query->result() as $row)
		{
			$attributes[] = $row->text; 	
		}
		
		return $attributes;
	}
}