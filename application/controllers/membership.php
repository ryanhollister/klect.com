<?php

class Membership extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('membership_model');
		$this->load->model('person_model');
	}
	
	function subscribe()
	{
		$result = $this->membership_model->createMembership();
		if ($result['success'] == TRUE)
		{
			$this->membership_model->persistMembership($result['subId']);
			$this->membership_model->logSubscription($result);
			echo TRUE;
		}
		else
		{
 			echo FALSE;
		}
	}
	
	function cancel()
	{
		$this->load->model('sale_model');
		$result = $this->membership_model->cancelMembership();
		$this->sale_model->delete_pending_sales();
		return $result['success'];
	}
}

?>