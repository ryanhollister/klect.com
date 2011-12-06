<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Log extends CI_Log
{

    function MY_Log()
    {
        parent::CI_Log();
        echo '<br />File: '. __FILE__;
        echo '<br />Line: '. __LINE__;
    }//endfunc
    
}//endclass  
?>