<?php
	function is_logged_in()
	{
		$CI =& get_instance();
		$is_logged_in = $CI->phpsession->get('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			$CI->phpsession->clear();
			redirect('/index.php');	
		}		
	}	
	
	function is_admin()
	{
		$CI =& get_instance();
		$is_logged_in = $CI->phpsession->get('is_logged_in');
		$is_admin = $CI->phpsession->get('personVO')->getAdmin() == 1 ? true : false;
		if(!isset($is_logged_in) || $is_logged_in != true || $is_admin != true)
		{
			$CI->phpsession->clear();
			redirect('/index.php');	
		}		
	}
	
	function isProd()
	{
		return (!strstr($_SERVER["HTTP_HOST"], 'localhost') && !strstr($_SERVER["HTTP_HOST"], 'rhollister'));
	}
?>