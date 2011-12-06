<?php
class Collection_management extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('domain_model');
	}

	public function get_new_collections()
	{
		echo json_encode($this->domain_model->getNewCollections());
	}
	
	public function add_collection()
	{
		$this->domain_model->add_collection((int)$this->input->post('collection_id'));
		return true;
	}
	
	public function change_collection()
	{
		$collection_id = (int)$this->input->post('collection_id');
		echo $this->domain_model->change_collection($collection_id);
	}
	
}