<?php
/**
 * This class contains methods to manipulate, fetch, and save items
 *
 */
class Item_model extends CI_Model {
	
	/**
	 * Get all the items that the current person has in their collection for the current domain.
	 * 
	 * $owned_item_ids will restrict the results to a certain list if owned_item_ids
	 * 
	 * $offset is used for pagination
	 * 
	 * $filter_mp_visible will restrict the results to only items whose oi.mp_visible = true
	 * 
	 * returns an array of Current Domain ItemVOs
	 * 
	 * returns false if no items exist in the persons' collection
	 */
	function getPersonsItems($owned_item_ids = false, $offset = false, $filter_mp_visible = false) {
		$this->db->select ( 'ia.value as date, oi.*, i.name, i.msrp, i.item_id, p.filename' );
		$this->db->where ( 'person_id', $this->phpsession->get ( 'personVO' )->getPerson_id () );
		$this->db->where ( 'domain_id', $this->phpsession->get ( 'current_domain' )->getId () );
		$this->db->where ( 'i.approved', '1');
		$this->db->join ( 'item i', 'i.item_id = oi.item_item_id' );
		$this->db->join ( 'pictures p', 'i.item_id=p.item_id AND p.order=0', 'left' );
		$this->db->join ( 'item_attribute ia', 'ia.item_id=i.item_id AND ia.domain_attribute_id=1', 'left' );
		
		if (is_array ( $owned_item_ids )) {
			$this->db->where ( 'oi.owned_item_id IN (' . implode ( ',', $owned_item_ids ) . ')' );
		}
		
		if ($filter_mp_visible) {
			$this->db->where ( 'oi.mp_visible', '1' );
		}
		
		if ($offset !== false) {
			$this->pagination->total_rows = $this->db->count_all_results ( 'owned_item oi', false );
			
			if ($offset >= $this->pagination->total_rows) {
				$offset = 0;
			}
			
			$this->db->limit ( 75, $offset );
		}
		$this->db->order_by ( constant ( $this->phpsession->get ( 'personVO' )->getSort_ord () ) );
		
		$query = $this->db->get ( 'owned_item oi' );
		
		$retVal = array ();
		
		if ($query->num_rows > 0) {
			require_once APPPATH . 'models/VOs/' . $this->phpsession->get ( 'current_domain' )->getTag () . 'VO' . EXT;
			$currVOname = $this->phpsession->get ( 'current_domain' )->getTag () . 'VO';
			foreach ( $query->result () as $row ) {
				$tempObj = new $currVOname ( $row->item_id, $row->msrp, $row->name, "", "", $row->purchase_price, "", $row->description );
				$tempObj->setOwned_item_id ( $row->owned_item_id );
				$tempObj->setCondition ( $row->condition );
				$tempObj->setItem_item_id ( $row->item_item_id );
				$tempObj->setDate_acquired ( $row->date_acquired );
				$tempObj->setCondition ( $row->condition );
				$tempObj->setQty ( $row->qty );
				$tempObj->setPurchase_price ( $row->purchase_price );
				$tempObj->setDescription ( $row->description );
				$tempObj->setPerson_id ( $row->person_id );
				$tempObj->setMp_visible ( $row->mp_visible );
				$tempObj->setCustImg ( $row->custImg );
				$tempObj->addPicture ( $row->filename );
				$tempObj->setDomain ( $this->phpsession->get ( 'current_domain' )->getTag () );
				$retVal [$row->owned_item_id] = $tempObj;
			}
			return $retVal;
		}
		return array ();
	}
	
	/**
	 * Get a collection of ItemVOs for the requested owned items.
	 * 
	 * returns an array of Current Domain ItemVOs
	 * 
	 */
	function getOwnedItems($item_ids, $inc_sales = false, $offset = false, $owned_items = false) {
		if (is_array ( $item_ids ) && count ( $item_ids ) > 0 && ! $owned_items) {
			$this->db->where ( 'i.item_id IN (' . implode ( ',', $item_ids ) . ')' );
		} elseif (is_array ( $item_ids ) && count ( $item_ids ) > 0 && $owned_items) {
			$this->db->where ( 'oi.owned_item_id IN (' . implode ( ',', $item_ids ) . ')' );
		} else {
			return;
		}
		
		$this->db->select ( 'ia.value as date,oi.owned_item_id as id, oi.*, i.name, i.msrp, i.item_id, p.filename' );
		$this->db->where ( 'i.domain_id', $this->phpsession->get ( 'current_domain' )->getId () );
		$this->db->where ( 'i.approved', '1');
		$this->db->join ( 'item i', 'i.item_id = oi.item_item_id' );
		$this->db->join ( 'item_' . $this->phpsession->get ( 'current_domain' )->getTag (), 'i.item_id=item_' . $this->phpsession->get ( 'current_domain' )->getTag () . '.item_item_id', 'left' );
		$this->db->join ( 'pictures p', 'i.item_id=p.item_id AND p.order=0', 'left' );
		$this->db->join ( 'item_attribute ia', 'ia.item_id=i.item_id AND ia.domain_attribute_id=1', 'left' );
		
		if ($inc_sales == true) {
			$this->db->select ( 'ia.value as date, oi.*, s.saleId as id, i.name, i.msrp, oi.purchase_price, i.item_id, p.filename' );
			$this->db->join ( 'sales s', 's.owned_item_id=oi.owned_item_id' );
			$this->db->where ( 'comp_date IS NULL' );
			$this->db->where ( 'buyerId IS NULL' );
		}
		
		if ($offset !== false) {
			$this->pagination->total_rows = $this->db->count_all_results ( 'owned_item oi', false );
			if ($offset >= $this->pagination->total_rows) {
				$offset = 0;
			}
			$this->db->limit ( 75, $offset );
		}
		
		$this->db->order_by ( constant ( $this->phpsession->get ( 'personVO' )->getSort_ord () ) );
		$query = $this->db->get ( 'owned_item oi' );
		
		$retVal = array ();
		
		if ($query->num_rows > 0) {
			require_once APPPATH . 'models/VOs/' . $this->phpsession->get ( 'current_domain' )->getTag () . 'VO' . EXT;
			$currVOname = $this->phpsession->get ( 'current_domain' )->getTag () . 'VO';
			foreach ( $query->result () as $row ) {
				/* @var $tempObj OwnedItemVO */
				$tempObj = new $currVOname ( $row->item_id, $row->msrp, $row->name, "", "", $row->purchase_price, "", $row->description );
				$tempObj->setOwned_item_id ( $row->owned_item_id );
				$tempObj->setCondition ( $row->condition );
				$tempObj->setItem_item_id ( $row->item_item_id );
				$tempObj->setDate_acquired ( $row->date_acquired );
				$tempObj->setCondition ( $row->condition );
				$tempObj->setQty ( $row->qty );
				$tempObj->setPurchase_price ( $row->purchase_price );
				$tempObj->setDescription ( $row->description );
				$tempObj->setPerson_id ( $row->person_id );
				$tempObj->setMp_visible ( $row->mp_visible );
				$tempObj->setCustImg ( $row->custImg );
				$tempObj->addPicture ( $row->filename );
				$tempObj->setDomain ( $this->phpsession->get ( 'current_domain' )->getTag () );
				$retVal [$row->id] = $tempObj;
			}
			return $retVal;
		}
		return array ();
	}
	
	/**
	 * Gets the total value of the current users' items for the specified domainId (DOMAIN table)
	 * 
	 * @param int $domainid
	 */
	
	function getPersonsValue($domainid, $offset = false) {
		$this->db->select ( 'SUM(value) as value' );
		$this->db->join ( 'owned_item oi', 'oi.item_item_id=iv.item_id' );
		$this->db->join ( 'item i', 'oi.item_item_id=i.item_id' );
		$this->db->where ( 'oi.person_id', $this->phpsession->get ( 'personVO' )->getPerson_id () );
		$this->db->where ( 'i.domain_id', $domainid );
		$this->db->where ( '`iv`.`level`', '`oi`.`condition`', FALSE );
		$this->db->where ( 'i.approved', '1');
		
		$query = $this->db->get ( 'item_value iv' );
		$row = $query->row ();
		if ($row->value == false) {
			$row->value = 0.00;
		}
		return $row->value;
	}
	
	/**
	 * Returns an array of ItemVOs for the current domain that the current user does not have in their collection. 
	 * It will return only the specified item ids if "item_ids" is passed.
	 * 
	 * @param array $item_ids
	 */
	function getUnownedItems($item_ids = false, $offset = false) {
		$person_id = $this->phpsession->get ( 'personVO' )->getPerson_id ();
		if (! is_object ( $this->phpsession->get ( 'current_domain' ) )) {
			throw new Exception ( 'UserData "curr_domain" is not initialized properly' );
		}
		
		$this->db->select ( 'pictures.filename, i.item_id, i.name, i.catalog_description, i.msrp, i.manufacturer_date, manufacturer.name as manName' );
		$this->db->join ( 'manufacturer', 'manufacturer.manufacturer_id=i.manufacturer_id' );
		$this->db->join ( 'pictures', 'i.item_id=pictures.item_id AND pictures.order=0', 'left' );
		$this->db->where ( 'i.domain_id', $this->phpsession->get ( 'current_domain' )->getId () );
		$this->db->where ( 'i.item_id NOT IN (select item_item_id FROM owned_item WHERE person_id=' . $person_id . ')' );
		$this->db->where ( 'i.approved', '1');
		
		if (is_array ( $item_ids )) {
			$this->db->where ( 'i.item_id IN (' . implode ( ',', $item_ids ) . ')' );
		}
		
		if ($offset !== false) {
			$this->pagination->total_rows = $this->db->count_all_results ( 'item i', false );
			if ($offset >= $this->pagination->total_rows) {
				$offset = 0;
			}
			$this->db->limit ( 75, $offset );
		}
		
		$query = $this->db->get ( 'item i' );
		
		$retVal = array ();
		
		if ($query->num_rows > 0) {
			require_once APPPATH . 'models/VOs/' . $this->phpsession->get ( 'current_domain' )->getTag () . 'VO' . EXT;
			$currVOname = $this->phpsession->get ( 'current_domain' )->getTag () . 'VO';
			foreach ( $query->result () as $row ) {
				$tempObj = new $currVOname ( $row->item_id, $row->msrp, $row->name, "", $row->manName, "", "", $row->catalog_description );
				$tempObj->addPicture ( $row->filename );
				$tempObj->setDomain ( $this->phpsession->get ( 'current_domain' )->getTag () );
				$retVal [] = $tempObj;
			}
			return $retVal;
		}
	
	}
	
	/**
	 * Returns an array of ItemVOs for the current domain. 
	 * It will return only the specified item ids if "item_ids" is passed.
	 * 
	 * @param array $item_ids
	 * 
	 */
	function getItems($item_ids = false, $owned_items = false, $offset = false) {
		if (! is_object ( $this->phpsession->get ( 'current_domain' ) )) {
			throw new Exception ( 'UserData "curr_domain" is not initialized properly' );
		}
		
		$this->db->select ( 'pictures.filename, i.item_id, i.name, i.catalog_description, i.msrp, i.manufacturer_date, manufacturer.name as manName' );
		$this->db->join ( 'manufacturer', 'manufacturer.manufacturer_id=i.manufacturer_id' );
		$this->db->join ( 'pictures', 'i.item_id=pictures.item_id AND pictures.order=0', 'left' );
		$this->db->where ( 'i.domain_id', $this->phpsession->get ( 'current_domain' )->getId () );
		$this->db->where ( 'i.approved', '1');
		
		if (is_array ( $item_ids ) && count ( $item_ids ) && ! $owned_items) {
			$this->db->where ( 'i.item_id IN (' . implode ( ',', $item_ids ) . ')' );
		} elseif (is_array ( $item_ids ) && count ( $item_ids ) && $owned_items) {
			$this->db->join ( 'owned_item oi', 'oi.item_item_id=i.item_id' );
			$this->db->where ( 'oi.owned_item_id IN (' . implode ( ',', $item_ids ) . ')' );
		}
		
		if ($offset !== false) {
			$this->pagination->total_rows = $this->db->count_all_results ( 'item i', false );
			if ($offset >= $this->pagination->total_rows) {
				$offset = 0;
			}
			$this->db->limit ( 75, $offset );
		}
		
		$this->db->order_by ( 'i.item_id ASC' );
		
		$query = $this->db->get ( 'item i' );
		
		$retVal = array ();
		
		if ($query->num_rows > 0) {
			require_once APPPATH . 'models/VOs/' . $this->phpsession->get ( 'current_domain' )->getTag () . 'VO' . EXT;
			$currVOname = $this->phpsession->get ( 'current_domain' )->getTag () . 'VO';
			foreach ( $query->result () as $row ) {
				$tempObj = new $currVOname ( $row->item_id, $row->msrp, $row->name, "", $row->manName, "", "", $row->catalog_description );
				$tempObj->addPicture ( $row->filename );
				$tempObj->setDomain ( $this->phpsession->get ( 'current_domain' )->getTag () );
				$retVal [] = $tempObj;
			}
			return $retVal;
		}
	}
	
	/**
	 * Removes the posted owned_item_id from the users' collection
	 */
	function remove_owned_item() {
		$owned_item_remove = array ('owned_item_id' => ( int ) $this->input->post ( 'owned_item_id' ), 'person_id' => $this->phpsession->get ( 'personVO' )->getPerson_id () );
		$remove = $this->db->delete ( 'owned_item', $owned_item_remove );
		return ( int ) $this->input->post ( 'owned_item_id' );
	}
	
	/**
	 * Creates an owned_item from the posted data. Inserts the person details of that item
	 * into the owned_item table.
	 */
	function create_owned_item() {
		$date = "";
		if ($this->input->post ( 'datepicker' ) != "") {
			$dates = explode ( '/', $this->input->post ( 'datepicker' ) );
			$m = $dates [0];
			$d = $dates [1];
			$y = $dates [2];
			$date = date ( 'Y-m-d', mktime ( 0, 0, 0, ( int ) $m, ( int ) $d, ( int ) $y ) );
		}
		
		$ids = explode ( ",", $this->input->post ( 'owned_item_id' ) );
		$new_owned_item_insert = array ('date_acquired' => $date, 'description' => $this->input->post ( 'description' ), 'condition' => ( int ) $this->input->post ( 'condition' ), 'purchase_price' => $this->input->post ( 'price' ), 'person_id' => ( int ) $this->phpsession->get ( 'personVO' )->getPerson_id (), 'mp_visible' => ! ( bool ) $this->input->post ( 'mp_visible' ) );
		
		foreach ( $ids as $id ) {
			$new_owned_item_insert ['item_item_id'] = $id;
			$insert = $this->db->insert ( 'owned_item', $new_owned_item_insert );
		}
		return $insert;
	}
	
	/**
	 * Handle the XHR upload request and return the results 
	 * 
	 * @param string $filename
	 */
	function uploadcustomimage($filename, $owned_item_id) {
		require_once APPPATH . 'libraries/FileUploader' . EXT;
		/* @var $oiVO OwnedItemVO */
		$oiVO = $this->getOwnedItems ( array ($owned_item_id ), false, false, true );
		$oiVO = current ( $oiVO );
		
		if ($oiVO->getPerson_id () != $this->phpsession->get ( 'personVO' )->getPerson_id ())
			return false;
		
		$allowedExtensions = array ("jpeg", "bmp", "jpg", "png", "gif" );
		// max file size in bytes
		$sizeLimit = 6 * 1024 * 1024;
		
		$uploader = new FileUploader ( $allowedExtensions, $sizeLimit );
		$result = $uploader->handleUpload ( './img/' . $this->phpsession->get ( 'current_domain' )->getTag () . '/uploads/', FALSE, $filename );
		// to pass data through iframe you will need to encode all html tags
		//echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
		

		$filename = $result ['filename'];
		
		$this->load->library ( 'image_lib' );
		
		$config ['image_library'] = 'gd2';
		$config ['source_image'] = './img/' . $this->phpsession->get ( 'current_domain' )->getTag () . '/uploads/' . $filename;
		$config ['new_image'] = './img/' . $this->phpsession->get ( 'current_domain' )->getTag () . '/customs/' . $filename;
		
		//initialize first to get the dimensions
		$this->image_lib->initialize ( $config );
		$config ['width'] = "200";
		$config ['maintain_ratio'] = TRUE;
		
		//load width and ratio setting to resize image to 200px wide
		$this->image_lib->initialize ( $config );
		$this->image_lib->resize ();
		$this->image_lib->clear ();
		
		$this->image_lib->initialize ( $config );
		
		$config ['image_library'] = 'gd2';
		$config ['source_image'] = './img/' . $this->phpsession->get ( 'current_domain' )->getTag () . '/customs/' . $filename;
		$config ['new_image'] = './img/' . $this->phpsession->get ( 'current_domain' )->getTag () . '/thumbs/150/customs/' . $filename;
		
		//initialize first to get the dimensions
		$this->image_lib->initialize ( $config );
		$config ['width'] = "150";
		$config ['maintain_ratio'] = TRUE;
		
		//load width and ratio setting to resize image to 200px wide
		$this->image_lib->initialize ( $config );
		$this->image_lib->resize ();
		$this->image_lib->clear ();
		
		$config ['image_library'] = 'gd2';
		$config ['source_image'] = './img/' . $this->phpsession->get ( 'current_domain' )->getTag () . '/customs/' . $filename;
		$config ['new_image'] = './img/' . $this->phpsession->get ( 'current_domain' )->getTag () . '/thumbs/100/customs/' . $filename;
		
		//initialize first to get the dimensions
		$this->image_lib->initialize ( $config );
		$config ['width'] = "100";
		$config ['maintain_ratio'] = TRUE;
		
		//load width and ratio setting to resize image to 200px wide
		$this->image_lib->initialize ( $config );
		
		if (! $this->image_lib->resize ()) {
			echo $this->image_lib->display_errors ();
			return;
		} else {
			//save custom image filename and delete original uploaded pic
			$old_img = $oiVO->getcustImg ();
			$oiVO->setcustImg ( $filename );
			$oiVO->Save ();
			
			if ($old_img != 'stock') {
				@unlink ( './img/' . $this->phpsession->get ( 'current_domain' )->getTag () . '/customs/' . $old_img );
			}
			unlink ( './img/' . $this->phpsession->get ( 'current_domain' )->getTag () . '/uploads/' . $filename );
			echo json_encode ( $result );
		}
	}
	
	public function remove_custom_image() {
		$owned_item_id = ( int ) $this->input->post ( 'owned_item_id' );
		
		/* @var $oiVO OwnedItemVO */
		$oiVO = $this->getOwnedItems ( array ($owned_item_id ), false, false, true );
		$oiVO = current ( $oiVO );
		
		@unlink ( './img/' . $this->phpsession->get ( 'current_domain' )->getTag () . '/customs/' . $oiVO->getCustImg () );
		
		$oiVO->setCustImg ( 'stock' );
		
		echo json_encode ( array ('success' => $oiVO->Save () ) );
	}
	
	/**
	 * Updates the personal details of the owned item.
	 */
	public function update_owned_item() {
		$dates = explode ( '/', $this->input->post ( 'datepicker' ) );
		$m = $dates [0];
		$d = $dates [1];
		$y = $dates [2];
		
		$date = date ( 'Y-m-d', mktime ( 0, 0, 0, ( int ) $m, ( int ) $d, ( int ) $y ) );
		$data = array ('description' => $this->input->post ( 'description' ), 'date_acquired' => $date, 'purchase_price' => $this->input->post ( 'price' ), 'condition' => ( int ) $this->input->post ( 'owned_condition' ), 'mp_visible' => ! ( bool ) $this->input->post ( 'mp_visible' ) );
		
		$this->db->where ( 'owned_item_id', $this->input->post ( 'owned_item_id' ) );
		$this->db->where ( 'person_id', $this->phpsession->get ( 'personVO' )->getPerson_id () );
		$this->db->update ( 'owned_item', $data );
		
		return true;
	}
	
	/**
	 * Returns only the personal details of the owned item.
	 */
	public function get_oi_details() {
		$owned_item_id = ( int ) $this->input->post ( 'owned_item_id' );
		$this->db->select ( 'i.name, oi.owned_item_id, oi.description, oi.purchase_price, oi.date_acquired, oi.condition, oi.mp_visible' );
		$this->db->join ( 'item i', 'oi.item_item_id=i.item_id' );
		$this->db->where ( 'oi.owned_item_id', $owned_item_id );
		$this->db->where ( 'i.domain_id', $this->phpsession->get ( 'current_domain' )->getId () );
		$this->db->where ( 'i.approved', '1');
		$query = $this->db->get ( 'owned_item oi' );
		$row = $query->row ();
		$row->date_acquired = date ( "m/d/Y", strtotime ( $row->date_acquired ) );
		return json_encode ( $row );
	}
	
	/**
	 * Returns only the KLECT catalog details of the item.
	 */
	public function get_catalog_details() {
		$item_id = ( int ) $this->input->post ( 'item_id' );
		$this->db->select ( 'm.name as manufacturer, i.name, i.catalog_description, p.filename, i.general_attribute, i.item_id' );
		$this->db->join ( 'manufacturer m', 'm.manufacturer_id=i.manufacturer_id' );
		$this->db->join ( 'pictures p', 'p.item_id=i.item_id', 'left' );
		$this->db->where ( 'i.item_id', $item_id );
		$this->db->where ( 'i.approved', '1');
		$query = $this->db->get ( 'item i' );
		$row = $query->row ();
		
		// Get the items value based on the entered condition
		$attrArray = array ();
		$this->db->select ( 'iv.value,vl.label' );
		$this->db->join ( 'value_label vl', 'iv.level=vl.level', 'left' );
		$this->db->where ( 'iv.item_id', $item_id );
		$query = $this->db->get ( 'item_value iv' );
		
		if ($query->num_rows > 0) {
			foreach ( $query->result () as $row2 ) {
				$attrArray ['value'] = $row2->value;
				$attrArray ['label'] = $row2->label;
			}
		}
		
		// Add the item's value based on condition to the previous result set.
		$obj_merged = ( object ) array_merge ( ( array ) $row, ( array ) $attrArray );
		
		// Get the domain details of the item.
		$attrArray2 = array ();
		$this->db->select ( 'da.text, ia.value, da.domain_attribute_id' );
		$this->db->join ( 'domain_attribute da', 'da.domain_attribute_id=ia.domain_attribute_id' );
		$this->db->where ( 'ia.item_id', $item_id );
		$query = $this->db->get ( 'item_attribute ia' );
		$attrStr = '';
		foreach ( $query->result () as $row3 ) {
			$attrStr .= '<br/>' . $row3->text . ': <div id="catalog_attribute_' . $row3->domain_attribute_id . '" class="catalog_div" style="text-transform:capitalize">' . $row3->value . '</div>';
		}
		$obj_merged->item_attributes = $attrStr;
		
		return json_encode ( $obj_merged );
	}
	
	/**
	 * Returns the catalog details and presonal details of the owned item.
	 */
	public function get_owned_catalog_details() {
		$owned_item_id = ( int ) $this->input->post ( 'owned_item_id' );
		$sql = "SELECT oi.owned_item_id, m.name as manufacturer, i.name, i.catalog_description, p.filename, oi.description, oi.purchase_price, oi.date_acquired, oi.condition, oi.custImg, i.general_attribute, i.item_id FROM owned_item oi JOIN item i ON oi.item_item_id=i.item_id JOIN manufacturer m ON m.manufacturer_id=i.manufacturer_id LEFT JOIN pictures p ON p.item_id=i.item_id WHERE oi.owned_item_id=" . $this->db->escape ( $owned_item_id );
		$query = $this->db->query ( $sql );
		$row = $query->row ();
		$row->date_acquired = date ( "m/d/Y", strtotime ( $row->date_acquired ) );
		$row->purchase_price = '$' . money_format ( '%i', $row->purchase_price );
		
		$attrArray = array ();
		$sql = "SELECT iv.value,vl.label FROM item_value iv LEFT JOIN value_label vl ON $row->condition=vl.level WHERE iv.item_id=$row->item_id AND iv.level=$row->condition AND vl.domain_id=" . $this->phpsession->get ( 'current_domain' )->getId () . ";";
		$query = $this->db->query ( $sql );
		
		// Were any values found?
		if ($query->num_rows > 0) {
			foreach ( $query->result () as $row2 ) {
				$attrArray ['value'] = $row2->value;
				$attrArray ['label'] = $row2->label;
			}
		} // If not, return an "Unknown Value"
else {
			$sql = "SELECT vl.label FROM value_label vl WHERE vl.level=$row->condition AND vl.domain_id=" . $this->phpsession->get ( 'current_domain' )->getId () . ";";
			$query = $this->db->query ( $sql );
			
			$row2 = $query->row ();
			
			$attrArray ['value'] = 'Unknown Value';
			$attrArray ['label'] = $row2->label;
		}
		$obj_merged = ( object ) array_merge ( ( array ) $row, ( array ) $attrArray );
		
		$attrArray2 = array ();
		$sql = "SELECT da.text, ia.value, da.domain_attribute_id FROM domain_attribute da JOIN item_attribute ia ON ia.domain_attribute_id=da.domain_attribute_id JOIN owned_item oi ON oi.item_item_id=ia.item_id JOIN item i ON i.item_id=oi.item_item_id WHERE oi.owned_item_id=" . $this->db->escape ( $owned_item_id );
		$query = $this->db->query ( $sql );
		$attrStr = '';
		foreach ( $query->result () as $row3 ) {
			$attrStr .= '<br/>' . $row3->text . ': <div id="catalog_attribute_' . $row3->domain_attribute_id . '" class="catalog_div" style="text-transform:capitalize">' . $row3->value . '</div>';
		}
		$obj_merged->item_attributes = $attrStr;
		
		return json_encode ( $obj_merged );
	}
	
	/**
	 * Adds item to the current user's wishlist
	 */
	function addtowishlist() {
		$wishlist = $this->input->post ( 'wishlist_cnt' );
		$person_id = $this->phpsession->get ( 'personVO' )->getPerson_id ();
		$this->db->where ( 'person_id', $person_id );
		$this->db->where ( 'domain_id', $this->phpsession->get ( 'current_domain' )->getId () );
		$this->db->delete ( 'wish_list' );
		if ($wishlist != '') {
			$wishlist = explode ( "|", $wishlist );
			$i = 0;
			
			foreach ( $wishlist as $item ) {
				$data = array ('item_id' => ( int ) $item, 'person_id' => ( int ) $person_id, 'order' => $i, 'domain_id' => $this->phpsession->get ( 'current_domain' )->getId () );
				$this->db->insert ( 'wish_list', $data );
				$i ++;
			}
		}
	}
	
	/**
	 * Sends the current user's wishlist to the user's email address
	 */
	function emailwishlist() {
		$wishlist_array = $this->item_model->getwishlist ();
		$list = $wishlist_array ['names'];
		$emailaddy = $this->phpsession->get ( 'personVO' )->getEmail ();
		
		$message = "Your wishlist on Klect.com:<br/><br/>";
		
		$i = 1;
		
		foreach ( $list as $name ) {
			$message .= $i . ". " . $name . "<br/>";
			$i ++;
		}
		
		$this->load->library ( 'email' );
		
		$config ['mailtype'] = 'html';
		$config ['charset'] = 'iso-8859-1';
		$config ['wordwrap'] = FALSE;
		
		$this->email->initialize ( $config );
		
		$this->email->from ( 'contact@klect.com', 'Klect.com' );
		$this->email->to ( $emailaddy );
		
		$this->email->subject ( 'Your KLECT Wish List' );
		
		$this->email->message ( $message, 'Your KLECT Wishlist' );
		
		$this->email->send ();
	}
	
	/**
	 * Returns the wishlist of the current user.
	 */
	function getwishlist() {
		$item_vos = array ();
		$person_id = $this->phpsession->get ( 'personVO' )->getPerson_id ();
		
		$this->db->select ( 'wl.item_id' );
		$this->db->join ( 'item i', 'wl.item_id = i.item_id' );
		$this->db->where ( 'i.approved', '1');
		$this->db->where ( 'wl.person_id', $person_id );
		$this->db->where ( 'wl.item_id NOT IN (select item_item_id FROM owned_item WHERE person_id=' . $person_id . ')' );
		$this->db->where ( 'i.domain_id', $this->phpsession->get ( 'current_domain' )->getId () );
		$this->db->order_by ( 'order' );
		$query = $this->db->get ( 'wish_list wl' );
		$item_ids = array ();
		$retVal = array ('ids' => array (), 'names' => array () );
		
		foreach ( $query->result_array () as $row ) {
			$item_ids [] = $row ['item_id'];
		}
		
		if (count ( $item_ids ) > 0) {
			$item_vos = $this->getItems ( $item_ids );
		}
		
		$retVal = array ('ids' => array (), 'names' => array () );
		
		foreach ( $item_vos as $item ) {
			$retVal ['ids'] [] = $item->getItemid ();
			$retVal ['names'] [] = $item->getItem_label ();
		}
		return $retVal;
	}
}