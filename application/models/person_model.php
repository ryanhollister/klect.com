<?php

class Person_model extends CI_Model {

	function validate()
	{
		$this->load->library('hash');
		$this->db->select('person_id, username, password, email, first_name, last_name, img_size, sort_ord, def_domain, premium, admin, password, subId, addr1, addr2, city, state, zip, country, reg_date, last_login, num_logins');
		$this->db->where('username', $this->input->post('username'));
		$query = $this->db->get('person');
		$row = $query->result_array();
		
		if($query->num_rows == 1 && Hash::CheckPassword($this->input->post('password'), $row[0]['password']))
		{
			require_once APPPATH.'models/VOs/PersonVO'.EXT;
			$personVO = new PersonVO($row[0]['person_id']);
			$personVO->setFname($row[0]['first_name']);
			$personVO->setLname($row[0]['last_name']);
			$personVO->setEmail($row[0]['email']);
			$personVO->setUname($row[0]['username']);
			$personVO->setImg_size($row[0]['img_size']);
			$personVO->setSort_ord($row[0]['sort_ord']);
			$personVO->setDef_domain($row[0]['def_domain']);
			$personVO->setPremium($row[0]['premium']);
			$personVO->setAdmin($row[0]['admin']);
			$personVO->setPassword($row[0]['password']);
			$personVO->setSubId($row[0]['subId']);
			$personVO->setAddr1($row[0]['addr1']);
			$personVO->setAddr2($row[0]['addr2']);
			$personVO->setCity($row[0]['city']);
			$personVO->setState($row[0]['state']);
			$personVO->setZip($row[0]['zip']);
			$personVO->setCountry($row[0]['country']);
			$personVO->setReg_date($row[0]['reg_date']);
			$personVO->setLast_login($row[0]['last_login']);
			$personVO->setNum_logins($row[0]['num_logins'] + 1);
			return $personVO;
		}
		elseif($query->num_rows == 1 && $row[0]['password'] == md5($this->input->post('password')))
		{
			require_once APPPATH.'models/VOs/PersonVO'.EXT;
			$new_password = Hash::HashPassword($this->input->post('password'));
			$personVO = new PersonVO($row[0]['person_id']);
			$personVO->setFname($row[0]['first_name']);
			$personVO->setLname($row[0]['last_name']);
			$personVO->setEmail($row[0]['email']);
			$personVO->setUname($row[0]['username']);
			$personVO->setImg_size($row[0]['img_size']);
			$personVO->setSort_ord($row[0]['sort_ord']);
			$personVO->setDef_domain($row[0]['def_domain']);
			$personVO->setPremium($row[0]['premium']);
			$personVO->setAdmin($row[0]['admin']);
			$personVO->setPassword($new_password);
			$personVO->setSubId($row[0]['subId']);
			$personVO->setAddr1($row[0]['addr1']);
			$personVO->setAddr2($row[0]['addr2']);
			$personVO->setCity($row[0]['city']);
			$personVO->setState($row[0]['state']);
			$personVO->setZip($row[0]['zip']);
			$personVO->setCountry($row[0]['country']);
			$personVO->setReg_date($row[0]['reg_date']);
			$personVO->setLast_login($row[0]['last_login']);
			$personVO->setNum_logins($row[0]['num_logins'] + 1);
			$personVO->Save();
			return $personVO;
		}
		return false;
	}
	
	function create_member()
	{
		$this->load->library('hash');
		$inputEmail = $this->input->post('email');
		$inputUname = $this->input->post('uname');
		$inputFname = $this->input->post('fname');
		$inputLname = $this->input->post('lname');
		$inputPword = Hash::HashPassword($this->input->post('password'));
		$inputDefDomain = $this->input->post('collection_id');
		$this->db->select('person_id');
		$this->db->where('email', $inputEmail );
		$query = $this->db->get('person');
		
		if($query->num_rows != 0)
		{
			return "email";
		}
		
		$this->db->select('person_id');
		$this->db->where('username', $inputUname);
		$query = $this->db->get('person');
		
		if($query->num_rows != 0)
		{
			return "username";
		}
		
		/*
		 * var personVO PersonVO
		 */
		$personVO = new PersonVO();
		$personVO->setFname($inputFname);
		$personVO->setLname($inputLname);
		$personVO->setEmail($inputEmail);
		$personVO->setUname($inputUname);
		$personVO->setImg_size(DEF_IMG_SIZE);
		$personVO->setSort_ord(DEF_SORT_ORD);
		$personVO->setDef_domain($inputDefDomain);
		$personVO->setPassword($inputPword);
		$personVO->setSubId(null);
		$personVO->setReg_date(time());
		
		$this->load->library('email');
		
		$config['mailtype'] = 'html';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = FALSE;
		
		$this->email->initialize($config);

		$this->email->from('contact@klect.com', 'Klect.com');
		$this->email->to($inputEmail);
		
		$this->email->subject('Klect.com Registration');
		$this->email->message('For future reference your username is: '.$inputUname.'.<br/>
<br/>
You are now able to:<br/>
Inventory and build your own personal collection of your collectable.<br/>
Have more than one collection<br/>
See the value of your collection<br/>
See the count of items you have<br/>
Browse the marketplace and buy items<br/>
Browse the catalog to view and learn about individual items<br/>
Build a wishlist of the top 20 items you want to add to your collection<br/>
<br/>
<br/>
If you do not see an item, let us know. We are constantly adding data and growing our inventory!<br/>
Don\'t see an image? Send us yours and we will add it and if you have 5 that get used, we will send you some additional free time on the Marketplace!<br/>
<br/>
If you wish to upgrade to a subscription, you can post up to 20 items at a time for sale on the Marketplace. We send out instant notifications to users that have that item on their wishlist to help you sell them faster.<br/>
Subscriptions as low as $4 per month. Your first 30 days are free.<br/>
<br/>
Again, thank you for joining KLECT. We value your feedback.', 'Welcome to Klect.com!');
		
		$this->email->send();
		
		$personVO->Save();

		$this->db->where('person_id', $personVO->getPerson_id());
		$this->db->set('reg_date', 'NOW()', FALSE);
		$query = $this->db->update('person');
		
		return $personVO;
	}
	
	/**
	 * Generates a new random 8 character password, emails it to the user, and updates the DB
	 */
	function forgot_password()
	{
		$this->load->library('hash');
		$missingemail = $this->input->post('forgotpwemail');
		$this->db->select('email');
		$this->db->where('email', $missingemail);
		$query = $this->db->get('person');
		
		if($query->num_rows == 1)
		{
			$row = $query->result();
			$emailaddy = $row[0]->email;
			$this->db->where('email', $missingemail);
			$unique = $this->generatePassword(8);
			$new_password = Hash::HashPassword($unique);
			$data = array ('password' => $new_password);
			$query = $this->db->update('person', $data);
			
			if ($query)
			{
				$this->load->library('email');
				
				$config['mailtype'] = 'html';
				$config['charset'] = 'iso-8859-1';
				$config['wordwrap'] = FALSE;
				
				$this->email->initialize($config);

				$this->email->from('contact@klect.com', 'Klect.com');
				$this->email->to($emailaddy);
				
				$this->email->subject('Klect.com Password reset');
				$this->email->message("Your password has been reset to: ".$unique.".");
				
				$this->email->send(); 
			}
		}
		echo true;
		return;
	}
	
	function get_profile()
		{
			function initialize_value(&$value,$key)
			{
				if (!isset($value))
				{
					$value = '';
				}
			}

			$person_id = $this->phpsession->get('personVO')->getPerson_id();
			$this->db->select('first_name, last_name, email, img_size, sort_ord, premium, p.addr1 as ship_addr1, p.addr2 as ship_addr2, p.city as ship_city, p.state as ship_state, p.zip as ship_zip, p.country as ship_country, s.last_4, s.first as bill_first, s.last as bill_last, s.addr1 as bill_addr1, s.addr2 as bill_addr2, s.city as bill_city, s.state as bill_state, s.zip as bill_zip, s.country as bill_country, s.exp, s.type');
			$this->db->join('subscriptions s', 's.subscription_id=p.subId AND s.person_id=p.person_id', 'left');
			$this->db->where('p.person_id', $person_id);
			$query = $this->db->get('person p');
			$row = $query->result_array();
			$row = $row[0];
			array_walk($row,"initialize_value");
			if ($row['exp'] != '')
			{
				$exp = explode("-",$row['exp']);
				$row['bill_mo'] = $exp[1];
				$row['bill_yr'] = $exp[0];
			}
			else
			{
				$row['bill_mo'] = '';
				$row['bill_yr'] = '';
			}
			unset($row['exp']);
			$row['premium'] = $row['ship_zip'] && $row['ship_addr1'];
			return json_encode($row);
		}
	
	function edit_profile()
	{
		$this->load->library('hash');
		$person_id = $this->phpsession->get('personVO')->getPerson_id();
		
		$data = array(
						'email' => $this->input->post('email'),
						'first_name' => $this->input->post('fname'),
						'last_name' => $this->input->post('lname'),
						'img_size' => $this->input->post('img_size'),
						'sort_ord' => $this->input->post('sort_ord'),
						'addr1' => $this->input->post('ship_addr1'),
						'addr2' => $this->input->post('ship_addr2'),
						'city' => $this->input->post('ship_city'),
						'state' => $this->input->post('ship_state'),
						'zip' => $this->input->post('ship_zip'),
						'country' => $this->input->post('ship_country')
							);
		
		if ($this->input->post('opassword', TRUE)!= "")
		{
			$this->db->select('person_id, password');
			$this->db->where('person_id', $person_id);
			$query = $this->db->get('person');
			$row = $query->result_array();
			
			if($query->num_rows == 1 && Hash::CheckPassword($this->input->post('opassword'), $row[0]['password']))
			{
				$data['password'] = Hash::HashPassword($this->input->post('npassword'));
			}
			else
			{
				echo "Old password was not correct.";
			}
		}
		
		$this->db->where('person_id', $person_id);
		$query = $this->db->update('person', $data);
		
		if ($query)
		{
			$this->phpsession->get('personVO')->setFname($this->input->post('fname'));
			$this->phpsession->get('personVO')->setLname($this->input->post('lname'));
			$this->phpsession->get('personVO')->setEmail($this->input->post('email'));
			$this->phpsession->get('personVO')->setImg_size($this->input->post('img_size'));
			$this->phpsession->get('personVO')->setSort_ord($this->input->post('sort_ord'));
			$this->phpsession->get('personVO')->setAddr1($this->input->post('ship_addr1'));
			$this->phpsession->get('personVO')->setAddr2($this->input->post('ship_addr2'));
			$this->phpsession->get('personVO')->setCity($this->input->post('ship_city'));
			$this->phpsession->get('personVO')->setState($this->input->post('ship_state'));
			$this->phpsession->get('personVO')->setZip((int)$this->input->post('ship_zip'));
			$this->phpsession->get('personVO')->setCountry($this->input->post('ship_country'));
			echo true;
		}
		else
		{
			echo false;
		}
		
	}
	
	private function generatePassword($length=6,$level=2){
	
	   list($usec, $sec) = explode(' ', microtime());
	   srand((float) $sec + ((float) $usec * 100000));
	
	   $validchars[1] = "0123456789abcdfghjkmnpqrstvwxyz";
	   $validchars[2] = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	   $validchars[3] = "0123456789_!@#$%&*()-=+/abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_!@#$%&*()-=+/";
	
	   $password  = "";
	   $counter   = 0;
	
	   while ($counter < $length) {
	     $actChar = substr($validchars[$level], rand(0, strlen($validchars[$level])-1), 1);
	
	     // All character must be different
	     if (!strstr($password, $actChar)) {
	        $password .= $actChar;
	        $counter++;
	     }
	   }
	
	   return $password;
	
	}
	
	public function getEmailfromId($person_id)
	{
		$this->db->select('email');
		$this->db->where('person_id', $person_id);
		$query = $this->db->get('person');
		
		if($query->num_rows == 1)
		{
			$row = $query->result();
			$emailaddy = $row[0]->email;
		}
		else
		{
			return '';
		}
	}
	
	public function trackLogin($id)
	{
		$this->db->where('person_id', $id);
		$this->db->set('num_logins', 'num_logins + 1', FALSE);
		$this->db->set('last_login', 'NOW()', FALSE);
		$query = $this->db->update('person');
	}
	
	public function get_member_rating($person_id = false)
	{
		if ($person_id == false) $person_id = $this->phpsession->get('personVO')->getPerson_id();
		
		$this->db->select("buyer_rating");
		$this->db->where('s.buyerId', $person_id);
		
		$this->db->where('comp_date IS NOT NULL');
		$this->db->where('resolved', '1');
		$this->db->where('s.buyer_rating !=', '0');
				
		$query = $this->db->get('sales s');
		$i = 0;
		$sum = 0;
		
		foreach ($query->result() as $row)
		{
			$sum += $row->buyer_rating;
			$i++;
		}
		
		
		
		$this->db->select("seller_rating");
		$this->db->where('s.sellerId', $person_id);
		
		$this->db->where('comp_date IS NOT NULL');
		$this->db->where('resolved', '1');
		$this->db->where('s.seller_rating !=', '0');
				
		$query = $this->db->get('sales s');
		
		$row = $query->result();
		
		foreach ($query->result() as $row)
		{
			$sum += $row->seller_rating;
			$i++;
		}
		
		if ($i > 0)
		{
			$num = $sum/$i;
			if($num >= ($half = ($ceil = ceil($num))- 0.5) + 0.25) return $ceil;
			else if($num < $half - 0.25) return floor($num);
			else return $half;
		}
		else
		{
			return 0;
		}
		
	}
}