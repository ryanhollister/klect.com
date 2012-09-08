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
		
		foreach ($_POST as $attr_id => $attr_val)
		{
			$workingObj = new CommunityDataVO();
			// domain specific field?
			if ((strpos($attr_id, '_attr_') != false) && $attr_val != false)
			{
				$attr_val = addslashes($attr_val);
				$attr_id = str_replace('community_attr_', '', $attr_id);
			}
			else {
				
			}
		}
	}
	
}