<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 					'ab');
define('FOPEN_READ_WRITE_CREATE', 				'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 			'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| Klect Application Constants
|--------------------------------------------------------------------------
|
| These constants are used throughout the Klect application
|
*/
define('JQUERY_UI_CSS',								'ui-lightness/jquery-ui-1.8.10.custom');
define('JQUERY_UI_JS',								'jquery-ui-1.8.10.custom.min');
define('JQUERY_JS',									'jquery-1.4.4.min');

define('mlp_DOMAIN_TAG',							'mlp');
define('mlp_NAME',									'My Little Ponies');
define('mlp_DOMAIN_ID',								1);
define('mlp_ITEM',									'Pony');
define('mlp_ITEMS',									'Ponies');
define('mlp_DISCLAIMER',							'My Little Pony and all of the names and characters associated therewith are the property of Hasbro. Klect.com claims neither any affiliation with Hasbro nor any ownership of any of the names or characters associated with My Little Pony.');
define('mlp_SPONSOR',								'<a target="_blank" href="http://www.amazon.com/Little-Pony-Collectors-Inventory-illustrated/dp/0978606329/ref=sr_1_1?ie=UTF8&amp;s=books&amp;qid=1282976559&amp;sr=8-1"><img src="/img/mlp/mlp_book.jpg"></a>');
define('mlp_TWITTER',								'http://twitter.com/KLECT_MLP');
define('mlp_FACEBOOK',								'http://www.facebook.com/pages/MLP-KLECT/125890454120407?ref=ts#!/pages/MLP-KLECT/125890454120407?v=wall');
define('mlp_CONDITION',								'&nbsp;&nbsp;<a href="" onclick="return false;" style="color: orange;" class="tooltip">Help
					<span><strong>Unopened Mint:</strong> no cracks or tears to bubble, card, or package. bubble is clear. no flaws to pony<br/><br/>
					<strong>Unopened Good:</strong> some bubble yellowing and or some cracks, box crushed or torn<br/><br/>
					<strong>Open Mint:</strong> original hair, body, symbols and eye have no cuts, scratches or marks<br/><br/>
					<strong>Open Good:</strong> only minor marks to body, slight symbol or eye wear; 2-3 plugs cut<br/><br/>
					<strong>Open Fair:</strong> a few significant marks, a moderate hair cut, some symbol and eye wear<br/><br/>
					<strong>Bait:</strong> major hair cut or missing tail, symbols missing, many irremovable marks, burns</span></a>');
define('mlp_VANILLA', 'my-little-pony');

define('mlp_CONDITION_0', 'B');
define('mlp_CONDITION_1', 'OF');
define('mlp_CONDITION_2', 'OG'); 
define('mlp_CONDITION_3', 'OM'); 
define('mlp_CONDITION_4', 'UG');
define('mlp_CONDITION_5', 'UM');

define('stamp_DOMAIN_TAG',							'stamp');
define('stamp_NAME',								'Stamps');
define('stamp_DOMAIN_ID',							2);
define('stamp_ITEM',								'Stamp');
define('stamp_ITEMS',								'Stamps');
define('stamp_DISCLAIMER',							'The Scott Numbers are the copyrighted property of Amos Press Inc., dba Scott Publishing Co. and are used here under a licensing agreement with Scott. The marks Scott and Scott\'s are Registered in the U.S. Patent and Trademark Office, and are trademarks of Amos Press, Inc. dba Scott Publishing Co. No use may be made of these marks or of material in this publication, which is reprinted from a copyrighted publication of Amos Press, Inc., without the express written permission of Amos Press, Inc., dba Scott Publishing Co., Sidney, Ohio 45365.');
define('stamp_SPONSOR',								'<a target="_blank" href="http://www.linns.com" style="float: left; width: 100%; margin-top: 95px;"><img src="/img/stamp/friends/linnscomlogo.jpg" width="92%" /></a>');
define('stamp_TWITTER',								'http://twitter.com/KLECT_Stamps');
define('stamp_FACEBOOK',							'http://www.facebook.com/pages/Stamp_Collecting_KLECT/190454150982573');
define('stamp_CONDITION',							'&nbsp;&nbsp;<a href="" onclick="return false;" style="color: orange;" class="tooltip">Help
					<span><strong>Unused Very Fine:</strong> Unused centered stamp with wide margins and unhinged.<br/><br/>
					<strong>Unused Fine:</strong> Unused stamp that is significantly offset up or down or to one side but still has four margins. Light hinged or unhinged.<br/><br/>
					<strong>Unused Average:</strong> Unused stamp that is has no margin on at least one side with a portion of the design trimmed off or cut into by perforations. Heavy hinged to unhinged.<br/><br/>
					<strong>Used Very Fine:</strong> Used centered stamp with wide margins and unhinged. Light and well read cancelation.<br/><br/>
					<strong>Used Fine:</strong> Used stamp that is significantly offset up or down or to one side but still has four margins. Light hinged or unhinged. Medium cancelation to light.<br/><br/>
					<strong>Used Average:</strong> Used stamp that is has no margin on at least one side with a portion of the design trimmed off or cut into by perforations. Heavy hinged to unhinged. Heavy cancelation. </span></a>');
define('stamp_VANILLA', 'stamps');

define('stamp_CONDITION_0', 'A');
define('stamp_CONDITION_1', 'F');
define('stamp_CONDITION_2', 'VF'); 
define('stamp_CONDITION_3', 'UA'); 
define('stamp_CONDITION_4', 'UF');
define('stamp_CONDITION_5', 'UVF');

define('img_small',									"100");
define('img_large',									"150");

define('sort_date',									'date , item_id ASC');
define('sort_name',									'name ASC');
define('sort_added',								'owned_item_id DESC');

define('DEF_IMG_SIZE', 'img_large');
define('DEF_SORT_ORD', 'sort_added');

/* End of file constants.php */
/* Location: ./system/application/config/constants.php */