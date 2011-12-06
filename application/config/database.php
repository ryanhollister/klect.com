<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the "Database Connection"
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the "default" group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$env_used = 'default'; //name of your development setting
if(defined('CIUnit_Version')){
  $env_used .= '_test';
}
$active_group = $env_used;
$active_record = TRUE;

$db['default']['hostname'] = "localhost";
$db['default']['username'] = "root";
$db['default']['password'] = "root";
$db['default']['database'] = "ryanhollister";
$db['default']['dbdriver'] = "mysqli";
$db['default']['dbprefix'] = "";
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = "";
$db['default']['char_set'] = "utf8";
$db['default']['dbcollat'] = "utf8_general_ci";

$db['default_test']['hostname'] = "localhost";
$db['default_test']['username'] = "root";
$db['default_test']['password'] = "root";
$db['default_test']['database'] = "ryanhollister_test";
$db['default_test']['dbdriver'] = "mysqli";
$db['default_test']['dbprefix'] = "";
$db['default_test']['pconnect'] = TRUE;
$db['default_test']['db_debug'] = TRUE;
$db['default_test']['cache_on'] = FALSE;
$db['default_test']['cachedir'] = "";
$db['default_test']['char_set'] = "utf8";
$db['default_test']['dbcollat'] = "utf8_general_ci";


/* End of file database.php */
/* Location: ./system/application/config/database.php */