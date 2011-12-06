<?php
include_once('item_model.php');
class Social_model extends CI_Model {
	
	/**
	 * Sends and email to a users friend inviting them to KLECT
	 */
	public function invite_a_friend()
	{
		$this->load->library('email');
		
		$config['mailtype'] = 'html';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = FALSE;
		
		$this->email->initialize($config);
		
		$from_name = $this->phpsession->get('personVO')->getFname();
		
		$emails = str_replace(" ", "", $this->input->post('friends_email'));
		$emails = explode(",", $emails);
		
		foreach ($emails as $key => $email)
		{
			if (!$this->email->valid_email($email)) unset($emails[$key]);
		}
		
		// if there were no valid emails
		if (count($emails) == 0) return true;
		
		$emails = array_slice($emails, 0, 20);
		
		$message = $this->input->post('message');
		
		$message = nl2br(str_replace('KLECT', '<a href="www.klect.com">KLECT</a>', $message));

		foreach($emails as $email)
		{
			$this->email->from('invite@klect.com', 'KLECT');
			$this->email->bcc('contact@klect.com');
			$this->email->to($email);
			
			$this->email->subject('Klect.com Invite From '.$this->phpsession->get('personVO')->getFname());
			$this->email->message($message, $this->phpsession->get('personVO')->getFname().' Says:');
			
			$this->email->send();
		
		}
		return true;
	}
}
?>