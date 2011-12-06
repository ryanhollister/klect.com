<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Authorize.Net
|--------------------------------------------------------------------------
|
| All of the stuff we need to connect with Authorize.Net
|
|
*/

$config['loginname']			= "796FuGdp";
$config['transactionkey']		= "78eMSehS936PL4D9";
$config['host'] 				= "api.authorize.net";
$config['path'] 				= "/xml/v1/request.api";

/*
|--------------------------------------------------------------------------
| Free trial period
|--------------------------------------------------------------------------
|
| How long (in months) should a new paid account have as a free trial?
|
|
*/
$config['trial_period']	= 1;

?>
