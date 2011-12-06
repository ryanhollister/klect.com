<?php
class Item_filtering extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		is_logged_in();
	}
	
	/**
	 * AJAX method used to return results for autocomplete fields
	 * 
	 * @param $field name of field either in item table or a attribute
	 * @param $q entered text to autocomplete
	 */
	function autocomplete($field, $q)
	{
		$q = urldecode($q);
		$this->db->close();
		if (!$q) return;
		$retVal = array();
		if (strpos($field, '_input') != false)
		{
			$field = str_replace('_input', '', $field);
			$this->db->select("DISTINCT(ia.value)");
			$this->db->join("domain_attribute da", "da.domain_attribute_id=ia.domain_attribute_id");
			$this->db->like('value', $q, 'both');
			$this->db->where('da.domain_attribute_id',$field);
			$this->db->limit(10);
			$query = $this->db->get('item_attribute ia');
			if($query->num_rows > 0)
				{
					foreach ($query->result() as $key) {
						if (stripos($key->value, $q) !== false) {
							$retVal[] = array("label" => $key->value);
						}
					}
				}
		}
		else
		{
			$this->db->select('DISTINCT('.$field.'), item_id');
			$this->db->like($field, $q, 'both');
			$this->db->where('domain_id', $this->phpsession->get('current_domain')->getId());
			$this->db->limit(10);
			$query = $this->db->get('item');

			if($query->num_rows > 0)
			{
				foreach ($query->result() as $key) {
					if (stripos($key->$field, $q) !== false) {
						$retVal[] = array("label" => $key->$field);
					}
				}
			}
			
		}
		echo json_encode($retVal);
	}
	
	/**
	 * Filter collection used on the edit my collection page
	 * 
	 * @param $offset
	 */
	function filter_collection($offset = 0)
	{
		$this->load->model('item_model');
		$this->pagination->base_url = base_url()."members_area/edit_collection";
		$item_ids = array();
		$selects = array();
		$core_wheres = "";
		$and = "";
		$sql = "";
		$subselects = "";
		$data = $this->phpsession->get();
		$data['filter_ids']= array();
		$data['filter_values'] = false;
		
		foreach ($_POST as $attr_id => $attr_val)
		{
			// domain specific field?
			if ((strpos($attr_id, '_input') != false) && $attr_val != false)
			{
				$attr_val = addslashes($attr_val);
				$attr_id = str_replace('_input', '', $attr_id);
				$data['filter_values'][$attr_id] = $attr_val;
				$selects[] = "select item_id from item_attribute ia where ia.domain_attribute_id='$attr_id' AND ia.value=".$this->db->escape($attr_val);
			}
			elseif (strpos($attr_id, '_core') != false && $attr_val != false)
			{
				$attr_id = str_replace('_core', '', $attr_id);
				$attr_val = addslashes($attr_val);
				$data['filter_values'][$attr_id] = $attr_val;
				$core_wheres .= "$attr_id=".$this->db->escape($attr_val).$and;
				$and = " AND ";
			}
		}
		
		$and = "";
		if (count($selects) > 0)
		{
			foreach ($selects as $select)
			{
				$subselects .= $and." i.item_id IN (".$select.")";
				$and = " AND ";
			}
		}
		$and = "";
		if ($core_wheres != "" && $subselects != "")
		{
			$and = " AND ";
		}
		elseif ($core_wheres == "" && $subselects == "")
		{
			switch($this->input->post('source')) {
			case "edit_collection":
				$data['collection'] = $this->item_model->getPersonsItems(false, $offset);
				$this->load->view('modules/my_collection_item', $data);
				break;
			case "dashboard":
				$this->load->model('sale_model');
				$data['pending_sales'] = $this->sale_model->get_persons_pending();
				$data['active_sales'] = $this->sale_model->get_persons_active();
				$data['collection_items'] = $this->item_model->getPersonsItems(false, $offset);
				$this->load->view('modules/dashboard_item', $data);
				break;
			default:
				$data['collection'] = $this->item_model->getPersonsItems(false, $offset);
				$this->load->view('modules/my_collection_item', $data);
				break;
			}
			return;
		}
		
		$this->db->select('oi.owned_item_id');
		$this->db->distinct();
		$this->db->join('owned_item oi', 'i.item_id=oi.item_item_id');
		$this->db->where('i.domain_id', $this->phpsession->get('current_domain')->getId());
		$this->db->where($core_wheres.$and.$subselects, NULL, false);
		
		$query = $this->db->get('item i');

		foreach ($query->result() as $row)
		{
			$data['filter_ids'][] = $row->owned_item_id;
		}
		
		if ($query->num_rows() == 0)
		{
			$data['filter_ids'][] = -1;
		}

			switch($this->input->post('source')) {
			case "edit_collection":
				$data['collection'] = $this->item_model->getPersonsItems($data['filter_ids'], $offset);
				$this->load->view('modules/my_collection_item', $data);
				break;
			case "dashboard":
				$this->load->model('sale_model');
				$data['pending_sales'] = $this->sale_model->get_persons_pending();
				$data['active_sales'] = $this->sale_model->get_persons_active();
				$data['collection_items'] = $this->item_model->getPersonsItems($data['filter_ids'], $offset);
				$this->load->view('modules/dashboard_item', $data);
				break;
			default:
				$data['collection'] = $this->item_model->getPersonsItems($data['filter_ids'], $offset);
				$this->load->view('modules/my_collection_item', $data);
				break;
			}
	}
	
	/*
	 * Filtering used on all pages except edit collection.
	 */
	function filter($offset = 0)
	{
		$this->load->model('item_model');
		$area = explode('/', $_SERVER['HTTP_REFERER']); 
		$this->pagination->base_url = base_url()."members_area/".$area[0];
		$item_ids = array();
		$selects = array();
		$core_wheres = "";
		$and = "";
		$sql = "";
		$subselects = "";
		$data['filter_ids']= false;
		$data['filter_values'] = false;
		
		foreach ($_POST as $attr_id => $attr_val)
		{
			if ((strpos($attr_id, '_input') != false) && $attr_val != false)
			{
				$attr_id = str_replace('_input', '', $attr_id);
				$attr_val = addslashes($attr_val);
				$data['filter_values'][$attr_id] = $attr_val;
				$selects[] = "select item_id from item_attribute ia where ia.domain_attribute_id='$attr_id' AND ia.value=".$this->db->escape($attr_val)."";
			}
			elseif (strpos($attr_id, '_core') != false && $attr_val != false)
			{
				$attr_id = str_replace('_core', '', $attr_id);
				$attr_val = addslashes($attr_val);
				$data['filter_values'][$attr_id] = $attr_val;
				$core_wheres .= "$attr_id=".$this->db->escape($attr_val).$and;
				$and = " AND ";
			}
		}
		
		$and = "";
		if (count($selects) > 0)
		{
			foreach ($selects as $select)
			{
				$subselects .= $and." i.item_id IN (".$select.")";
				$and = " AND ";
			}
		}
		
		$and = "";
		if ($core_wheres != "" && $subselects != "")
		{
			$and = " AND ";
		}
		elseif ($core_wheres == "" && $subselects == "")
		{
			switch($this->input->post('source')) {
					case "addtocollection":
						$data['onClick'] = true;
						$data['catalog_items'] = $this->item_model->getItems(false, false, $offset);
						$this->load->view('modules/catalog_item', $data);
						break;
					case "wishlist":
						$data['onClick'] = true;
						$wishlist_array = $this->item_model->getwishlist();
						$data['wish_list'] = array(); // null to use client side list
						$data['wish_names'] = array();
						$data['catalog_items'] = $this->item_model->getUnownedItems(false, $offset);
						$this->load->view('modules/wish_list_item', $data);
						break;
					default:
						$data['catalog_items'] = $this->item_model->getItems(false, false, $offset);
						$this->load->view('modules/catalog_item', $data);
						break;
			}
			return;
		}

		$this->db->select('item_id');
		$this->db->distinct();
		$this->db->where('i.domain_id', $this->phpsession->get('current_domain')->getId());
		$this->db->where($core_wheres.$and.$subselects, NULL, false);
		
		$query = $this->db->get('item i');

		
		$data['filter_ids']= array();

		foreach ($query->result() as $row)
		{
			$data['filter_ids'][] = $row->item_id;
		}
		
		if ($query->num_rows() == 0)
		{
			$data['filter_ids'][] = -1;
		}
		
		switch($this->input->post('source')) {
			case "addtocollection":
				$data['onClick'] = true;
				$data['catalog_items'] = $this->item_model->getItems($data['filter_ids'], false, $offset);
				$this->load->view('modules/catalog_item', $data);
				break;
			case "wishlist":
				$data['onClick'] = true;
				$wishlist_array = $this->item_model->getwishlist();
				$data['wish_list'] = array(); // null to use client side list
				$data['wish_names'] = array();
				$data['catalog_items'] = $this->item_model->getUnownedItems($data['filter_ids'], $offset);
				$this->load->view('modules/wish_list_item', $data);
				break;
			case "dashboard":
				$data['pending_sales'] = $this->sale_model->get_persons_pending();
				$data['active_sales'] = $this->sale_model->get_persons_active();
				$data['collection_items'] = $this->item_model->getPersonsItems($data['filter_ids'], $offset);
				$this->load->view('modules/catalog_item', $data);
				break;
			default:
				$data['catalog_items'] = $this->item_model->getItems($data['filter_ids'], false, $offset);
				$this->load->view('modules/catalog_item', $data);
				break;
		}
	}
}
?>