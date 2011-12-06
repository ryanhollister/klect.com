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
		$data['js_includes'][] = 'admin_area';
		$data['js_includes'][] = 'klect';
		$data['css_includes'][] = 'ui-lightness/jquery-ui-1.8.5.custom';
		$data['stats']['User'] = $this->admin_model->getUserCount();
		$data['stats']['Pony User'] = $this->admin_model->getPonyUserCount();
		$data['stats']['Stamp User'] = $this->admin_model->getStampUserCount();
		$data['stats']['Owned Item'] = $this->admin_model->getOwnedItemCount();
		$data['stats']['Pony Owned Item'] = $this->admin_model->getPonyOwnedItemCount();
		$data['stats']['Stamp Owned Item'] = $this->admin_model->getStampOwnedItemCount();
		$data['stats']['Wish List'] = $this->admin_model->getWishListCount();
		$data['stats']['Subscriptions'] = $this->admin_model->getSubscriptionCount();
		$data['stats']['Users with shipping info'] = $this->admin_model->getShippingCount();
		$data['stats']['Marketplace Purchases'] = $this->admin_model->getSaleCount();
		$data['rights']['KLECT.com Stats'] = $this->load->view('modules/admin_stats', $data, TRUE);
		$data['lefts']['Holding'] = '<p style="margin:5px;">Click <a href="" id="run_test">here</a> to run all unit tests</p><div id="results" style="margin: 34px 8px;"></div>';
		$this->load->view('members_area', $data);
	}
	
	function run_tests()
	{
		chdir('tests');
		echo nl2br(shell_exec('/Applications/MAMP/bin/php/php5.3.6/bin/phpunit'));
		chdir('..');
	}
}
?>