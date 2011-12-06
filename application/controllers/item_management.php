<?php
class Item_management extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		is_logged_in();
	}
	
	function uploadcustomimage($filename, $owned_item_id)
	{
		$this->load->model('item_model');
		echo $this->item_model->uploadcustomimage($filename, $owned_item_id);
	}
	
	function clearcustomimage()
	{
		$this->load->model('item_model');
		echo $this->item_model->remove_custom_image();
	}
	
	/**
	 * 
	 */
	function addtowishlist()
	{
		$this->load->model('item_model');
		$this->item_model->addtowishlist();
		echo "Successfully updated wishlist";
	}
	
	/**
	 * 
	 */
	function emailwishlist()
	{
		$this->load->model('item_model');
		$this->item_model->addtowishlist();
		$this->item_model->emailwishlist();
		echo "Successfully emailed wishlist";
	}
	
	/**
	 * Validates the input and uses the passed information to add an item to the current domain.
	 */
	function addtocollection()
	{

		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('owned_item_id', 'Owned Item Id', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|');
		$this->form_validation->set_rules('datepicker', 'Date Aquired', 'trim|');
		$this->form_validation->set_rules('condition', 'Item Condition', 'trim|');
		$this->form_validation->set_rules('price', 'Purchase Price', 'trim|');
		
		if($this->form_validation->run() == TRUE)
		{
			$this->load->model('item_model');
			$this->item_model->create_owned_item();
			echo "Successfully added new ".constant($this->phpsession->get('current_domain')->getTag().'_ITEM')." to your collection!";
		}
		else
		{	
			echo "Failed to add new ".constant($this->phpsession->get('current_domain')->getTag().'_ITEM')." to your collection!";		
		}
		
	}
	
	/**
	 * Edits the personal details of a users' item in their collection.
	 */
	public function update_owned_item()
	{
		$this->load->model('item_model');
		$this->item_model->update_owned_item();
		
		echo true;
	}
	
	/**
	 * Removes an item from the users collection.
	 */
	function remove_owned_item()
	{
		$this->load->model('item_model');
		echo $this->item_model->remove_owned_item();
	}
	
	/**
	 * Returns only the personal details of an item.
	 */
	public function get_oi_details()
	{
		$this->load->model('item_model');
		echo $this->item_model->get_oi_details();
	}
	
	/**
	 * Returns the details of an owned item from the catalog. All the details of get_catalog_details plus the user defined details.
	 */
	public function get_owned_catalog_details()
	{
		$this->load->model('item_model');
		echo $this->item_model->get_owned_catalog_details();
	}
	
	public function getWishListName()
	{
		$this->load->model('item_model');
		echo $this->item_model->getWishListName();
	}
	
	/**
	 * Returns only the catalog details of an item. Does not include any personal details of that item.
	 */
	public function get_catalog_details()
	{
		$this->load->model('item_model');
		echo $this->item_model->get_catalog_details();
	}
}
