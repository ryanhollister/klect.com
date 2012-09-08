<?php

class Community extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('item_model');
		$this->load->model('domain_model');
		$this->load->model('person_model');
		$this->load->model('community_model');
		require_once APPPATH . 'models/VOs/CommunityDataVO' . EXT;
	}
	
	function process_submission(){
		
		$new_item = false;
		
		foreach ($_POST as $attr_id => $attr_val)
		{
			$workingObj = new CommunityDataVO();
			$workingObj->setCreateDate(time());
			$workingObj->setSubmittedBy($this->phpsession->get ( 'personVO' )->getPerson_id());
			// domain specific field?
			if ((strpos($attr_id, 'community_attr_') !== false) && $attr_val != false)
			{
				$attr_val = addslashes($attr_val);
				$attr_id = str_replace('community_attr_', '', $attr_id);
				
				$workingObj->setDomainAttrInd(1);
				$workingObj->setValue($attr_val);
				$workingObj->setItemAttributeId($attr_id);
			}
			elseif((strpos($attr_id, 'community_') !== false) && $attr_val != false) {
				$attr_val = addslashes($attr_val);
				$attr_name = str_replace('community_', '', $attr_id);
				
				$workingObj->setDomainAttrInd(0);
				$workingObj->setValue($attr_val);
				$workingObj->setCoreAttrName($attr_name);
			}
			else {
				continue;
			}
			
			if (!$new_item) {
				require_once APPPATH . 'models/VOs/' . $this->phpsession->get ( 'current_domain' )->getTag () . 'VO' . EXT;
				$currVOname = $this->phpsession->get ( 'current_domain' )->getTag () . 'VO';
				$new_item = new $currVOname();
				$new_item->setDomain($this->phpsession->get ( 'current_domain' )->getId());
				$new_item->SaveItem();
			} 
			
			$workingObj->setItemId($new_item->getItemid());
			$workingObj->Save();
		}
	}
	
}