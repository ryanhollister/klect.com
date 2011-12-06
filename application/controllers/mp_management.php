<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mp_management extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();
		$this->load->model('item_model');
		$this->domain_name = $this->phpsession->get('current_domain')->getName();
		is_logged_in();
	}
	
	function submit_sale()
	{
		$this->load->model('sale_model');
		$count = count($this->sale_model->get_persons_sales_id(true));
		if ($count < 20)
		{
			$this->sale_model->submit_sale();
		}
		else
		{
			echo "over";
		}
	}
	
	function submit_buy()
	{
		$this->load->model('buy_model');
		echo $this->buy_model->close_sale();
	}
	
	function get_sale_info()
	{
		$this->load->model('sale_model');
		$this->load->model('person_model');
		$sale_info = $this->sale_model->get_sale_info();
		$member_rating['member_rating'] = $this->person_model->get_member_rating($sale_info->sellerId);
		unset($sale_info->sellerId);
		$sale_info->member_rating = $this->load->view('modules/member_rating',$member_rating,true);
		echo json_encode($sale_info);
	}
	
	function get_pending_sale_info()
	{
		$this->load->model('sale_model');
		echo $this->sale_model->get_pending_sale_info();
	}
	
	function mark_as_shipped()
	{
		$this->load->model('sale_model');
		echo $this->sale_model->mark_as_shipped();
	}
	
	function mark_as_recieved()
	{
		$this->load->model('buy_model');
		echo $this->buy_model->mark_as_recieved();
	}
	
	function get_market_info()
	{
		$this->load->model('buy_model');
		echo $this->buy_model->get_market_info();
	}
	
	function upload_sale_pic($filename)
	{
		$this->load->model('sale_model');
		echo $this->sale_model->upload_sale_pic($filename);
	}
	
	function delete_sale()
	{
		$this->load->model('sale_model');
		echo $this->sale_model->delete_sale();
	}
	
	function get_awaiting_feedback_info()
	{
		$this->load->model('buy_model');
		echo $this->buy_model->get_awaiting_feedback_info();
	}
	
	function give_feedback()
	{
		$this->load->model('buy_model');
		$retVal['success'] = $this->buy_model->give_feedback();
		echo json_encode($retVal);
	}
	
}