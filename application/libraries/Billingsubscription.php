<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class BillingSubscription {

	var $loginname;
	var $transactionkey;
	var $host;

	function BillingSubscription() {
		global $CI;
		$CI =& get_instance();
		$CI->load->helper('url');
		$CI->load->library('session');
		$CI->load->database();
		$CI->config->load('billing');

		$this->loginname		= $CI->config->item('loginname');
		$this->transactionkey	= $CI->config->item('transactionkey');
		$this->host				= $CI->config->item('host');
		$this->path				= $CI->config->item('path');
	}

	function create_subscription($data) {
		$amount = $data["amount"];
		$refId = $data["refId"];
		$name = $data["name"];
		$length = $data["length"];
		$unit = $data["unit"];
		$startDate = $data["startDate"];
		$totalOccurrences = $data["totalOccurrences"];
		$trialOccurrences = $data["trialOccurrences"];
		$trialAmount = $data["trialAmount"];
		$cardNumber = $data["cardNumber"];
		$expirationDate = $data["expirationDate"];
		$firstName = $data["firstName"];
		$lastName = $data["lastName"];
		$address = $data["address"];
		$city    = $data["city"];
		$state = $data["state"];
		$zip = $data["zip"];
		$country = $data["country"];
		$cvv = $data["cvv"];
		

		$content =
		        "<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
		        "<ARBCreateSubscriptionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
		        "<merchantAuthentication>".
		        "<name>" . $this->loginname . "</name>".
		        "<transactionKey>" . $this->transactionkey . "</transactionKey>".
		        "</merchantAuthentication>".
				"<refId>" . $refId . "</refId>".
		        "<subscription>".
		        "<name>" . $name . "</name>".
		        "<paymentSchedule>".
		        "<interval>".
		        "<length>". $length ."</length>".
		        "<unit>". $unit ."</unit>".
		        "</interval>".
		        "<startDate>" . $startDate . "</startDate>".
		        "<totalOccurrences>". $totalOccurrences . "</totalOccurrences>".
		        "<trialOccurrences>". $trialOccurrences . "</trialOccurrences>".
		        "</paymentSchedule>".
		        "<amount>". $amount ."</amount>".
		        "<trialAmount>" . $trialAmount . "</trialAmount>".
		        "<payment>".
		        "<creditCard>".
		        "<cardNumber>" . $cardNumber . "</cardNumber>".
		        "<expirationDate>" . $expirationDate . "</expirationDate>".
				"<cardCode>" . $cvv . "</cardCode>".
		        "</creditCard>".
		        "</payment>".
		        "<billTo>".
		        "<firstName>". $firstName . "</firstName>".
		        "<lastName>" . $lastName . "</lastName>".
				"<address>" . $address . "</address>".
				"<city>" . $city . "</city>".
				"<state>" . $state . "</state>".
				"<zip>" . $zip . "</zip>".
				"<country>" . $country . "</country>".
		        "</billTo>".
		        "</subscription>".
		        "</ARBCreateSubscriptionRequest>";

		//send the xml via curl
		$response = $this->send_request_via_curl($this->host,$this->path,$content);

		//if the connection and send worked $response holds the return from Authorize.net
		if ($response) {
			/*
			a number of xml functions exist to parse xml results, but they may or may not be avilable on your system
			please explore using SimpleXML in php 5 or xml parsing functions using the expat library
			in php 4
			parse_return is a function that shows how you can parse though the xml return if these other options are not avilable to you
			*/
			list ($refId, $resultCode, $code, $text, $subscriptionId) = $this->parse_return($response);		

			if($resultCode == "Ok"){
				return array(	'success'			=> TRUE,
								'subscription_id'	=> $subscriptionId,
								'response'			=> $response
				);
			}else {
				//TODO: needs to return specific errors!
				return array(	'success'			=> FALSE,
								'subscription_id'	=> 0,
								'response'			=> $response
				);
			}	

		} else {
			return array(	'success'	=> FALSE, 'response'	=> $response, 'subscription_id'	=> 0 );
		}
	}

	function update_subscription($data) {
		$subscriptionId 	= $data["subscription_id"];
		$amount				= $data["amount"];

		//build xml to post
		$content =
		        "<?xml version=\"1.0\" encoding=\"utf-8\"?>".
		        "<ARBUpdateSubscriptionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">".
		        "<merchantAuthentication>".
		        "<name>" . $this->loginname . "</name>".
		        "<transactionKey>" . $this->transactionkey . "</transactionKey>".
		        "</merchantAuthentication>".
		        "<subscriptionId>" . $subscriptionId . "</subscriptionId>".
		        "<subscription>".
		        "<amount>". $amount ."</amount>";

   		        if(isset($data["cardNumber"])) {
   		        	$content .=
   		        		"<payment>".
				        "<creditCard>".
				        "<cardNumber>" . $data["cardNumber"] ."</cardNumber>".
				        "<expirationDate>" . $data["expirationDate"] . "</expirationDate>".
				        "</creditCard>".
				        "</payment>";
		        }

		$content .=
		        "</subscription>".
		        "</ARBUpdateSubscriptionRequest>";

		//send the xml via curl
		$response = $this->send_request_via_curl($this->host,$this->path,$content);
		//if curl is unavilable you can try using fsockopen
		/*
		$response = send_request_via_fsockopen($host,$path,$content);
		*/

		//if the connection and send worked $response holds the return from Authorize.net
		if ($response) {
				/*
			a number of xml functions exist to parse xml results, but they may or may not be avilable on your system
			please explore using SimpleXML in php 5 or xml parsing functions using the expat library
			in php 4
			parse_return is a function that shows how you can parse though the xml return if these other options are not avilable to you
			*/
			list ($resultCode, $code, $text, $subscriptionId) =$this->parse_return($response);

			if($code == "Ok"){
				return TRUE;
			} else {
				return FALSE;
			}

			echo " Response Code: $resultCode <br>";
			echo " Response Reason Code: $code<br>";
			echo " Response Text: $text<br>";
			echo " Subscription Id: $subscriptionId <br><br>";

		} else {
			echo "Transaction Failed. <br>";
		}
	}

	function cancel_subscription($data) {

		$subscriptionId = $data["subscription_id"];

		//build xml to post
		$content =
		        "<?xml version=\"1.0\" encoding=\"utf-8\"?>".
		        "<ARBCancelSubscriptionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">".
		        "<merchantAuthentication>".
		        "<name>" . $this->loginname . "</name>".
		        "<transactionKey>" . $this->transactionkey . "</transactionKey>".
		        "</merchantAuthentication>" .
		        "<subscriptionId>" . $subscriptionId . "</subscriptionId>".
		        "</ARBCancelSubscriptionRequest>";

		//send the xml via curl
		$response = $this->send_request_via_curl($this->host,$this->path,$content);
		//if curl is unavilable you can try using fsockopen
		/*
		$response = send_request_via_fsockopen($host,$path,$content);
		*/

		//if the connection and send worked $response holds the return from Authorize.net
		if ($response)
		{
				/*
			a number of xml functions exist to parse xml results, but they may or may not be avilable on your system
			please explore using SimpleXML in php 5 or xml parsing functions using the expat library
			in php 4
			parse_return is a function that shows how you can parse though the xml return if these other options are not avilable to you
			*/
			list ($resultCode, $code, $text, $subscriptionId) =$this->parse_return($response);

			if($code == "Ok"){
				return TRUE;
			} else {
				return FALSE;
			}
		}
		else
		{
			return FALSE;
			echo "Transaction Failed. <br>";
		}

	}

	/* Authorize.net Functions */

	//function to send xml request via curl
	function send_request_via_curl($host,$path,$content)
	{
		$posturl = "https://" . $host . $path;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $posturl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		return $response;
	}

	//function to parse Authorize.net response
	function parse_return($content)
	{
		$refId = $this->substring_between($content,'<refId>','</refId>');
		$resultCode = $this->substring_between($content,'<resultCode>','</resultCode>');
		$code = $this->substring_between($content,'<code>','</code>');
		$text = $this->substring_between($content,'<text>','</text>');
		$subscriptionId = $this->substring_between($content,'<subscriptionId>','</subscriptionId>');
		return array ($refId, $resultCode, $code, $text, $subscriptionId);
	}

	//helper function for parsing response
	function substring_between($haystack,$start,$end)
	{
		if (strpos($haystack,$start) === false || strpos($haystack,$end) === false)
		{
			return false;
		}
		else
		{
			$start_position = strpos($haystack,$start)+strlen($start);
			$end_position = strpos($haystack,$end);
			return substr($haystack,$start_position,$end_position-$start_position);
		}
	}

}
?>