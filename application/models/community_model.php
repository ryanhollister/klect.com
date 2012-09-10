<?php
/**
 * This class contains methods to manipulate, fetch, and save items
 *
 */
class Community_model extends CI_Model {
	
	function getDummyCatalogItem() {
		require_once APPPATH . 'models/VOs/' . $this->phpsession->get ( 'current_domain' )->getTag () . 'VO' . EXT;
		$currVOname = $this->phpsession->get ( 'current_domain' )->getTag () . 'VO';
		$tempObj = new $currVOname ( -1, 0, "+ Add New", "", "", 0, "", "" );
		$tempObj->addPicture ( "add_new.jpg" );
		$tempObj->setDomain ( $this->phpsession->get ( 'current_domain' )->getId () );
		return $tempObj;
	}
}