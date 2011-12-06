<?php

class Membership_model extends CI_Model 
{
	function persistMembership($subscription_id)
	{
		$this->phpsession->get('personVO')->setPremium(true);
		$this->phpsession->get('personVO')->setSubId($subscription_id);
		$this->phpsession->get('personVO')->Save();
	}
	
	function logSubscription($data)
	{
		$insertObj = new StdClass();
		$insertObj->last_4 = substr($data['cardNumber'], -4);
		$insertObj->first = $data['firstName'];
		$insertObj->last = $data['lastName'];
		$insertObj->addr1 = $this->input->post('bill_addr1');
		$insertObj->addr2 = $this->input->post('bill_addr2');
		$insertObj->city = $this->input->post('bill_city');
		$insertObj->state = $this->input->post('bill_state');
		$insertObj->zip = $this->input->post('bill_zip');
		$insertObj->country = $this->input->post('bill_country');
		$insertObj->person_id = $data['person_id'];
		$insertObj->method = $data['method'];
		$insertObj->amount = $data['amount'];
		$insertObj->response = $data['response'];
		$insertObj->subscription_id = $data['subId'];
		$insertObj->exp = $data["expirationDate"];
		$insertObj->date = date("Y-m-d H:i:s");
		$insertObj->type = $data["name"];
		
		$retVal = $this->db->insert('subscriptions', $insertObj);
	}
	
	function createMembership()
	{
		$person_id = $this->phpsession->get('personVO')->getPerson_id();
		$data['person_id'] = $person_id;
		$data['method'] = 'cc';
		
		if ($this->phpsession->get('personVO')->getSubId() == '0')
		{
			$testOccur = '0';
			$data["startDate"] = date("Y-m-d");
		}
		else
		{
			$testOccur = '1';
			$data["startDate"] = date("Y-m-d", strtotime('+1 month'));
		}
		
		switch($this->input->post('bill_subtype'))
		{
			case 'monthly':
				$data["amount"] = '6.00';
				$data["name"] = 'monthly';
				$data["length"] = '1';
				$data["unit"] = 'months';
				$data["totalOccurrences"] = '999';
				$data["trialOccurrences"] = $testOccur;
				$data["trialAmount"] = '0.00';
				$data["startDate"] = date("Y-m-d");
				break;
			case 'biannually':
				$data["amount"] = '24.00';
				$data["name"] = 'biannually';
				$data["length"] = '6';
				$data["unit"] = 'months';
				$data["totalOccurrences"] = '999';
				$data["trialOccurrences"] = '0';
				$data["trialAmount"] = '0.00';
				break;
			default:
				return 'There was an error processing, please contact KLECT.';
				break;
		}
		
		$cc_num = $this->input->post('bill_num');
		$data["expirationDate"] = $this->input->post('bill_yr').'-'.str_pad($this->input->post('bill_mo'), 2, '0', STR_PAD_LEFT);
	
		$data["refId"] = $person_id;
		$data["firstName"] =  $this->input->post('bill_fname');
		$data["lastName"] =  $this->input->post('bill_lname');
		$data["address"] = $this->input->post('bill_addr1');
		$data["city"] = $this->input->post('bill_city');
		$data["state"] = $this->input->post('bill_state');
		$data["zip"] = $this->input->post('bill_zip');
		$data["country"] = $this->input->post('bill_country');
		$data["cardNumber"] = $cc_num;
		$data["cvv"] = (int)$this->input->post('bill_cvv');

		$this->load->library('Billingsubscription');
		$succ = $this->billingsubscription->create_subscription($data);
		$data['success'] = $succ['success'];
		$data['response'] = $succ['response'];
		$data['subId'] = $succ['subscription_id'];
			
		return $data;
	}
	
	function cancelMembership()
	{
		$data["subscription_id"] = $this->phpsession->get('personVO')->getSubId();
		$this->load->library('Billingsubscription');
		$succ = $this->billingsubscription->cancel_subscription($data);
		
		if($succ)
		{
			$this->phpsession->get('personVO')->setSubId('0');
			$this->phpsession->get('personVO')->setPremium(false);
			
			$data = array('custImg' => 'stock');

			$this->db->where('person_id', $this->phpsession->get('personVO')->getPerson_id());
			$this->db->update('owned_item', $data);
			
			$this->phpsession->save('personVO', $this->phpsession->get('personVO'));
		
			echo $this->phpsession->get('personVO')->Save();
		}
		else
		{
			echo false;
		}
	}
}
?>