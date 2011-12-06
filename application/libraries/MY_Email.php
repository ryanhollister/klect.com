<?php

class MY_Email extends CI_Email
{
	/**
	 * Set Body
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	public function message($body, $header = '')
	{
		$CI =& get_instance();
		
		if ($CI->phpsession->get('current_domain') != false)
		{
			$facebook = constant($CI->phpsession->get('current_domain')->getTag().'_FACEBOOK');
			$twitter = constant($CI->phpsession->get('current_domain')->getTag().'_TWITTER');
		}
		else
		{
			$facebook = stamp_FACEBOOK;
			$twitter = stamp_TWITTER;
		}
		
		
		$body = stripslashes(rtrim(str_replace("\r", "", $body)));
		$this->_body = <<<STRING
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/> 
    <meta http-equiv="Content-Language" content="en-us"/> 
    <title>KLECT</title> 
  </head> 
  <body style="font-family:Arial, Helvetica, sans-serif;  margin: 0px; padding: 0px; color: black; text-align:left;width:627px"> 
<table bgcolor="" cellpadding="10" border="0" width="600px" style="font-family:Verdana, Helvetica, sans-serif; text-align:left;"> 
  <tr><td> 
    <div style="width:607px; margin:0px; background:white; margin-top:10px"> 
      <table bgcolor="" cellpadding="0" cellspacing="0" border="0"> 
        <tr> 
          <td bgcolor="" style="font-size:0px" width="607"><img alt="KLECT" src="http://www.klect.com/img/klect_email_header.gif" width="605px" height="39px" style="font-size:18px;background-color:#183c5c;color:white;"/></td> 
        </tr> 
        <tr> 
          <td width="607" style="vertical-align: top;" bgcolor=""> 
            <table bgcolor="" cellpadding="0" cellspacing="0" border="0" style="border-left: 1px solid #658db9;border-right: 1px solid #658db9;"> 
              <tr> 
                <td width="603" bgcolor=""> 
                  <table bgcolor="#DDF6E6" cellpadding="0" cellspacing="0" border="0"> 
                    <tr> 
                      <td width="604"> 
                        <table bgcolor="#DDF6E6" cellpadding="0" cellspacing="0" border="0"> 
                          <tr> 
                            <td width="603" style="font-family:Helvetica;font-size:14px"> 
				<br/> 
<div style="color: #f35b00; font-weight: bold; font-size: 22px;line-height:25px; height:25px; text-align:center">$header</div> 
<br/> 
<p style="margin-left:25px;">$body</p> 
                            </td> 
                          </tr> 
                        </table> 
                      </td> 
		</tr> 
                    <tr> 
                      <td width="604" style="border-bottom: 1px solid #658db9;"> 
                        <table bgcolor="#A3D9BA" cellpadding="0" cellspacing="0" border="0" width="100%"> 
                          <tr> 
                            <td width="100%" style="color:#555555;font-size:11px;font-family:Verdana, Helvetica, sans-serif;-webkit-text-size-adjust: none;line-height:12px;"> 
                              <div style="padding:10px;width:327px; float:left; margin-top:10px;margin-bottom:12px;"> 
                                (c) 2010-2011 by KLECT All rights reserved.
                              </div><div style="float:right;color:grey; padding-top:7px; width:250px;margin-top: 10px;  "><span style="font-weight:bold;color:black;">Follow Us:</span> <a href="$facebook"><img src="http://www.klect.com/img/klect_facebook.jpg" style="vertical-align:middle; position: relative;margin-left:5px; border:0"/></a>  <a href="$facebook" style="color:black">Facebook</a> <a href="$twitter"><img src="http://www.klect.com/img/klect_twitter.jpg" style="vertical-align:middle; position: relative;margin-left:5px;border:0;"/></a>  <a href="$twitter" style="color:black">Twitter</a></div> 
                            </td> 
                          </tr> 
                        </table> 
                      </td> 
                    </tr> 
                  </table> 
                </td> 
              </tr> 
            </table> 
          </td> 
        </tr> 
      </table> 
    </div> 
  </td></tr> 
</table> 
<div style="color:rgb(119, 119, 255);width:600px;margin-left:50px;font-size:11px;padding-top:96px;color:grey;" id="message_footer"> 
	<p>In order to ensure you receive our emails, please add contact@klect.com to your address book.</p> 
	<p>If you would like to unsubscribe please respond to this email with UNSUBSCRIBE in the subject</p> 
</div> 
  </body>
</html>
STRING;
		
		return $this;
	}
}