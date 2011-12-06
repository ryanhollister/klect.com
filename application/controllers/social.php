<?php

class Social extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Allows users to send invite messages to friends
	 * 
	 */
	
	function invite_a_friend()
	{
		is_logged_in();
		$this->load->model('social_model');
		echo json_encode(array("success"=> $this->social_model->invite_a_friend()));
	}	
}
?>