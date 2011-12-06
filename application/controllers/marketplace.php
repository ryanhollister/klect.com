<?php
class Marketplace extends CI_Controller
{
	private $domain_name;
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('item_model');
		$this->load->model('domain_model');
		$this->domain_name = $this->phpsession->get('current_domain')->getName();
		is_logged_in();
	}
	
	/**
	 * Main dashboard for the marketplace. 
	 * 
	 * The user can see their marketplace info or initiate a buy or sell.
	 * 
	 */
	
	function dashboard()
	{
		$this->load->model('sale_model');
		$this->load->model('buy_model');
		$this->load->model('person_model');
		$data['page_title'] = 'Klect.com - '.$this->phpsession->get('current_domain')->getName().' Marketplace';
		$data['additional_collections'] = $this->domain_model->getNewCollections();
		$data['users_collections'] = $this->domain_model->getUsersCollections();
		$data['js_includes'][] = JQUERY_UI_JS;
		$data['js_includes'][] = 'marketplace_dashboard';
		$data['js_includes'][] = 'klect';
		$data['member_rating'] = $this->person_model->get_member_rating();
		$data['pending_sales'] = $this->sale_model->get_persons_pending();
		$data['active_sales'] = $this->sale_model->get_persons_active();
		$data['pending_purchases'] = $this->buy_model->get_pending_purchases();
		$data['awaiting_feedback'] = $this->buy_model->getAwaitingFeedback();
		$data['oi_to_sale'] = $this->sale_model->get_oi_to_sale_map();
		$data['lefts']['Marketplace'] = $this->load->view('modules/marketplace_dashboard', false, true);
		$data['rights']['My Summary'] = $this->load->view('modules/my_marketplace', $data, true);
		$data['css_includes'][] = JQUERY_UI_CSS;
		$data['back_loc']['back_to_dashboard.gif'] = base_url().'members_area/dashboard';
		$data['dialogs'][] = $this->load->view('dialogs/buy', false, true);
		$data['dialogs'][] = $this->load->view('dialogs/pending_sale', false, true);
		$data['dialogs'][] = $this->load->view('dialogs/pending_purchase', false, true);
		$data['dialogs'][] = $this->load->view('dialogs/awaiting_feedback', false, true);
		$data['dialogs'][] = $this->load->view('dialogs/invite_a_friend', array(), true);
		if(count($data['additional_collections']) > 0) { $data['dialogs'][] = $this->load->view('dialogs/add_collection', $data, true); }
		$this->load->view('marketplace', $data);
	}
	
	/**
	 * Entry point to begin buying an item that is for sale.
	 * 
	 */
	function buy()
	{
		$this->load->model('buy_model');
		$data['page_title'] = 'Klect.com - Buy a '.$this->domain_name;
		$data['js_includes'][] = JQUERY_UI_JS;
		$data['js_includes'][] = 'buy';
		$data['js_includes'][] = 'klect';
		$item_array = $this->buy_model->get_open_sales();
		$data['additional_collections'] = $this->domain_model->getNewCollections();
		$data['users_collections'] = $this->domain_model->getUsersCollections();
		$sales['counts'] = array_count_values($item_array);
		$sales['sale_items'] = $this->item_model->getItems(array_unique($item_array));
		$data['lefts'][$this->domain_name.' For Sale'] = $this->load->view('modules/items_forsale', $sales , true);
		$data['collection_attributes'] = $this->phpsession->get('current_domain')->getAttributes();
		$data['jquery_scripts'][] = '$( "#name_core" ).autocomplete({ minLength: 2, source: function (request, response) { $.ajax({ url : "'.base_url().'item_filtering/autocomplete/name/" + request.term, dataType : "json", success: function( data ) { response( $.map( data, function( item ) { return { label: item.label };}));} });}});';
		
		foreach ($data['collection_attributes'] as $attr_id => $attr_txt)
		{
			$data['jquery_scripts'][] = '$( "#'.$attr_id.'_input" ).autocomplete({ minLength: 2, source: function (request, response) { $.ajax({ url : "'.base_url().'item_filtering/autocomplete/'.$attr_id.'_input/" + request.term, dataType : "json", success: function( data ) { response( $.map( data, function( item ) { return { label: item.label, value: item.value };}));} });}});';
		}
		$data['rights']['Filter Sales'] = $this->load->view('modules/buy_filter', $data, true);
		$data['css_includes'][] = JQUERY_UI_CSS;
		$data['back_loc']['back_to_dashboard.gif'] = base_url().'marketplace/dashboard';
		$data['dialogs'][] = $this->load->view('dialogs/invite_a_friend', array(), true);
		if(count($data['additional_collections']) > 0) { $data['dialogs'][] = $this->load->view('dialogs/add_collection', $data, true); }
		$this->load->view('marketplace', $data);
	}
	
	/**
	 * Entry point to begin listing an item in the marketplace.
	 * 
	 */
	function sell()
	{
		$this->load->model('sale_model');
		$this->load->model('buy_model');
		$data['page_title'] = 'Klect.com - Sell a '.$this->domain_name;
		$data['js_includes'][] = JQUERY_UI_JS;
		$data['js_includes'][] = 'sell';
		$data['js_includes'][] = 'klect';
		$data['js_includes'][] = 'fileuploader';
		$data['js_includes'][] = 'jquery.imgareaselect';
		$data['additional_collections'] = $this->domain_model->getNewCollections();
		$data['users_collections'] = $this->domain_model->getUsersCollections();
		$data['pending_purchases'] = $this->buy_model->get_pending_purchases();
		$data['active_sales'] = $this->sale_model->get_persons_active();
		$data['oi_to_sale'] = $this->sale_model->get_oi_to_sale_map();
		$data['collection_items'] = $this->sale_model->get_persons_sellables();
		$data['lefts']['Select a '.constant($this->phpsession->get('current_domain')->getTag().'_ITEM').' to Sell'] = $this->load->view('modules/marketplace_item', $data, true);
		$data['rights']['Active Sales'] = $this->load->view('modules/edit_sales', $data, true);
		$data['dialogs'][] = $this->load->view('dialogs/sale', false, true);
		$data['css_includes'][] = JQUERY_UI_CSS;
		$data['css_includes'][] = 'fileuploader';
		$data['css_includes'][] = 'imgareaselect-default';
		$data['jquery_scripts'][] = "$('.accordion .head').click(function() {\$(this).next().toggle('slow');return false;}).next().hide();";
		$data['jquery_scripts'][] = "var uploader = new qq.FileUploader({element: $('#file-uploader')[0], action: '/mp_management/upload_sale_pic', onSubmit: showProgress, onComplete: handleSuccess, allowedExtensions : ['jpg','jpeg', 'tif', 'gif', 'png', 'bmp'], params : {url : '/mp_management/upload_sale_pic/' }});";
		$data['jquery_scripts'][] = "$('img#cust_catalog_image').imgAreaSelect({ handles: true, zIndex: 99999, aspectRatio: '4:3', onSelectChange : update_crop}); ";
		$data['back_loc']['back_to_marketplace.gif'] = base_url().'marketplace/dashboard';
		$data['dialogs'][] = $this->load->view('dialogs/invite_a_friend', array(), true);
		if(count($data['additional_collections']) > 0) { $data['dialogs'][] = $this->load->view('dialogs/add_collection', $data, true); }
		$this->load->view('marketplace', $data);
	}
	
	/**
	 * Entry point for displaying all sales for a specific item
	 * 
	 * @param int $item_id
	 */
	function buy_item($item_id)
	{
		$this->load->model('buy_model');
		$item = $this->item_model->getItems(array($item_id));
		$data['page_title'] = 'Klect.com - Buy a '.$this->domain_name;
		$data['js_includes'][] = JQUERY_UI_JS;
		$data['js_includes'][] = 'buy_item';
		$data['js_includes'][] = 'klect';
		$data['additional_collections'] = $this->domain_model->getNewCollections();
		$data['users_collections'] = $this->domain_model->getUsersCollections();
		$item_array = $this->buy_model->get_open_sales($item_id);
		$market_info = $this->buy_model->get_market_info($item_id);
		$sales['sale_items'] = $this->item_model->getOwnedItems($item_array, true);
		$sales['cust_imgs'] = $this->buy_model->getCustImgs($item_id);
		$data['lefts'][$item[0]->getName().'s For Sale'] = $this->load->view('modules/items_sales', $sales , true);
		$data['rights']['Market Summary'] = $this->load->view('modules/market_summary', array('data' => $market_info) , true);
		$data['css_includes'][] = JQUERY_UI_CSS;
		$data['dialogs'][] = $this->load->view('dialogs/buy', false, true);
		$data['back_loc']['back_to_listings.gif'] = base_url().'marketplace/buy';
		$data['dialogs'][] = $this->load->view('dialogs/invite_a_friend', array(), true);
		if(count($data['additional_collections']) > 0) { $data['dialogs'][] = $this->load->view('dialogs/add_collection', $data, true); }
		$this->load->view('marketplace', $data);
	}
	
}