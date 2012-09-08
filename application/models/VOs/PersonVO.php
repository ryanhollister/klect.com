<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class PersonVO {
	
	public $person_id;
	public $first_name;
	public $last_name;
	public $email;
	public $username;
	public $img_size;
	public $sort_ord;
	public $def_domain;
	public $password;
	public $premium;
	public $admin;
	public $subId;
	public $addr1;
	public $addr2;
	public $city;
	public $state;
	public $zip;
	public $country;
	public $reg_date;
	public $last_login;
	public $num_logins;
	
	function __construct($inputPerson_id = false) 
	{
		$this->person_id = $inputPerson_id;
		$this->img_size = DEF_IMG_SIZE;
		$this->sort_ord = DEF_SORT_ORD;
		$this->premium = 0;
		$this->admin = 0;
		$this->subId = 0;
		$this->last_login = 0;
		$this->num_logins = 0;
	}
	
	/**
	 * @return the $person_id
	 */
	public function getPerson_id() {
		return $this->person_id;
	}

	/**
	 * @param $person_id the $person_id to set
	 */
	public function setPerson_id($person_id) {
		$this->person_id = $person_id;
	}

	/**
	 * @return the $fname
	 */
	public function getFname() {
		return $this->first_name;
	}

	/**
	 * @return the $lname
	 */
	public function getLname() {
		return $this->last_name;
	}

	/**
	 * @return the $email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @return the $uname
	 */
	public function getUname() {
		return $this->username;
	}

	/**
	 * @return the $img_size
	 */
	public function getImg_size() {
		return $this->img_size;
	}

	/**
	 * @return the $sort_ord
	 */
	public function getSort_ord() {
		return $this->sort_ord;
	}

	/**
	 * @return the $def_domain
	 */
	public function getDef_domain() {
		return $this->def_domain;
	}

	/**
	 * @return the $password
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @return the $premium
	 */
	public function getPremium() {
		return (($this->getAddr1() != '') && ($this->getZip() != ''));
	}

	/**
	 * @return the $admin
	 */
	public function getAdmin() {
		return $this->admin;
	}

	/**
	 * @return the $subId
	 */
	public function getSubId() {
		return $this->subId;
	}
	
	/**
	 * @return the $add1
	 */
	public function getAddr1() {
		return $this->addr1;
	}

	/**
	 * @return the $add2
	 */
	public function getAddr2() {
		return $this->addr2;
	}

	/**
	 * @return the $city
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 * @return the $state
	 */
	public function getState() {
		return $this->state;
	}

	/**
	 * @return the $zip
	 */
	public function getZip() {
		return $this->zip;
	}
	
	/**
	 * @return the $country
	 */
	public function getCountry() {
		return $this->country;
	}

	/**
	 * @return the $reg_date
	 */
	public function getReg_date() {
		return $this->reg_date;
	}

	/**
	 * @return the $last_login
	 */
	public function getLast_login() {
		return $this->last_login;
	}

	/**
	 * @return the $num_logins
	 */
	public function getNum_logins() {
		return $this->num_logins;
	}

	/**
	 * @param $reg_date the $reg_date to set
	 */
	public function setReg_date($reg_date) {
		$this->reg_date = $reg_date;
	}

	/**
	 * @param $last_login the $last_login to set
	 */
	public function setLast_login($last_login) {
		$this->last_login = $last_login;
	}

	/**
	 * @param $num_logins the $num_logins to set
	 */
	public function setNum_logins($num_logins) {
		$this->num_logins = $num_logins;
	}

	/**
	 * @param $country the $country to set
	 */
	public function setCountry($country) {
		$this->country = $country;
	}

	/**
	 * @param $add1 the $add1 to set
	 */
	public function setAddr1($add1) {
		$this->addr1 = $add1;
	}

	/**
	 * @param $add2 the $add2 to set
	 */
	public function setAddr2($addr2) {
		$this->addr2 = $addr2;
	}

	/**
	 * @param $city the $city to set
	 */
	public function setCity($city) {
		$this->city = $city;
	}

	/**
	 * @param $state the $state to set
	 */
	public function setState($state) {
		$this->state = $state;
	}

	/**
	 * @param $zip the $zip to set
	 */
	public function setZip($zip) {
		$this->zip = $zip;
	}

	/**
	 * @param $subId the $subId to set
	 */
	public function setSubId($subId) {
		$this->subId = $subId;
	}

	/**
	 * @param $premium the $premium to set
	 */
	public function setPremium($premium) {
		$this->premium = $premium;
	}

	/**
	 * @param $admin the $admin to set
	 */
	public function setAdmin($admin) {
		$this->admin = $admin;
	}

	/**
	 * @param $password the $password to set
	 */
	public function setPassword($password) {
		$this->password = $password;
	}

	/**
	 * @param $fname the $fname to set
	 */
	public function setFname($fname) {
		$this->first_name = $fname;
	}

	/**
	 * @param $lname the $lname to set
	 */
	public function setLname($lname) {
		$this->last_name = $lname;
	}

	/**
	 * @param $email the $email to set
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * @param $uname the $uname to set
	 */
	public function setUname($uname) {
		$this->username = $uname;
	}

	/**
	 * @param $img_size the $img_size to set
	 */
	public function setImg_size($img_size) {
		if ($img_size == 'img_small' || $img_size == 'img_large')
		{
			$this->img_size = $img_size;
		}
		else
		{
			$this->img_size = DEF_IMG_SIZE;
		}
	}

	/**
	 * @param $sort_ord the $sort_ord to set
	 */
	public function setSort_ord($sort_ord) {
		if ($sort_ord == 'sort_name' || $sort_ord == 'sort_added' || $sort_ord == 'sort_date')
		{
			$this->sort_ord = $sort_ord;
		}
		else
		{
			$this->sort_ord = DEF_SORT_ORD;
		}
	}

	/**
	 * @param $def_domain the $def_domain to set
	 */
	public function setDef_domain($def_domain) {
		$this->def_domain = $def_domain;
	}
	
	public function Save() {
		
		$CI =& get_instance();
		
		if ($this->person_id != false)
		{
			//Update
			$CI->db->where('person_id', $this->person_id);
			$result = $CI->db->update('person', $this );
			return $result;
		}	
		else
		{
			//Insert
			$retVal = $CI->db->insert('person', $this);
			$this->person_id = $CI->db->insert_id();
			return $retVal;
		}
	}
	
}

?>