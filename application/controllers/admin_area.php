<?php
class Admin_area extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		is_admin();
		$this->load->model('admin_model');
	}
	
	function dashboard()
	{
		$data['page_title'] = 'Klect.com - Admin Dashboard';
		$data['js_includes'][] = 'jquery-ui-1.8.5.custom.min';
		$data['js_includes'][] = 'klect';
		$data['css_includes'][] = 'ui-lightness/jquery-ui-1.8.5.custom';
		$data['stats']['User Count'] = $this->admin_model->getUserCount();
		$data['stats']['Pony User Count'] = $this->admin_model->getPonyUserCount();
		$data['stats']['Stamp User Count'] = $this->admin_model->getStampUserCount();
		$data['stats']['Owned Item Count'] = $this->admin_model->getOwnedItemCount();
		$data['stats']['Pony Owned Item Count'] = $this->admin_model->getPonyOwnedItemCount();
		$data['stats']['Stamp Owned Item Count'] = $this->admin_model->getStampOwnedItemCount();
		$data['stats']['Wish List Count'] = $this->admin_model->getWishListCount();
		$data['stats']['Subscriptions'] = $this->admin_model->getSubscriptionCount();
		$data['stats']['Users with shipping info'] = $this->admin_model->getShippingCount();
		$data['stats']['Marketplace Purchases'] = $this->admin_model->getSaleCount();
		$data['lefts']['KLECT.com Stats'] = $this->load->view('modules/admin_stats', $data, TRUE);
		$data['rights']['Holding'] = 'Holding';
		$this->load->view('members_area', $data);
	}
}
?>