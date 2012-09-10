<?php

class Members_area extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('item_model');
		$this->load->model('domain_model');
		$this->load->model('person_model');
		$this->load->model('community_model');
	}
	
	/**
	 * Main dashboard for a logged in user. First page shown after a successful login.
	 * 
	 */
	
	function dashboard($offset = 0)
	{
		$offset = (int)$offset;
		$this->load->model('sale_model');
		$data['collection_items'] = $this->item_model->getPersonsItems(false, $offset);
		$this->pagination->base_url = base_url()."members_area/dashboard";
		$data['additional_collections'] = $this->domain_model->getNewCollections();
		$data['users_collections'] = $this->domain_model->getUsersCollections();
		$data['collection_attributes'] = $this->phpsession->get('current_domain')->getAttributes();
		$data['page_title'] = 'Klect.com - Your Dashboard';
		$data['js_includes'][] = JQUERY_UI_JS;
		$data['js_includes'][] = 'dashboard';
		$data['js_includes'][] = 'klect';
		$data['css_includes'][] = JQUERY_UI_CSS;
		$data['pending_sales'] = $this->sale_model->get_persons_pending();
		$data['active_sales'] = $this->sale_model->get_persons_active();
		$data['sold_sales'] = '';
		$data['catalog_info_button'] = 'collection_item_div';
		$data['collection_value'] = $this->item_model->getPersonsValue($this->phpsession->get('current_domain')->getId());
		$data['dialogs'][] = $this->load->view('dialogs/edit_profile', false, true);
		$data['dialogs'][] = $this->load->view('dialogs/personal_catalog', $data, true);
		
		if ($this->phpsession->get('personVO')->getPremium() == 1) 
		{ 
			$data['jquery_scripts'][] = "var uploader = new qq.FileUploader({element: $('#file-uploader')[0], action: '/item_management/uploadcustomimage', onSubmit: showProgress, onComplete: handleSuccess, allowedExtensions : ['jpg','jpeg', 'tif', 'gif', 'png', 'bmp'], params : {url : '/item_management/uploadcustomimage/' }});";
			$data['css_includes'][] = 'fileuploader';
			$data['css_includes'][] = 'imgareaselect-default';
			$data['js_includes'][] = 'fileuploader';
			$data['js_includes'][] = 'jquery.imgareaselect';
		}
		
		$data['dialogs'][] = $this->load->view('dialogs/invite_a_friend', array(), true);
		$data['jquery_scripts'][] = '$( "#name_core" ).autocomplete({ minLength: 2, source: function (request, response) { $.ajax({ url : "'.base_url().'item_filtering/autocomplete/name/" + request.term, dataType : "json", success: function( data ) { response( $.map( data, function( item ) { return { label: item.label };}));} });}});';
		
		foreach ($data['collection_attributes'] as $attr_id => $attr_txt)
		{
			$data['jquery_scripts'][] = '$( "#'.$attr_id.'_input" ).autocomplete({ minLength: 2, source: function (request, response) { $.ajax({ url : "'.base_url().'item_filtering/autocomplete/'.$attr_id.'_input/" + request.term, dataType : "json", success: function( data ) { response( $.map( data, function( item ) { return { label: item.label, value: item.value };}));} });}});';
		}
		$data['jquery_scripts'][] = '$("#datepicker").datepicker();';
		if(count($data['additional_collections']) > 0) { $data['dialogs'][] = $this->load->view('dialogs/add_collection', $data, true); }
		$this->load->view('dashboard', $data);
	}
	
	/**
	 * Page where a user can edit an item's details or remove an item from their collection.
	 * 
	 */
	function edit_collection($offset = 0)
	{
		$data['collection'] = $this->item_model->getPersonsItems(false, $offset);
		$this->pagination->base_url = base_url()."members_area/edit_collection";
		$data['additional_collections'] = $this->domain_model->getNewCollections();
		$data['users_collections'] = $this->domain_model->getUsersCollections();
		$data['collection_attributes'] = $this->phpsession->get('current_domain')->getAttributes();
		$data['page_title'] = 'Klect.com - Edit Collection';
		$data['js_includes'][] = JQUERY_UI_JS;
		$data['js_includes'][] = 'klect';
		$data['js_includes'][] = 'edit_collection';
		$data['css_includes'][] = JQUERY_UI_CSS;

		$data['back_loc']['back_to_dashboard.gif'] = base_url().'members_area/dashboard';
		$data['jquery_scripts'][] = '$( "#name_core" ).autocomplete({ minLength: 2, source: function (request, response) { $.ajax({ url : "'.base_url().'item_filtering/autocomplete/name/" + request.term, dataType : "json", success: function( data ) { response( $.map( data, function( item ) { return { label: item.label };}));} });}});';
		
		foreach ($data['collection_attributes'] as $attr_id => $attr_txt)
		{
			$data['jquery_scripts'][] = '$( "#'.$attr_id.'_input" ).autocomplete({ minLength: 2, source: function (request, response) { $.ajax({ url : "'.base_url().'item_filtering/autocomplete/'.$attr_id.'_input/" + request.term, dataType : "json", success: function( data ) { response( $.map( data, function( item ) { return { label: item.label, value: item.value };}));} });}});';
		}
		$data['jquery_scripts'][] = '$("#datepicker").datepicker();';
		$data['catalog_info_button'] = 'zoom';
		$data['value_options'] = $this->domain_model->getValueOptions($this->phpsession->get('current_domain')->getId());
		$data['dialogs'][] = $this->load->view('dialogs/personal_catalog', $data, true);
		$data['dialogs'][] = $this->load->view('dialogs/invite_a_friend', array(), true);
		
		if ($this->phpsession->get('personVO')->getPremium() == 1) 
		{ 
			$data['jquery_scripts'][] = "var uploader = new qq.FileUploader({element: $('#file-uploader')[0], action: '/item_management/uploadcustomimage', onSubmit: showProgress, onComplete: handleSuccess, allowedExtensions : ['jpg','jpeg', 'tif', 'gif', 'png', 'bmp'], params : {url : '/item_management/uploadcustomimage/' }});";
			$data['css_includes'][] = 'fileuploader';
			$data['css_includes'][] = 'imgareaselect-default';
			$data['js_includes'][] = 'fileuploader';
			$data['js_includes'][] = 'jquery.imgareaselect';
		}
		
		if(count($data['additional_collections']) > 0) { $data['dialogs'][] = $this->load->view('dialogs/add_collection', $data, true); }
		$this->load->view('edit_collection', $data);
	}
	
	/**
	 * Page where a user can add items to their collection.
	 * 
	 */
	function add_to_collection($offset = 0)
	{
		$data['catalog_items'] = $this->item_model->getItems(false, false, $offset);
		$this->pagination->base_url = base_url()."members_area/add_to_collection";
		$data['additional_collections'] = $this->domain_model->getNewCollections();
		$data['users_collections'] = $this->domain_model->getUsersCollections();
		$data['collection_attributes'] = $this->phpsession->get('current_domain')->getAttributes();
		$data['page_title'] = 'Klect.com - Add to Collection';
		$data['js_includes'][] = JQUERY_UI_JS;
		$data['js_includes'][] = 'klect';
		$data['js_includes'][] = 'add_to_collection';
		$data['css_includes'][] = JQUERY_UI_CSS;
		$data['dialogs'][] = $this->load->view('dialogs/invite_a_friend', array(), true);
		$data['value_options'] = $this->domain_model->getValueOptions($this->phpsession->get('current_domain')->getId());
		$data['back_loc']['back_to_dashboard.gif'] = base_url().'members_area/dashboard';
		$data['jquery_scripts'][] = '$( "#name_core" ).autocomplete({ minLength: 2, source: function (request, response) { $.ajax({ url : "'.base_url().'item_filtering/autocomplete/name/" + request.term, dataType : "json", success: function( data ) { response( $.map( data, function( item ) { return { label: item.label };}));} });}});';
		
		foreach ($data['collection_attributes'] as $attr_id => $attr_txt)
		{
			$data['jquery_scripts'][] = '$( "#'.$attr_id.'_input" ).autocomplete({ minLength: 2, source: function (request, response) { $.ajax({ url : "'.base_url().'item_filtering/autocomplete/'.$attr_id.'_input/" + request.term, dataType : "json", success: function( data ) { response( $.map( data, function( item ) { return { label: item.label, value: item.value };}));} });}});';
		}
		$data['jquery_scripts'][] = '$("#datepicker").datepicker();';
		if(count($data['additional_collections']) > 0) { $data['dialogs'][] = $this->load->view('dialogs/add_collection', $data, true); }
		$data['onClick'] = true;
		$this->load->view('add_to_collection', $data);
	}
	
	/**
	 * This is a viewing only page that allows the user to just browse the catalog of items in our system for the current domain.
	 */
	function browse_catalog($offset = 0)
	{
		$data['catalog_items'] = $this->item_model->getItems(false, false, $offset, true);
		
		// Add the dummy "new item"
		array_unshift($data['catalog_items'], $this->community_model->getDummyCatalogItem());
		
		$this->pagination->base_url = base_url()."members_area/browse_catalog";
		$data['additional_collections'] = $this->domain_model->getNewCollections();
		$data['users_collections'] = $this->domain_model->getUsersCollections();
		$data['collection_attributes'] = $this->phpsession->get('current_domain')->getAttributes();
		$data['page_title'] = 'Klect.com - Browse Catalog';
		$data['js_includes'][] = JQUERY_UI_JS;
		$data['js_includes'][] = 'klect';
		$data['js_includes'][] = 'browse_catalog';
		$data['css_includes'][] = JQUERY_UI_CSS;
		$data['dialogs'][] = $this->load->view('dialogs/invite_a_friend', array(), true);
		$data['back_loc']['back_to_dashboard.gif'] = base_url().'members_area/dashboard';
		$data['jquery_scripts'][] = '$( "#name_core" ).autocomplete({ minLength: 2, source: function (request, response) { $.ajax({ url : "'.base_url().'item_filtering/autocomplete/name/" + request.term, dataType : "json", success: function( data ) { response( $.map( data, function( item ) { return { label: item.label };}));} });}});';
		
		foreach ($data['collection_attributes'] as $attr_id => $attr_txt)
		{
			$data['jquery_scripts'][] = '$( "#'.$attr_id.'_input" ).autocomplete({ minLength: 2, source: function (request, response) { $.ajax({ url : "'.base_url().'item_filtering/autocomplete/'.$attr_id.'_input/" + request.term, dataType : "json", success: function( data ) { response( $.map( data, function( item ) { return { label: item.label, value: item.value };}));} });}});';
		}
		$data['jquery_scripts'][] = '$("#datepicker").datepicker();';
		if(count($data['additional_collections']) > 0) { $data['dialogs'][] = $this->load->view('dialogs/add_collection', $data, true); }
		$this->load->view('browse_catalog', $data);
	}
	
	/**
	 * This is a viewing only page that allows the user to just browse the catalog of items in our system for the current domain.
	 */
	function wish_list($offset = 0)
	{
		$wishlist_array = $this->item_model->getwishlist();
		$data['additional_collections'] = $this->domain_model->getNewCollections();
		$data['users_collections'] = $this->domain_model->getUsersCollections();
		$data['wish_list'] = implode('|', $wishlist_array['ids']);
		$data['wish_names'] = implode('|', $wishlist_array['names']);
		$data['catalog_items'] = $this->item_model->getUnownedItems(false,$offset);
		$this->pagination->base_url = base_url()."members_area/wish_list";
		$data['collection_attributes'] = $this->phpsession->get('current_domain')->getAttributes();
		$data['page_title'] = 'Klect.com - Wish List';
		$data['js_includes'][] = JQUERY_UI_JS;
		$data['js_includes'][] = 'klect';
		$data['js_includes'][] = 'wish_list';
		$data['css_includes'][] = JQUERY_UI_CSS;
		$data['back_loc']['back_to_dashboard.gif'] = base_url().'members_area/dashboard';
		
		if ($data['wish_list'] != '')
		{
			$data['jquery_scripts'][] = 'update_wishlist();rebuild_plus();';
		}
		
		$data['jquery_scripts'][] = '$( "#name_core" ).autocomplete({ minLength: 2, source: function (request, response) { $.ajax({ url : "'.base_url().'item_filtering/autocomplete/name/" + request.term, dataType : "json", success: function( data ) { response( $.map( data, function( item ) { return { label: item.label };}));} });}});';
		
		foreach ($data['collection_attributes'] as $attr_id => $attr_txt)
		{
			$data['jquery_scripts'][] = '$( "#'.$attr_id.'_input" ).autocomplete({ minLength: 2, source: function (request, response) { $.ajax({ url : "'.base_url().'item_filtering/autocomplete/'.$attr_id.'_input/" + request.term, dataType : "json", success: function( data ) { response( $.map( data, function( item ) { return { label: item.label, value: item.value };}));} });}});';
		}
		$data['jquery_scripts'][] = '$("#datepicker").datepicker();';
		$data['jquery_scripts'][] = '$("#datepicker").datepicker();';
		$data['value_options'] = $this->domain_model->getValueOptions($this->phpsession->get('current_domain')->getId());
		if(count($data['additional_collections']) > 0) { $data['dialogs'][] = $this->load->view('dialogs/add_collection', $data, true); }
		$data['dialogs'][] = $this->load->view('dialogs/invite_a_friend', array(), true);
		$this->load->view('wish_list', $data);
	}
	
}
?>